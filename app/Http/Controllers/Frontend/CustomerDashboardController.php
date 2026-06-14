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

        // Recent transactions — eager load to prevent N+1
        $transactions = Transaction::where('user_id', $user->id)
            ->with(['product.category', 'product.vendor'])
            ->orderByDesc('created_at')
            ->paginate(10);

        // Check which transactions have already been reviewed by this user
        $reviewedTransactionIds = VendorReview::where('user_id', $user->id)
            ->pluck('transaction_id')
            ->toArray();

        return view('dashboard', compact('stats', 'transactions', 'reviewedTransactionIds'));
    }
}
