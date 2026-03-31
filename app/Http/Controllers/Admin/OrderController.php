<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('admin.orders.index', [
            'orders' => Order::query()->latest()->paginate(20),
        ]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', [
            'order' => $order->load('items.product', 'user'),
        ]);
    }

    public function updateStatus(Order $order): RedirectResponse
    {
        $next = match ($order->status) {
            'new' => 'preparing',
            'preparing' => 'shipped',
            default => 'completed',
        };

        $order->update(['status' => $next]);

        return back()->with('success', 'Siparis durumu guncellendi.');
    }
}
