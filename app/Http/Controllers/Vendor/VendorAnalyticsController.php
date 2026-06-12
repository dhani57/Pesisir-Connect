<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\VendorCommissionLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorAnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        $vendor = auth()->user()->vendor;
        $range = $request->input('range', '30');
        $startDate = match ($range) {
            '7'  => now()->subDays(7), '30' => now()->subDays(30),
            '90' => now()->subDays(90), default => now()->subDays(30),
        };
        $endDate = now();

        $totalSales = $vendor->commissionLogs()->whereBetween('created_at', [$startDate, $endDate])->sum('vendor_earning');
        $totalOrders = $vendor->transactions()->whereBetween('created_at', [$startDate, $endDate])->count();
        $avgOrderValue = $totalOrders > 0 ? $vendor->transactions()->whereBetween('created_at', [$startDate, $endDate])->avg('total_price') : 0;
        $totalCustomers = $vendor->transactions()->whereBetween('created_at', [$startDate, $endDate])->distinct('user_id')->count('user_id');
        $repeatCustomers = $vendor->transactions()->whereBetween('created_at', [$startDate, $endDate])->select('user_id')->groupBy('user_id')->havingRaw('COUNT(*) > 1')->get()->count();
        $repeatRate = $totalCustomers > 0 ? round(($repeatCustomers / $totalCustomers) * 100, 1) : 0;
        $avgRating = $vendor->average_rating;
        $reviewCount = $vendor->reviews()->whereBetween('created_at', [$startDate, $endDate])->count();
        $responseRate = $reviewCount > 0 ? round(($vendor->reviews()->whereBetween('created_at', [$startDate, $endDate])->whereNotNull('vendor_reply')->count() / $reviewCount) * 100, 1) : 0;

        $revenueTrend = $vendor->commissionLogs()->whereBetween('created_at', [$startDate, $endDate])->selectRaw('DATE(created_at) as date, SUM(vendor_earning) as total')->groupBy('date')->orderBy('date')->pluck('total', 'date')->toArray();
        $ordersTrend = $vendor->transactions()->whereBetween('created_at', [$startDate, $endDate])->selectRaw('DATE(created_at) as date, COUNT(*) as total')->groupBy('date')->orderBy('date')->pluck('total', 'date')->toArray();
        $topProducts = $vendor->products()->withCount(['transactions' => fn ($q) => $q->whereBetween('transactions.created_at', [$startDate, $endDate])])->withSum(['transactions' => fn ($q) => $q->whereBetween('transactions.created_at', [$startDate, $endDate])], 'total_price')->orderByDesc('transactions_count')->take(10)->get();
        $orderStatusDist = ['Menunggu' => $vendor->transactions()->whereBetween('created_at', [$startDate, $endDate])->where('vendor_status', 'pending')->count(), 'Siap' => $vendor->transactions()->whereBetween('created_at', [$startDate, $endDate])->where('vendor_status', 'ready')->count(), 'Selesai' => $vendor->transactions()->whereBetween('created_at', [$startDate, $endDate])->where('vendor_status', 'completed')->count(), 'Dibatalkan' => $vendor->transactions()->whereBetween('created_at', [$startDate, $endDate])->where('vendor_status', 'cancelled')->count()];
        $paymentMethods = $vendor->transactions()->whereBetween('created_at', [$startDate, $endDate])->selectRaw('payment_method, COUNT(*) as total')->groupBy('payment_method')->pluck('total', 'payment_method')->toArray();
        $newCustomers = $totalCustomers - $repeatCustomers;

        return view('vendor.analytics', compact('vendor', 'range', 'startDate', 'endDate', 'totalSales', 'totalOrders', 'avgOrderValue', 'totalCustomers', 'repeatRate', 'avgRating', 'responseRate', 'revenueTrend', 'ordersTrend', 'topProducts', 'orderStatusDist', 'paymentMethods', 'newCustomers', 'repeatCustomers'));
    }

    public function export(Request $request)
    {
        $vendor = auth()->user()->vendor;
        $logs = $vendor->commissionLogs()->with('transaction.product')->orderByDesc('created_at')->get();
        $filename = 'analytics_' . now()->format('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="' . $filename . '"'];
        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Produk', 'Total', 'Komisi', 'Pendapatan', 'Status']);
            foreach ($logs as $log) {
                fputcsv($file, [$log->created_at->format('d/m/Y'), $log->transaction->product->name ?? '-', $log->amount, $log->commission_amount, $log->vendor_earning, $log->status]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
