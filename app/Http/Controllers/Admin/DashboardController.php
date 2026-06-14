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

        // 4. Vendor Menunggu Verifikasi
        $pendingVendorsCount = User::where('role', 'vendor')->where('is_active', false)->count();

        // 5. Vendor Baru Menunggu Verifikasi (Tabel)
        $pendingVendors = User::where('role', 'vendor')->where('is_active', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 6. Transaksi Terbaru
        $recentTransactions = Transaction::with(['customer', 'product', 'vendor.user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 
            'activeVendors', 
            'successfulTransactions',
            'pendingVendorsCount',
            'pendingVendors',
            'recentTransactions'
        ));
    }
}
