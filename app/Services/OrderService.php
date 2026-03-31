<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createFromCart(array $cartItems, array $customerData, string $paymentMethod, ?Authenticatable $user = null): Order
    {
        return DB::transaction(function () use ($cartItems, $customerData, $paymentMethod, $user): Order {
            $subtotal = collect($cartItems)->sum('line_total');
            $total = $subtotal;

            $order = Order::query()->create([
                'user_id' => $user?->getAuthIdentifier(),
                'guest_name' => $user ? null : $customerData['name'],
                'guest_email' => $user ? null : $customerData['email'],
                'guest_phone' => $customerData['phone'],
                'status' => 'new',
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentMethod === 'simulated_online' ? 'paid' : 'pending',
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            foreach ($cartItems as $item) {
                $product = Product::query()->find($item['product_id']);
                if (! $product) {
                    continue;
                }

                $order->items()->create([
                    'product_id' => $product->id,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'line_total' => $item['line_total'],
                ]);
            }

            return $order->load('items.product');
        });
    }
}
