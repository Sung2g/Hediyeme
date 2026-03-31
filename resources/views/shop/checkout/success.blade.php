@extends('shop.layout')

@section('title', 'Siparis Basarili')

@section('content')
    <div class="rounded-xl border border-green-200 bg-green-50 p-6">
        <h1 class="text-2xl font-bold text-green-800">Siparisiniz alindi.</h1>
        <p class="mt-2 text-sm text-green-700">Siparis No: #{{ $order->id }}</p>
        <p class="text-sm text-green-700">Odeme Yontemi: {{ $order->payment_method }}</p>
        <p class="text-sm text-green-700">Odeme Durumu: {{ $order->payment_status }}</p>
    </div>

    <div class="mt-6 rounded-xl border border-gray-200 bg-white p-5">
        <h2 class="font-semibold">Siparis Kalemleri</h2>
        <div class="mt-4 space-y-2">
            @foreach($order->items as $item)
                <div class="flex justify-between text-sm">
                    <span>{{ $item->product->name ?? 'Urun' }} x{{ $item->quantity }}</span>
                    <span>{{ number_format($item->line_total, 2) }} TL</span>
                </div>
            @endforeach
        </div>
        <div class="mt-4 border-t pt-4 text-right">
            <p class="text-lg font-bold">Genel Toplam: {{ number_format($order->total, 2) }} TL</p>
        </div>
    </div>
@endsection
