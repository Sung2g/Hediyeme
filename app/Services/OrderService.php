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
            $shippingFee = (float) ($customerData['shipping_fee'] ?? 0);
            $total = $subtotal + $shippingFee;

            $order = Order::query()->create([
                'user_id' => $user?->getAuthIdentifier(),
                'guest_name' => $user ? null : $customerData['name'],
                'guest_email' => $user ? null : (filled($customerData['email'] ?? null) ? $customerData['email'] : null),
                'guest_phone' => $customerData['phone'],
                'status' => 'new',
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentMethod === 'simulated_online' ? 'paid' : 'pending',
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total' => $total,
                'shipping_city' => $customerData['shipping_city'] ?? null,
                'shipping_district' => $customerData['shipping_district'] ?? null,
                'shipping_address' => $customerData['shipping_address'] ?? null,
                'seller_note' => $customerData['seller_note'] ?? null,
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
