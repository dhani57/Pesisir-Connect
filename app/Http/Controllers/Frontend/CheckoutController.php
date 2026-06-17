<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderCreatedMail;
use App\Mail\PaymentReceivedMail;
use App\Mail\VendorNewOrderMail;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\VendorNotification;
use App\Services\MidtransService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

/**
 * CheckoutController
 *
 * Handles the complete checkout flow:
 * 1. Show checkout review page
 * 2. Process payment (create transaction + Midtrans Snap token)
 * 3. Handle Midtrans webhook notifications
 * 4. Show post-payment result pages
 */
class CheckoutController extends Controller
{
    public function __construct(private MidtransService $midtransService)
    {
    }

    /**
     * Show the checkout review page.
     */
    public function show(string $slug, Request $request): View|RedirectResponse
    {
        $product = Product::active()
            ->with(['category', 'vendor'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Validate that product has stock
        if ($product->stock !== null && $product->stock <= 0) {
            return redirect()->route('produk.detail', $slug)
                ->with('error', 'Maaf, produk ini sedang tidak tersedia.');
        }

        // Get booking data from the product detail form
        $checkIn  = $request->input('tanggal', old('tanggal'));
        $quantity = max(1, (int) $request->input('jumlah', old('jumlah', 1)));

        // Calculate check-out (next day for per-night, same day for per-trip/set)
        $nightBased = in_array($product->price_unit, ['malam', 'night']);
        $checkOut   = $checkIn
            ? date('Y-m-d', strtotime($checkIn . ($nightBased ? ' +1 day' : '')))
            : null;

        $unitPrice  = $product->discounted_price;
        $totalPrice = $unitPrice * $quantity;

        return view('frontend.checkout', compact(
            'product',
            'checkIn',
            'checkOut',
            'quantity',
            'unitPrice',
            'totalPrice',
        ));
    }

    /**
     * Process checkout — create transaction and get Midtrans Snap token.
     */
    public function process(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'check_in'   => 'required|date|after_or_equal:today',
            'check_out'  => 'required|date|after_or_equal:check_in',
            'quantity'    => 'required|integer|min:1',
            'guests'     => 'nullable|integer|min:1',
            'notes'      => 'nullable|string|max:500',
        ]);

        $product = Product::with('vendor')->findOrFail($validated['product_id']);

        // Verify stock availability
        if ($product->stock !== null && $product->stock < $validated['quantity']) {
            return back()->with('error', 'Stok tidak mencukupi. Tersisa ' . $product->stock . ' unit.');
        }

        $unitPrice  = $product->discounted_price;
        $totalPrice = $unitPrice * $validated['quantity'];

        try {
            $transaction = DB::transaction(function () use ($validated, $product, $unitPrice, $totalPrice) {
                // Decrement stock
                if ($product->stock !== null) {
                    $product->decrement('stock', $validated['quantity']);
                }

                return Transaction::create([
                    'user_id'     => auth()->id(),
                    'product_id'  => $product->id,
                    'vendor_id'   => $product->vendor_id,
                    'check_in'    => $validated['check_in'],
                    'check_out'   => $validated['check_out'],
                    'quantity'    => $validated['quantity'],
                    'guests'      => $validated['guests'] ?? $validated['quantity'],
                    'unit_price'  => $unitPrice,
                    'total_price' => $totalPrice,
                    'status'      => 'pending',
                    'vendor_status' => 'pending',
                    'payment_method' => 'midtrans',
                    'notes'       => $validated['notes'] ?? null,
                ]);
            });

            // Send order created email to customer
            Mail::to($transaction->customer)->send(new OrderCreatedMail($transaction));

            // Generate Midtrans Snap token
            $snap = $this->midtransService->createSnapToken($transaction);

            // Save snap token to database
            $transaction->update(['snap_token' => $snap['token']]);

            return view('frontend.payment', [
                'transaction' => $transaction->load(['product', 'customer']),
                'snapToken'   => $snap['token'],
                'clientKey'   => $this->midtransService->getClientKey(),
            ]);
        } catch (\Exception $e) {
            logger()->error('Checkout failed: ' . $e->getMessage(), [
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
                'trace'      => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * Resume a pending payment.
     */
    public function resumePayment(string $invoiceNumber): View|RedirectResponse
    {
        $transaction = Transaction::with(['product', 'customer'])
            ->where('invoice_number', $invoiceNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Only pending transactions can be resumed
        if ($transaction->status !== 'pending') {
            return redirect()->route('dashboard')->with('error', 'Transaksi ini tidak dapat dilanjutkan pembayarannya karena statusnya bukan menunggu.');
        }

        $snapToken = $transaction->snap_token;

        if (!$snapToken) {
            try {
                // Menghindari error "order_id sudah digunakan" dari Midtrans untuk transaksi lama
                $newInvoiceNumber = 'PC-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
                $transaction->update(['invoice_number' => $newInvoiceNumber]);

                $snap = $this->midtransService->createSnapToken($transaction);
                $snapToken = $snap['token'];
                $transaction->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                logger()->error('Resume payment failed: ' . $e->getMessage());
                return redirect()->route('dashboard')->with('error', 'Terjadi kesalahan saat memuat ulang pembayaran. Silakan coba lagi.');
            }
        }

        return view('frontend.payment', [
            'transaction' => $transaction,
            'snapToken'   => $snapToken,
            'clientKey'   => $this->midtransService->getClientKey(),
        ]);
    }

    /**
     * Handle Midtrans payment notification webhook.
     *
     * This endpoint is called by Midtrans servers, NOT by the user's browser.
     */
    public function notification(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $this->midtransService->handleNotification();

            $transaction = Transaction::where('invoice_number', $data['order_id'])->first();

            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Prevent processing already-completed transactions
            if (in_array($transaction->status, ['paid', 'completed', 'refunded'], true)) {
                return response()->json(['message' => 'Already processed'], 200);
            }

            $transactionStatus = $data['transaction_status'];
            $fraudStatus       = $data['fraud_status'];

            if ($this->midtransService->isPaymentSuccess($transactionStatus, $fraudStatus)) {
                $this->handlePaymentSuccess($transaction, $data);
            } elseif ($this->midtransService->isPaymentPending($transactionStatus)) {
                // Status stays 'pending', nothing to update
            } elseif ($this->midtransService->isPaymentFailed($transactionStatus)) {
                $this->handlePaymentFailed($transaction, $data);
            }

            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            logger()->error('Midtrans notification error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    /**
     * Post-payment finish page (redirect from Midtrans Snap).
     */
    public function finish(string $invoiceNumber, Request $request): View|RedirectResponse
    {
        $transaction = Transaction::with(['product.vendor', 'customer'])
            ->where('invoice_number', $invoiceNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('frontend.payment-finish', compact('transaction'));
    }

    /**
     * Handle successful payment.
     */
    private function handlePaymentSuccess(Transaction $transaction, array $data): void
    {
        $transaction->update([
            'status'                 => 'paid',
            'paid_at'                => now(),
            'midtrans_transaction_id' => $data['transaction_id'] ?? null,
            'midtrans_payment_type'  => $data['payment_type'] ?? null,
            'midtrans_response'      => $data['raw'] ?? null,
        ]);

        // Email customer: payment confirmed
        $transaction->load(['customer', 'product', 'vendor.user']);
        Mail::to($transaction->customer)->send(new PaymentReceivedMail($transaction));

        // Notify the vendor about the new paid order
        if ($transaction->vendor_id) {
            VendorNotification::send(
                $transaction->vendor_id,
                'payment_received',
                'Pembayaran Diterima! 💰',
                'Pembayaran untuk pesanan #' . $transaction->invoice_number .
                ' sebesar Rp ' . number_format($transaction->total_price, 0, ',', '.') .
                ' telah berhasil diterima.',
                route('vendor.orders.show', $transaction->id)
            );

            // Email vendor: new paid order
            if ($transaction->vendor?->user?->email) {
                Mail::to($transaction->vendor->user)->send(new VendorNewOrderMail($transaction));
            }
        }
    }

    /**
     * Handle failed/cancelled/expired payment — restore stock.
     */
    private function handlePaymentFailed(Transaction $transaction, array $data): void
    {
        $transaction->update([
            'status'            => 'cancelled',
            'midtrans_response' => $data['raw'] ?? null,
        ]);

        // Restore stock
        $product = $transaction->product;
        if ($product && $product->stock !== null) {
            $product->increment('stock', $transaction->quantity);
        }
    }
}
