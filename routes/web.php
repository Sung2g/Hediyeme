<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('shop.home');
Route::get('/urunler', [ProductController::class, 'index'])->name('shop.products.index');
Route::get('/urunler/{product:slug}', [ProductController::class, 'show'])->name('shop.products.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('acp')->name('acp.')->group(function () {
    Route::redirect('/', '/acp/admin-login');

    Route::middleware('guest')->group(function () {
        Route::get('/admin-login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('/admin-login', [AdminAuthController::class, 'store'])->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/admin-logout', [AdminAuthController::class, 'destroy'])->name('logout');
    });
});

Route::prefix('sepet')->name('shop.cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/ekle/{product}', [CartController::class, 'store'])->name('store');
    Route::patch('/guncelle/{product}', [CartController::class, 'update'])->name('update');
    Route::delete('/sil/{product}', [CartController::class, 'destroy'])->name('destroy');
});

Route::prefix('checkout')->name('shop.checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
    Route::get('/basarili/{order}', [CheckoutController::class, 'success'])->name('success');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/orders');
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('products', AdminProductController::class);
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
});

require __DIR__.'/auth.php';
