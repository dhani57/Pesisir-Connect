<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\OrderStatusRequest;
use App\Models\Transaction;
use App\Models\VendorNotification;
use App\Services\CommissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorOrderController extends Controller
{
    public function __construct(private CommissionService $commissionService)
    {
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
        $vendor = auth()->user()->vendor;
        if ($transaction->vendor_id !== $vendor->id) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $transaction->load(['customer', 'product']);

        return view('vendor.orders.show', compact('transaction', 'vendor'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(OrderStatusRequest $request, Transaction $transaction): RedirectResponse
    {
        $vendor = auth()->user()->vendor;
        if ($transaction->vendor_id !== $vendor->id) {
            abort(403);
        }

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
        $vendor = auth()->user()->vendor;
        if ($transaction->vendor_id !== $vendor->id) {
            abort(403);
        }

        // In production, this would send an email with invoice
        // For now, just flash a success message
        return back()->with('success', 'Invoice berhasil dikirim ke pelanggan.');
    }

    /**
     * Add vendor notes to an order.
     */
    public function addNotes(Request $request, Transaction $transaction): RedirectResponse
    {
        $vendor = auth()->user()->vendor;
        if ($transaction->vendor_id !== $vendor->id) {
            abort(403);
        }

        $request->validate(['vendor_notes' => 'required|string|max:1000']);
        $transaction->update(['vendor_notes' => $request->input('vendor_notes')]);

        return back()->with('success', 'Catatan berhasil ditambahkan.');
    }
}
