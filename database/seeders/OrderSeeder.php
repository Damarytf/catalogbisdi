<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            return;
        }

        $sampleCustomers = [
            ['name' => 'Budi Prasetyo', 'contact' => '081234567890', 'status' => 'completed', 'days_ago' => 20],
            ['name' => 'Siti Aminah', 'contact' => 'siti.aminah@gmail.com', 'status' => 'completed', 'days_ago' => 15],
            ['name' => 'Rizky Firmansyah', 'contact' => '085712345678', 'status' => 'completed', 'days_ago' => 7],
            ['name' => 'Dewi Lestari', 'contact' => 'dewi.lestari@student.upnjatim.ac.id', 'status' => 'in_chat', 'days_ago' => 2],
            ['name' => 'Ahmad Fauzi', 'contact' => '089612345678', 'status' => 'pending', 'days_ago' => 0],
            ['name' => 'Nabila Putri', 'contact' => 'nabila.p@gmail.com', 'status' => 'pending', 'days_ago' => 0],
        ];

        foreach ($sampleCustomers as $idx => $cust) {
            $date = Carbon::now()->subDays($cust['days_ago']);
            $chosenProducts = $products->random(min(rand(1, 2), $products->count()));

            $total = 0;
            $itemsData = [];

            foreach ($chosenProducts as $prod) {
                $qty = rand(1, 2);
                $price = $prod->effective_price;
                $subtotal = $price * $qty;
                $total += $subtotal;

                $itemsData[] = [
                    'product_id'   => $prod->id,
                    'product_name' => $prod->name,
                    'price'        => $price,
                    'quantity'     => $qty,
                    'subtotal'     => $subtotal,
                ];
            }

            $order = Order::create([
                'order_number'     => 'INV-' . $date->format('Ym') . '-' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT),
                'customer_name'    => $cust['name'],
                'customer_contact' => $cust['contact'],
                'notes'            => 'Pesanan uji coba katalog Bisdi',
                'total_amount'     => $total,
                'status'           => $cust['status'],
                'completed_at'     => $cust['status'] === 'completed' ? $date : null,
                'created_at'       => $date,
                'updated_at'       => $date,
            ]);

            foreach ($itemsData as $item) {
                OrderItem::create(array_merge($item, [
                    'order_id'   => $order->id,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]));
            }
        }
    }
}

