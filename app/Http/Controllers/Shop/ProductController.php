<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request, CartService $cart): View
    {
        $products = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->when(
                $request->filled('category'),
                fn ($query) => $query->whereHas(
                    'category',
                    fn ($categoryQuery) => $categoryQuery->where('slug', $request->string('category'))
                )
            )
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('shop.products.index', [
            'products' => $products,
            'cartCount' => $cart->count(),
        ]);
    }

    public function show(Product $product, CartService $cart): View
    {
        abort_unless($product->is_active, 404);

        return view('shop.products.show', [
            'product' => $product->load('category'),
            'cartCount' => $cart->count(),
        ]);
    }
}
