<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'products' => Product::query()->count(),
                'products_active' => Product::query()->where('is_active', true)->count(),
                'categories' => Category::query()->count(),
                'orders' => Order::query()->count(),
                'orders_new' => Order::query()->where('status', 'new')->count(),
                'reviews_pending' => ProductReview::query()->where('is_approved', false)->count(),
                'reviews_total' => ProductReview::query()->count(),
                'low_stock' => Product::query()
                    ->where('is_active', true)
                    ->where('stock', '>', 0)
                    ->where('stock', '<=', 5)
                    ->count(),
            ],
            'recent_orders' => Order::query()->with('user')->latest()->limit(6)->get(),
            'low_stock_products' => Product::query()
                ->with('category')
                ->where('is_active', true)
                ->where('stock', '>', 0)
                ->where('stock', '<=', 5)
                ->orderBy('stock')
                ->limit(6)
                ->get(),
        ]);
    }
}
