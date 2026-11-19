<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $whatsappNumber = Setting::get('whatsapp_number', '');
        $checkoutGreeting = Setting::get('checkout_greeting', 'Halo Kak, saya ingin order:');
        $checkoutClosing = Setting::get('checkout_closing', 'Mohon konfirmasi ketersediaan dan info pembayarannya ya Kak, terima kasih!');

        return view('cart.index', compact('whatsappNumber', 'checkoutGreeting', 'checkoutClosing'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_contact' => 'required|string|max:255',
            'notes'            => 'nullable|string|max:1000',
            'items'            => 'required|array|min:1',
            'items.*.id'       => 'nullable|integer',
            'items.*.name'     => 'required|string|max:255',
            'items.*.price'    => 'required|numeric|min:0',
            'items.*.qty'      => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($validated) {
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $totalAmount += $item['price'] * $item['qty'];
            }

            $order = Order::create([
                'order_number'     => Order::generateOrderNumber(),
                'customer_name'    => $validated['customer_name'],
                'customer_contact' => $validated['customer_contact'],
                'notes'            => $validated['notes'] ?? null,
                'total_amount'     => $totalAmount,
                'status'           => 'pending',
            ]);

            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['id'] ?? null,
                    'product_name' => $item['name'],
                    'price'        => $item['price'],
                    'quantity'     => $item['qty'],
                    'subtotal'     => $item['price'] * $item['qty'],
                ]);
            }

            return response()->json([
                'success'      => true,
                'order_number' => $order->order_number,
                'order_id'     => $order->id,
            ]);
        });
    }
}
