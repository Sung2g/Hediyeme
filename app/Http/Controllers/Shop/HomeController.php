<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $featuredProducts = Product::query()
            ->where('is_active', true)
            ->with(['category', 'images'])
            ->withAvg([
                'reviews as reviews_avg_rating' => fn ($q) => $q->where('is_approved', true),
            ], 'rating')
            ->withCount([
                'reviews as reviews_count' => fn ($q) => $q->where('is_approved', true),
            ])
            ->latest()
            ->take(8)
            ->get();

        return view('shop.home', [
            'featuredProducts' => $featuredProducts,
        ]);
    }
}
