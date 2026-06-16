<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Vendor;
use App\Models\VendorCommissionLog;

class CommissionService
{
    /**
     * Calculate and log commission for a completed transaction.
     */
    public function calculateCommission(Transaction $transaction): VendorCommissionLog
    {
        $vendor = $transaction->vendor;
        if (!$vendor) {
            throw new \RuntimeException('Transaction has no vendor assigned.');
        }

        $amount = (float) $transaction->total_price;
        $rate = $vendor->effective_commission_rate;
        
        $commissionAmount = round($amount * ($rate / 100), 2);
        $vendorEarning = round($amount - $commissionAmount, 2);

        $log = VendorCommissionLog::create([
            'vendor_id'             => $vendor->id,
            'transaction_id'       => $transaction->id,
            'amount'               => $amount,
            'commission_percentage' => $rate,
            'commission_amount'    => $commissionAmount,
            'vendor_earning'       => $vendorEarning,
            'status'               => 'calculated',
        ]);

        // Update vendor total earnings
        $vendor->increment('total_earnings', $vendorEarning);

        return $log;
    }

    /**
     * Get earnings summary for a vendor.
     */
    public function getEarningsSummary(Vendor $vendor): array
    {
        $now = now();

        $thisMonth = $vendor->commissionLogs()
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('vendor_earning');

        $lastMonth = $vendor->commissionLogs()
            ->whereMonth('created_at', $now->copy()->subMonth()->month)
            ->whereYear('created_at', $now->copy()->subMonth()->year)
            ->sum('vendor_earning');

        $allTime = $vendor->commissionLogs()->sum('vendor_earning');
        $pending = $vendor->commissionLogs()->where('status', 'calculated')->sum('vendor_earning');

        return [
            'this_month' => $thisMonth,
            'last_month' => $lastMonth,
            'all_time'   => $allTime,
            'pending'    => $pending,
            'commission_rate' => $vendor->effective_commission_rate,
        ];
    }

    /**
     * Get earnings breakdown by product.
     */
    public function earningsByProduct(Vendor $vendor, ?string $startDate = null, ?string $endDate = null): \Illuminate\Support\Collection
    {
        $query = $vendor->commissionLogs()->with('transaction.product');

        if ($startDate) $query->where('created_at', '>=', $startDate);
        if ($endDate)   $query->where('created_at', '<=', $endDate);

        return $query->get()
            ->groupBy(fn ($log) => $log->transaction->product->name ?? 'Unknown')
            ->map(fn ($group) => [
                'total_sales'    => $group->sum('amount'),
                'total_earning'  => $group->sum('vendor_earning'),
                'total_commission' => $group->sum('commission_amount'),
                'count'          => $group->count(),
            ])
            ->sortByDesc('total_earning');
    }
}
