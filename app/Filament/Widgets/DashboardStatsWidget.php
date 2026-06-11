<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalRevenue = Transaction::whereIn('status', ['paid', 'success'])->sum('total_price');
        $activeVendors = User::where('role', 'vendor')->where('is_active', true)->count();
        $successfulTransactions = Transaction::whereIn('status', ['paid', 'success'])->count();

        return [
            Stat::make('Total Pendapatan Platform', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Total dari transaksi sukses')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Total Vendor Aktif', $activeVendors)
                ->description('Vendor yang telah diapprove')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
                
            Stat::make('Total Transaksi Sukses', $successfulTransactions)
                ->description('Transaksi yang sudah dibayar')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
