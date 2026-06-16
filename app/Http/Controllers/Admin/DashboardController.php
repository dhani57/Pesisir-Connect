<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VendorCommissionLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        // 1. Total Nilai Transaksi / GMV (akumulasi Midtrans sukses)
        $totalRevenue = Transaction::where('status', 'paid')->sum('total_price');
        
        // 1b. Komisi Bersih Platform
        $netCommission = VendorCommissionLog::sum('commission_amount');

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

        // 7. Data Grafik Transaksi (6 Bulan Terakhir)
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();
        
        $driver = \DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $selectRaw = '
                strftime("%Y", created_at) as year,
                CAST(strftime("%m", created_at) as INTEGER) as month,
                SUM(total_price) as revenue,
                COUNT(id) as total_transactions
            ';
        } else {
            $selectRaw = '
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                SUM(total_price) as revenue,
                COUNT(id) as total_transactions
            ';
        }

        $monthlyTransactions = Transaction::selectRaw($selectRaw)
            ->where('status', 'paid')
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Format data untuk grafik
        $chartLabels = [];
        $chartRevenue = [];
        $chartCount = [];

        // Pastikan bulan yang kosong tetap ada (Fill empty months)
        for ($i = 0; $i < 6; $i++) {
            $date = now()->subMonths(5 - $i);
            $monthLabel = $date->translatedFormat('M Y');
            
            $data = $monthlyTransactions->firstWhere(function($item) use ($date) {
                return $item->year == $date->year && $item->month == $date->month;
            });

            $chartLabels[] = $monthLabel;
            $chartRevenue[] = $data ? (float) $data->revenue : 0;
            $chartCount[] = $data ? (int) $data->total_transactions : 0;
        }

        return view('admin.dashboard', compact(
            'totalRevenue', 
            'netCommission',
            'activeVendors', 
            'successfulTransactions',
            'pendingVendorsCount',
            'pendingVendors',
            'recentTransactions',
            'chartLabels',
            'chartRevenue',
            'chartCount'
        ));
    }
}
