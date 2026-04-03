<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public const STATUSES = ['new', 'preparing', 'shipped', 'completed', 'cancelled'];

    public function index(): View
    {
        return view('admin.orders.index', [
            'orders' => Order::query()->with('user')->latest()->paginate(20),
        ]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', [
            'order' => $order->load('items.product', 'user'),
            'statuses' => self::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', self::STATUSES)],
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Siparis durumu guncellendi.');
    }
}
