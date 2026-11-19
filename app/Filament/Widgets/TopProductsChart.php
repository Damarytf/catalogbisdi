<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TopProductsChart extends ChartWidget
{
    protected ?string $heading = '5 Produk Paling Banyak Dipesan';

    protected ?string $description = 'Berdasarkan kuantitas unit pesanan masuk';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $labels = $topProducts->pluck('product_name')->toArray();
        $quantities = $topProducts->pluck('total_qty')->map(fn ($q) => (int) $q)->toArray();

        if (empty($labels)) {
            $labels = ['Belum ada pesanan'];
            $quantities = [0];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Kuantitas Terjual (Qty)',
                    'data'  => $quantities,
                    'backgroundColor' => [
                        '#F97316',
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
