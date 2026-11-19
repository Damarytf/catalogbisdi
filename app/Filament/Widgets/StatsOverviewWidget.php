<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $completedTotal = Order::where('status', 'completed')->sum('total_amount');
        $pendingTotal = Order::whereIn('status', ['pending', 'in_chat'])->sum('total_amount');
        $pendingCount = Order::where('status', 'pending')->count();
        $totalOrders = Order::count();
        $completedCount = Order::where('status', 'completed')->count();

        $conversionRate = $totalOrders > 0
            ? round(($completedCount / $totalOrders) * 100, 1)
            : 0;

        return [
            Stat::make('Total Omzet Terverifikasi', 'Rp ' . number_format($completedTotal, 0, ',', '.'))
                ->description("Dari {$completedCount} pesanan selesai")
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Potensi Omzet (Follow-up WA)', 'Rp ' . number_format($pendingTotal, 0, ',', '.'))
                ->description("{$pendingCount} pesanan baru menunggu verifikasi")
                ->descriptionIcon('heroicon-m-chat-bubble-bottom-center-text')
                ->color($pendingCount > 0 ? 'warning' : 'gray'),

            Stat::make('Konversi Penjualan WA', "{$conversionRate}%")
                ->description("Rasio checkout berhasil dibayar")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($conversionRate >= 50 ? 'success' : 'info'),

            Stat::make('Total Katalog Aktif', Product::active()->count())
                ->description('Produk digital siap pesan')
                ->descriptionIcon('heroicon-m-cube')
                ->color('gray'),
        ];
    }
}
