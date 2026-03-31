@extends('admin.layout')

@section('title', 'Siparisler')

@section('content')
    <div class="rounded-xl bg-white p-4">
        <h2 class="mb-4 text-lg font-semibold">Siparisler</h2>
        <div class="overflow-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">#</th>
                        <th class="py-2">Musteri</th>
                        <th class="py-2">Odeme</th>
                        <th class="py-2">Durum</th>
                        <th class="py-2">Toplam</th>
                        <th class="py-2">Islem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b">
                            <td class="py-2">{{ $order->id }}</td>
                            <td class="py-2">{{ $order->user?->name ?? $order->guest_name ?? 'Misafir' }}</td>
                            <td class="py-2">{{ $order->payment_method }}</td>
                            <td class="py-2">{{ $order->status }}</td>
                            <td class="py-2">{{ number_format($order->total, 2) }} TL</td>
                            <td class="py-2"><a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600">Detay</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $orders->links() }}</div>
    </div>
@endsection
