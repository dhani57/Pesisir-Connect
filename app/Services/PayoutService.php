<?php

namespace App\Services;

use App\Models\Vendor;
use App\Models\VendorNotification;
use App\Models\VendorPayout;
use Illuminate\Support\Facades\DB;

class PayoutService
{
    /** Minimum payout threshold in IDR. */
    public const MIN_PAYOUT = 100000;

    /**
     * Request a payout for a vendor.
     */
    public function requestPayout(Vendor $vendor): VendorPayout
    {
        $pendingEarnings = $vendor->commissionLogs()
            ->where('status', 'calculated')
            ->sum('vendor_earning');

        if ($pendingEarnings < self::MIN_PAYOUT) {
            throw new \RuntimeException(
                'Saldo minimum untuk pencairan adalah Rp ' . number_format(self::MIN_PAYOUT, 0, ',', '.') .
                '. Saldo Anda saat ini: Rp ' . number_format($pendingEarnings, 0, ',', '.')
            );
        }

        return DB::transaction(function () use ($vendor, $pendingEarnings) {
            $payout = VendorPayout::create([
                'vendor_id'      => $vendor->id,
                'amount'         => $pendingEarnings,
                'period_start'   => $vendor->commissionLogs()->where('status', 'calculated')->min('created_at') ?? now(),
                'period_end'     => now(),
                'bank_name'      => $vendor->bank_name,
                'account_number' => $vendor->account_number,
                'account_holder' => $vendor->account_holder,
                'status'         => 'pending',
            ]);

            // Mark commission logs as paid
            $vendor->commissionLogs()
                ->where('status', 'calculated')
                ->update(['status' => 'paid', 'paid_at' => now()]);

            VendorNotification::send(
                $vendor->id,
                'payout_processed',
                'Permintaan Pencairan Dikirim',
                'Permintaan pencairan sebesar Rp ' . number_format($pendingEarnings, 0, ',', '.') .
                ' telah dikirim dan sedang diproses.',
                route('vendor.earnings.index')
            );

            return $payout;
        });
    }

    /**
     * Get payment history for a vendor.
     */
    public function getPaymentHistory(Vendor $vendor, int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $vendor->payouts()
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }
}
