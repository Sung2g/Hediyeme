<?php

namespace App\Providers;

use App\Models\Category;
use App\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $shopLayoutData = function ($view): void {
            $view->with([
                'shopCategories' => Category::query()->where('is_active', true)->orderBy('name')->get(),
                'cartCount' => app(CartService::class)->count(),
            ]);
        };

        View::composer('layouts.shop', $shopLayoutData);
        View::composer([
            'shop.home',
            'shop.products.index',
            'shop.products.show',
            'shop.cart.index',
            'shop.checkout.index',
            'shop.checkout.success',
        ], $shopLayoutData);
    }
}
