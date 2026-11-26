<?php

namespace App\Filament\Widgets;

use App\Models\ProductClick;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MonthlyProductClicksChart extends ChartWidget
{
    protected ?string $heading = 'Produk Paling Banyak Dikunjungi (Bulan Ini)';

    protected ?string $description = 'Jumlah klik/kunjungan produk tertinggi dalam 30 hari terakhir';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        $topClickedProducts = ProductClick::query()
            ->select('products.name as product_name', DB::raw('COUNT(product_clicks.id) as total_clicks'))
            ->join('products', 'products.id', '=', 'product_clicks.product_id')
            ->whereBetween('product_clicks.created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_clicks')
            ->limit(7)
            ->get();

        $labels = $topClickedProducts->pluck('product_name')->toArray();
        $clicks = $topClickedProducts->pluck('total_clicks')->map(fn ($c) => (int) $c)->toArray();

        if (empty($labels)) {
            $labels = ['Belum ada kunjungan bulan ini'];
            $clicks = [0];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Klik / View Produk',
                    'data'  => $clicks,
                    'backgroundColor' => [
                        '#F97316',
                        '#FB923C',
                        '#FDBA74',
                        '#EA580C',
                        '#C2410C',
                        '#9A3412',
                        '#7C2D12',
                    ],
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
