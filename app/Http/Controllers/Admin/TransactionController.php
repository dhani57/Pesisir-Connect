<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\InvoiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionController extends Controller
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    /**
     * Display a listing of all global transactions with advanced filters.
     */
    public function index(Request $request): View
    {
        $query = Transaction::with(['customer', 'product.vendor.user']);

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', fn ($cq) => $cq->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
                  ->orWhereHas('product', fn ($pq) => $pq->where('name', 'like', "%{$search}%"));
            });
        }

        // Filter: payment status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter: vendor status
        if ($vendorStatus = $request->input('vendor_status')) {
            $query->where('vendor_status', $vendorStatus);
        }

        // Filter: vendor
        if ($vendorId = $request->input('vendor_id')) {
            $query->where('vendor_id', $vendorId);
        }

        // Filter: date range
        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Sort
        $sortBy = $request->input('sort', 'created_at');
        $sortDir = $request->input('dir', 'desc');
        $allowedSorts = ['created_at', 'total_price', 'status', 'vendor_status'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $perPage = $request->input('per_page', 15);
        $transactions = $query->paginate((int) $perPage)->withQueryString();

        // Summary stats for the filtered result
        $statusCounts = [
            'total'     => Transaction::count(),
            'paid'      => Transaction::where('status', 'paid')->count(),
            'pending'   => Transaction::where('status', 'pending')->count(),
            'cancelled' => Transaction::where('status', 'cancelled')->count(),
        ];

        // Available vendors for filter dropdown
        $vendors = \App\Models\Vendor::with('user')->get();

        return view('admin.transactions.index', compact('transactions', 'statusCounts', 'vendors'));
    }

    /**
     * Display transaction detail.
     */
    public function show(Transaction $transaction): View
    {
        $transaction->load(['customer', 'product.category', 'product.vendor', 'vendor.user']);

        // Get the review for this transaction (if exists)
        $review = \App\Models\VendorReview::where('transaction_id', $transaction->id)->with('user')->first();

        return view('admin.transactions.show', compact('transaction', 'review'));
    }

    /**
     * Override transaction status (admin privilege).
     */
    public function updateStatus(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'status'        => 'required|in:pending,paid,cancelled,refunded',
            'vendor_status' => 'nullable|in:pending,ready,completed,cancelled',
        ]);

        $updateData = ['status' => $validated['status']];

        if (isset($validated['vendor_status'])) {
            $updateData['vendor_status'] = $validated['vendor_status'];
        }

        // Set paid_at timestamp when marking as paid
        if ($validated['status'] === 'paid' && !$transaction->paid_at) {
            $updateData['paid_at'] = now();
        }

        // Set completed_at when vendor marks completed
        if (isset($validated['vendor_status']) && $validated['vendor_status'] === 'completed' && !$transaction->completed_at) {
            $updateData['completed_at'] = now();
        }

        $transaction->update($updateData);

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

    /**
     * Download invoice PDF (admin access).
     */
    public function downloadInvoice(Transaction $transaction): \Symfony\Component\HttpFoundation\Response
    {
        return $this->invoiceService->download($transaction);
    }

    /**
     * Export transactions to CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $query = Transaction::with(['customer', 'product.vendor.user']);

        // Apply same filters as index
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', fn ($cq) => $cq->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('product', fn ($pq) => $pq->where('name', 'like', "%{$search}%"));
            });
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($vendorStatus = $request->input('vendor_status')) {
            $query->where('vendor_status', $vendorStatus);
        }
        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        $filename = 'transaksi-pesisirconnect-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($transactions) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No. Invoice', 'Tanggal', 'Customer', 'Email Customer',
                'Produk', 'Vendor', 'Check-In', 'Check-Out',
                'Qty', 'Tamu', 'Harga Satuan', 'Total',
                'Status Bayar', 'Status Vendor', 'Metode Bayar',
                'Tanggal Bayar', 'Catatan',
            ]);

            foreach ($transactions as $trx) {
                fputcsv($handle, [
                    $trx->invoice_number,
                    $trx->created_at->format('Y-m-d H:i'),
                    $trx->customer->name ?? '-',
                    $trx->customer->email ?? '-',
                    $trx->product->name ?? '-',
                    $trx->product?->vendor?->user?->name ?? '-',
                    $trx->check_in?->format('Y-m-d') ?? '-',
                    $trx->check_out?->format('Y-m-d') ?? '-',
                    $trx->quantity,
                    $trx->guests,
                    $trx->unit_price,
                    $trx->total_price,
                    $trx->status,
                    $trx->vendor_status,
                    $trx->payment_method ?? '-',
                    $trx->paid_at?->format('Y-m-d H:i') ?? '-',
                    $trx->notes ?? '-',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
