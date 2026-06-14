<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\OrderStatusRequest;
use App\Models\Transaction;
use App\Models\VendorNotification;
use App\Services\CommissionService;
use App\Services\InvoiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class VendorOrderController extends Controller
{
    public function __construct(
        private CommissionService $commissionService,
        private InvoiceService $invoiceService,
    ) {
    }

    /**
     * List vendor's orders with filters.
     */
    public function index(Request $request): View
    {
        $vendor = auth()->user()->vendor;

        $query = Transaction::where('vendor_id', $vendor->id)
            ->with(['customer', 'product']);

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', fn ($cq) => $cq->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('product', fn ($pq) => $pq->where('name', 'like', "%{$search}%"));
            });
        }

        // Filter by vendor status
        if ($vendorStatus = $request->input('vendor_status')) {
            $query->where('vendor_status', $vendorStatus);
        }

        // Filter by payment status
        if ($paymentStatus = $request->input('status')) {
            $query->where('status', $paymentStatus);
        }

        // Date range filter
        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Sort
        $sortBy = $request->input('sort', 'created_at');
        $sortDir = $request->input('dir', 'desc');
        $allowedSorts = ['created_at', 'total_price', 'vendor_status'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $orders = $query->paginate(20)->withQueryString();

        // Status counts
        $statusCounts = [
            'total'     => Transaction::where('vendor_id', $vendor->id)->count(),
            'pending'   => Transaction::where('vendor_id', $vendor->id)->where('vendor_status', 'pending')->count(),
            'ready'     => Transaction::where('vendor_id', $vendor->id)->where('vendor_status', 'ready')->count(),
            'completed' => Transaction::where('vendor_id', $vendor->id)->where('vendor_status', 'completed')->count(),
            'cancelled' => Transaction::where('vendor_id', $vendor->id)->where('vendor_status', 'cancelled')->count(),
            'today'     => Transaction::where('vendor_id', $vendor->id)->whereDate('created_at', today())->count(),
        ];

        return view('vendor.orders.index', compact('orders', 'vendor', 'statusCounts'));
    }

    /**
     * Show order detail.
     */
    public function show(Transaction $transaction): View
    {
        $this->authorize('view', $transaction);

        $vendor = auth()->user()->vendor;
        $transaction->load(['customer', 'product']);

        return view('vendor.orders.show', compact('transaction', 'vendor'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(OrderStatusRequest $request, Transaction $transaction): RedirectResponse
    {
        $this->authorize('updateStatus', $transaction);

        $vendor = auth()->user()->vendor;

        $newStatus = $request->validated()['vendor_status'];
        $transaction->update([
            'vendor_status' => $newStatus,
            'completed_at'  => $newStatus === 'completed' ? now() : $transaction->completed_at,
        ]);

        // If completed, calculate commission
        if ($newStatus === 'completed') {
            try {
                $this->commissionService->calculateCommission($transaction);
            } catch (\Exception $e) {
                // Log but don't fail
                logger()->error('Commission calculation failed: ' . $e->getMessage());
            }
        }

        $statusLabels = [
            'pending'   => 'Menunggu',
            'ready'     => 'Siap',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return back()->with('success', 'Status pesanan berhasil diubah menjadi: ' . ($statusLabels[$newStatus] ?? $newStatus));
    }

    /**
     * Send invoice to customer.
     */
    public function sendInvoice(Transaction $transaction): RedirectResponse
    {
        $this->authorize('sendInvoice', $transaction);

        $transaction->load(['customer', 'product.category', 'vendor.user']);

        if (!$transaction->customer?->email) {
            return back()->with('error', 'Pelanggan tidak memiliki alamat email.');
        }

        try {
            $pdfContent = $this->invoiceService->toRaw($transaction);
            $filename = 'Invoice-' . $transaction->invoice_number . '.pdf';

            Mail::raw(
                'Terlampir invoice untuk pesanan #' . $transaction->invoice_number . '. Terima kasih telah menggunakan PesisirConnect.',
                function ($message) use ($transaction, $pdfContent, $filename) {
                    $message->to($transaction->customer->email, $transaction->customer->name)
                        ->subject('Invoice Pesanan #' . $transaction->invoice_number . ' — PesisirConnect')
                        ->attachData($pdfContent, $filename, ['mime' => 'application/pdf']);
                }
            );

            return back()->with('success', 'Invoice berhasil dikirim ke ' . $transaction->customer->email);
        } catch (\Exception $e) {
            logger()->error('Send invoice failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim invoice. Silakan coba lagi.');
        }
    }

    /**
     * Add vendor notes to an order.
     */
    public function addNotes(Request $request, Transaction $transaction): RedirectResponse
    {
        $this->authorize('updateStatus', $transaction);

        $request->validate(['vendor_notes' => 'required|string|max:1000']);
        $transaction->update(['vendor_notes' => $request->input('vendor_notes')]);

        return back()->with('success', 'Catatan berhasil ditambahkan.');
    }

    /**
     * Download invoice PDF for a transaction.
     */
    public function downloadInvoice(Transaction $transaction): \Symfony\Component\HttpFoundation\Response
    {
        $this->authorize('downloadInvoice', $transaction);

        return $this->invoiceService->download($transaction);
    }
}
