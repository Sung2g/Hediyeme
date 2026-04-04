<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
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

    public function codPreview(Request $request, CartService $cart): JsonResponse
    {
        $slug = $request->query('product_slug', '');
        $qty = max(1, min(20, (int) $request->query('quantity', 1)));

        $pending = null;
        if (is_string($slug) && $slug !== '') {
            $pending = Product::query()
                ->where('slug', $slug)
                ->where('is_active', true)
                ->where('cod_enabled', true)
                ->first();

            if (! $pending) {
                return response()->json(['message' => 'Urun bulunamadi.'], 404);
            }
        }

        $lines = $cart->previewWithPending($pending, $qty);
        $subtotal = (float) $lines->sum('line_total');
        $shipping = $lines->isEmpty() ? 0.0 : (float) config('shop.cod_shipping_fee', 49.9);
        $total = $subtotal + $shipping;

        return response()->json([
            'items' => $lines->map(fn (array $row): array => [
                'name' => $row['name'],
                'quantity' => $row['quantity'],
                'line_total' => $row['line_total'],
                'price' => $row['price'],
                'thumb_url' => $row['thumb_url'] ?? null,
            ])->values()->all(),
            'subtotal' => round($subtotal, 2),
            'shipping' => round($shipping, 2),
            'total' => round($total, 2),
        ]);
    }
}
