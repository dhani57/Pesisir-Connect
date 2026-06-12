<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        // 1. Total Pendapatan Platform (akumulasi Midtrans sukses)
        $totalRevenue = Transaction::where('status', 'paid')->sum('total_price');
        
        // 2. Total Vendor Aktif
        $activeVendors = User::where('role', 'vendor')->where('is_active', true)->count();
        
        // 3. Total Transaksi Sukses
        $successfulTransactions = Transaction::where('status', 'paid')->count();

        return view('admin.dashboard', compact('totalRevenue', 'activeVendors', 'successfulTransactions'));
    }
}
