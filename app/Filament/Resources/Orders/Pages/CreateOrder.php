<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['order_number'])) {
            $data['order_number'] = Order::generateOrderNumber();
        }

        // Hitung ulang total_amount dari items jika ada
        if (!empty($data['items']) && is_array($data['items'])) {
            $total = 0;
            foreach ($data['items'] as $item) {
                $total += (float) ($item['subtotal'] ?? 0);
            }
            $data['total_amount'] = $total;
        }

        if (($data['status'] ?? '') === 'completed' && empty($data['completed_at'])) {
            $data['completed_at'] = now();
        }

        return $data;
    }
}
