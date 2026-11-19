<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class MonthlyRevenueChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Omzet Penjualan (Bulanan)';

    protected ?string $description = 'Akumulasi nilai transaksi berstatus selesai (lunas) tahun ini';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];

    protected function getData(): array
    {
        $year = Carbon::now()->year;
        $monthlyRevenue = [];
        $months = [];

        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create($year, $month, 1);
            $months[] = $date->translatedFormat('M');

            $revenue = Order::where('status', 'completed')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('total_amount');

            $monthlyRevenue[] = (float) $revenue;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Omzet (Rp)',
                    'data'  => $monthlyRevenue,
                    'fill'  => 'start',
                    'borderColor' => '#F97316',
                    'backgroundColor' => 'rgba(249, 115, 22, 0.1)',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
