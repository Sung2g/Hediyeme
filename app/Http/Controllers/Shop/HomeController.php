<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(CartService $cart): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::query()
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        return view('shop.home', [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'cartCount' => $cart->count(),
        ]);
    }
}
