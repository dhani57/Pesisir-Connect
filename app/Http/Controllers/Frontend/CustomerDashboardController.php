<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\VendorReview;
use Illuminate\View\View;

/**
 * CustomerDashboardController
 *
 * Provides the authenticated customer with their dashboard data:
 * - Transaction history with eager-loaded relations
 * - Summary statistics (total bookings, active, completed, total spent)
 */
class CustomerDashboardController extends Controller
{
    /**
     * Show the customer dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();

        // Summary stats
        $stats = [
            'total_bookings' => Transaction::where('user_id', $user->id)->count(),
            'active_bookings' => Transaction::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'paid', 'confirmed'])
                ->whereIn('vendor_status', ['pending', 'ready'])
                ->count(),
            'completed' => Transaction::where('user_id', $user->id)
                ->where('vendor_status', 'completed')
                ->count(),
            'total_spent' => Transaction::where('user_id', $user->id)
                ->where('status', 'paid')
                ->sum('total_price'),
        ];

        // Pagination logic
        $perPage = request('per_page', 10);
        $query = Transaction::where('user_id', $user->id)
            ->with(['product.category', 'product.vendor'])
            ->orderByDesc('created_at');

        $transactions = $perPage === 'all' 
            ? $query->paginate($query->count() > 0 ? $query->count() : 1)
            : $query->paginate((int) $perPage);

        // Check which transactions have already been reviewed by this user
        $reviewedTransactionIds = VendorReview::where('user_id', $user->id)
            ->pluck('transaction_id')
            ->toArray();

        return view('dashboard', compact('stats', 'transactions', 'reviewedTransactionIds'));
    }

    /**
     * Show the E-Ticket for a specific paid/completed transaction.
     */
    public function ticket(string $invoiceNumber): View
    {
        $transaction = Transaction::where('invoice_number', $invoiceNumber)
            ->where('user_id', auth()->id())
            ->with(['product.vendor.user', 'customer'])
            ->firstOrFail();

        // Only paid or completed transactions have an active ticket
        if (!in_array($transaction->status, ['paid', 'completed'])) {
            abort(403, 'Tiket belum tersedia atau pesanan dibatalkan.');
        }

        return view('frontend.ticket', compact('transaction'));
    }
}
