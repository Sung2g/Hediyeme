<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(Request $request, CartService $cart): View|RedirectResponse
    {
        if ($cart->count() === 0) {
            return redirect()->route('shop.cart.index')->with('error', 'Sepetiniz bos.');
        }

        $fromSession = $request->session()->pull('checkout_payment_method');

        return view('shop.checkout.index', [
            'items' => $cart->items(),
            'subtotal' => $cart->subtotal(),
            'selectedPaymentMethod' => old('payment_method', $fromSession ?? 'simulated_online'),
            'paymentMethods' => [
                'simulated_online' => 'Simule Online Odeme',
                'cash_on_delivery' => 'Kapida Nakit',
                'card_on_delivery' => 'Kapida Kart',
            ],
        ]);
    }

    public function store(Request $request, CartService $cart, OrderService $orderService): RedirectResponse
    {
        if ($cart->count() === 0) {
            return redirect()->route('shop.cart.index')->with('error', 'Sepetiniz bos.');
        }

        $rules = [
            'phone' => ['required', 'string', 'max:30'],
            'payment_method' => ['required', 'in:simulated_online,cash_on_delivery,card_on_delivery'],
        ];

        if (! $request->user()) {
            $rules['name'] = ['required', 'string', 'max:255'];
            $rules['email'] = ['required', 'email', 'max:255'];
        }

        $validated = $request->validate($rules);

        $order = $orderService->createFromCart(
            $cart->items()->all(),
            [
                'name' => $validated['name'] ?? '',
                'email' => $validated['email'] ?? '',
                'phone' => $validated['phone'],
            ],
            $validated['payment_method'],
            $request->user()
        );

        $cart->clear();

        return redirect()->route('shop.checkout.success', $order)->with('success', 'Siparisiniz olusturuldu.');
    }

    public function success(Order $order): View
    {
        return view('shop.checkout.success', [
            'order' => $order->load('items.product'),
        ]);
    }
}
