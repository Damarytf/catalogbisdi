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

        $monthlyClicks = \App\Models\ProductClick::whereBetween('created_at', [
            \Illuminate\Support\Carbon::now()->startOfMonth(),
            \Illuminate\Support\Carbon::now()->endOfMonth()
        ])->count();

        return [
            Stat::make('Kunjungan Produk (Bulan Ini)', number_format($monthlyClicks, 0, ',', '.'))
                ->description('Total klik produk dibuka user')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('warning'),

            Stat::make('Total Katalog Aktif', Product::active()->count())
                ->description('Produk digital siap tayang')
                ->descriptionIcon('heroicon-m-cube')
                ->color('gray'),
        ];
    }
}
