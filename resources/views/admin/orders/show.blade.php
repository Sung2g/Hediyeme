@extends('admin.layout')

@section('title', 'Siparis Detay')

@section('content')
    <div class="rounded-xl bg-white p-5">
        <h2 class="text-lg font-semibold">Siparis #{{ $order->id }}</h2>
        <p class="mt-2 text-sm text-gray-600">Musteri: {{ $order->user?->name ?? $order->guest_name ?? 'Misafir' }}</p>
        <p class="text-sm text-gray-600">Odeme: {{ $order->payment_method }} ({{ $order->payment_status }})</p>
        <p class="text-sm text-gray-600">Durum: {{ $order->status }}</p>

        <div class="mt-4 space-y-2">
            @foreach($order->items as $item)
                <div class="flex justify-between text-sm">
                    <span>{{ $item->product->name ?? 'Urun' }} x{{ $item->quantity }}</span>
                    <span>{{ number_format($item->line_total, 2) }} TL</span>
                </div>
            @endforeach
        </div>

        <div class="mt-4 border-t pt-4 text-right">
            <p class="text-lg font-bold">Toplam: {{ number_format($order->total, 2) }} TL</p>
        </div>

        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="mt-6">
            @csrf
            @method('PATCH')
            <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white">
                Durumu Bir Sonraki Asamaya Al
            </button>
        </form>
    </div>
@endsection
