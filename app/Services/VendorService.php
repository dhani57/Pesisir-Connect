<?php

namespace App\Services;

use App\Models\Vendor;
use App\Models\VendorNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VendorService
{
    /**
     * Create a new vendor profile for the given user.
     */
    public function createVendor(int $userId, array $data): Vendor
    {
        return DB::transaction(function () use ($userId, $data) {
            // Update user role to vendor
            $user = \App\Models\User::findOrFail($userId);
            $user->update(['role' => 'vendor']);

            // Handle file uploads
            $logoPath = null;
            $licensePath = null;

            if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
                $logoPath = \App\Services\ImageService::compressAndConvertToWebp($data['logo'], 'vendors/logos');
            }

            if (isset($data['business_license']) && $data['business_license'] instanceof UploadedFile) {
                $licensePath = $data['business_license']->store('vendors/licenses', 'public');
            }

            // Create vendor profile
            $vendor = Vendor::create([
                'user_id'          => $userId,
                'shop_name'        => $data['shop_name'],
                'business_type'    => $data['business_type'] ?? null,
                'phone'            => $data['phone'],
                'address'          => $data['address'] ?? null,
                'city'             => $data['city'] ?? null,
                'zip_code'         => $data['zip_code'] ?? null,
                'bank_name'        => $data['bank_name'] ?? null,
                'account_holder'   => $data['account_holder'] ?? null,
                'account_number'   => $data['account_number'] ?? null,
                'logo'             => $logoPath,
                'bio'              => $data['bio'] ?? null,
                'business_license' => $licensePath ? 'storage/' . $licensePath : null,
                'status'           => 'pending_approval',
                'is_approved'      => false,
            ]);

            return $vendor;
        });
    }

    /**
     * Update vendor profile.
     */
    public function updateVendor(Vendor $vendor, array $data): Vendor
    {
        // Handle logo upload
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            // Delete old logo
            if ($vendor->logo) {
                $oldPath = str_replace('storage/', '', $vendor->logo);
                Storage::disk('public')->delete($oldPath);
            }
            $data['logo'] = \App\Services\ImageService::compressAndConvertToWebp($data['logo'], 'vendors/logos');
        }

        // Handle avatar upload
        if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            if ($vendor->avatar) {
                $oldPath = str_replace('storage/', '', $vendor->avatar);
                Storage::disk('public')->delete($oldPath);
            }
            $data['avatar'] = \App\Services\ImageService::compressAndConvertToWebp($data['avatar'], 'vendors/avatars');
        }

        // Handle business license upload
        if (isset($data['business_license']) && $data['business_license'] instanceof UploadedFile) {
            if ($vendor->business_license) {
                $oldPath = str_replace('storage/', '', $vendor->business_license);
                Storage::disk('public')->delete($oldPath);
            }
            $licensePath = $data['business_license']->store('vendors/licenses', 'public');
            $data['business_license'] = 'storage/' . $licensePath;
        }

        // Remove any UploadedFile instances that weren't processed
        $data = array_filter($data, fn ($value) => !($value instanceof UploadedFile));

        $vendor->update($data);
        return $vendor->fresh();
    }

    /**
     * Approve a vendor.
     */
    public function approveVendor(Vendor $vendor): void
    {
        $vendor->update([
            'status'      => 'approved',
            'is_approved' => true,
            'verified_at' => now(),
        ]);

        VendorNotification::send(
            $vendor->id,
            'approval_status',
            'Toko Anda Disetujui!',
            'Selamat! Toko "' . $vendor->shop_name . '" telah disetujui oleh admin. Anda sekarang bisa mulai menambahkan produk dan menerima pesanan.',
            route('vendor.dashboard')
        );
    }

    /**
     * Suspend a vendor.
     */
    public function suspendVendor(Vendor $vendor, string $reason = ''): void
    {
        $vendor->update([
            'status'      => 'suspended',
            'is_approved' => false,
        ]);

        VendorNotification::send(
            $vendor->id,
            'approval_status',
            'Toko Anda Ditangguhkan',
            'Toko "' . $vendor->shop_name . '" telah ditangguhkan. ' . ($reason ?: 'Silakan hubungi admin untuk informasi lebih lanjut.'),
        );
    }

    /**
     * Get vendor dashboard statistics.
     */
    public function getDashboardStats(Vendor $vendor): array
    {
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // Revenue calculations
        $revenueThisMonth = $vendor->commissionLogs()
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('vendor_earning');

        $revenueLastMonth = $vendor->commissionLogs()
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('vendor_earning');

        $revenueThisYear = $vendor->commissionLogs()
            ->whereYear('created_at', $now->year)
            ->sum('vendor_earning');

        $growthPercentage = $revenueLastMonth > 0
            ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 1)
            : 0;

        // Order counts
        $pendingOrders = $vendor->transactions()->where('vendor_status', 'pending')->count();
        $readyOrders = $vendor->transactions()->where('vendor_status', 'ready')->count();
        $completedThisMonth = $vendor->transactions()
            ->where('vendor_status', 'completed')
            ->whereBetween('completed_at', [$startOfMonth, $endOfMonth])
            ->count();
        $cancelledOrders = $vendor->transactions()->where('vendor_status', 'cancelled')->count();

        // Product stats
        $totalProducts = $vendor->products()->count();
        $outOfStock = $vendor->products()->where('stock', '<=', 0)->count();
        $topSellingProduct = $vendor->products()
            ->withCount('transactions')
            ->orderByDesc('transactions_count')
            ->first();

        // Recent orders
        $recentOrders = $vendor->transactions()
            ->with(['customer', 'product'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // Top products
        $topProducts = $vendor->products()
            ->withCount('transactions')
            ->withSum('transactions', 'total_price')
            ->orderByDesc('transactions_count')
            ->take(5)
            ->get();

        // Charts data: Sales last 30 days
        $salesDataRaw = $vendor->commissionLogs()
            ->where('created_at', '>=', $now->copy()->subDays(29)->startOfDay())
            ->selectRaw('DATE(created_at) as date, SUM(vendor_earning) as total')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $salesData = [];
        for ($i = 29; $i >= 0; $i--) {
            $dateStr = $now->copy()->subDays($i)->format('Y-m-d');
            $salesData[$dateStr] = $salesDataRaw[$dateStr] ?? 0;
        }

        // Order status distribution
        $orderStatusDistribution = [
            'Menunggu'    => $pendingOrders,
            'Siap'        => $readyOrders,
            'Selesai'     => $completedThisMonth,
            'Dibatalkan'  => $cancelledOrders,
        ];

        return compact(
            'revenueThisMonth', 'revenueLastMonth', 'revenueThisYear', 'growthPercentage',
            'pendingOrders', 'readyOrders', 'completedThisMonth', 'cancelledOrders',
            'totalProducts', 'outOfStock', 'topSellingProduct',
            'recentOrders', 'topProducts',
            'salesData', 'orderStatusDistribution'
        );
    }
}
