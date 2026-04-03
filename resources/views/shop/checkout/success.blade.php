@extends('layouts.shop')

@section('title', 'Siparis alindi — hediyeme.com')

@section('content')
    <div class="mx-auto max-w-2xl text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
            <i data-lucide="check-circle" class="h-10 w-10"></i>
        </div>
        <h1 class="mt-6 text-3xl font-extrabold text-gray-900">Siparisiniz alindi</h1>
        <p class="mt-2 text-sm text-gray-500">Siparis numaranizi not alin; kisa surede sizinle iletisime gececegiz.</p>
    </div>

    <div class="mx-auto mt-10 max-w-2xl space-y-6">
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/80 p-6 text-left">
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-600">Siparis no</dt>
                    <dd class="font-bold text-gray-900">#{{ $order->id }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-600">Odeme</dt>
                    <dd class="font-medium text-gray-900">{{ $order->payment_method }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-600">Durum</dt>
                    <dd class="font-medium text-gray-900">{{ $order->payment_status }}</dd>
                </div>
            </dl>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <h2 class="font-bold text-gray-900">Kalemler</h2>
            <ul class="mt-4 space-y-2">
                @foreach($order->items as $item)
                    <li class="flex justify-between text-sm">
                        <span>{{ $item->product->name ?? 'Urun' }} × {{ $item->quantity }}</span>
                        <span class="font-medium">{{ number_format($item->line_total, 2) }} TL</span>
                    </li>
                @endforeach
            </ul>
            <p class="mt-4 border-t border-gray-100 pt-4 text-right text-lg font-extrabold text-rose-600">{{ number_format($order->total, 2) }} TL</p>
        </div>

        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('shop.home') }}" class="rounded-xl border border-gray-200 px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">Anasayfa</a>
            <a href="{{ route('shop.products.index') }}" class="rounded-xl bg-rose-600 px-6 py-3 text-sm font-semibold text-white hover:bg-rose-700">Alisverise devam</a>
        </div>
    </div>
@endsection
