<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderStatusChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Status Pesanan WA';

    protected ?string $description = 'Perbandingan pesanan selesai, proses chat, dan belum konfirmasi';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    protected function getData(): array
    {
        $pending   = Order::where('status', 'pending')->count();
        $inChat    = Order::where('status', 'in_chat')->count();
        $completed = Order::where('status', 'completed')->count();
        $cancelled = Order::where('status', 'cancelled')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pesanan',
                    'data'  => [$completed, $inChat, $pending, $cancelled],
                    'backgroundColor' => [
                        '#10B981', // Hijau Selesai
                        '#3B82F6', // Biru Chat WA
                        '#F59E0B', // Kuning Pending
                        '#EF4444', // Merah Batal
                    ],
                ],
            ],
            'labels' => ['Selesai (Lunas)', 'Sedang Chat WA', 'Menunggu Chat', 'Batal / No Respon'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
