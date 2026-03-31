<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(CartService $cart): View
    {
        return view('shop.cart.index', [
            'items' => $cart->items(),
            'subtotal' => $cart->subtotal(),
            'cartCount' => $cart->count(),
        ]);
    }

    public function store(Request $request, Product $product, CartService $cart): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:20'],
        ]);

        $cart->add($product, $validated['quantity'] ?? 1);

        return back()->with('success', 'Urun sepete eklendi.');
    }

    public function update(Request $request, Product $product, CartService $cart): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $cart->updateQuantity($product->id, (int) $validated['quantity']);

        return back()->with('success', 'Sepet guncellendi.');
    }

    public function destroy(Product $product, CartService $cart): RedirectResponse
    {
        $cart->remove($product->id);

        return back()->with('success', 'Urun sepetten cikarildi.');
    }
}
