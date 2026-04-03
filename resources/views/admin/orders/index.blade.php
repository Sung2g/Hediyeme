@extends('admin.layout')

@section('title', 'Siparisler')
@section('subtitle', 'Odeme ve kargo durumu')

@section('content')
    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Musteri</th>
                        <th class="px-4 py-3">Odeme</th>
                        <th class="px-4 py-3">Durum</th>
                        <th class="px-4 py-3">Toplam</th>
                        <th class="px-4 py-3">Tarih</th>
                        <th class="px-4 py-3 text-right">Islem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($orders as $order)
                        @php
                            $st = $order->status;
                            $badge = match ($st) {
                                'new' => 'bg-amber-100 text-amber-900',
                                'preparing' => 'bg-blue-100 text-blue-900',
                                'shipped' => 'bg-indigo-100 text-indigo-900',
                                'completed' => 'bg-emerald-100 text-emerald-900',
                                'cancelled' => 'bg-red-100 text-red-900',
                                default => 'bg-slate-100 text-slate-800',
                            };
                        @endphp
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-4 py-3 font-mono font-semibold text-slate-900">#{{ $order->id }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $order->user?->name ?? $order->guest_name ?? 'Misafir' }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-medium text-slate-600">{{ $order->payment_method }}</span>
                                <span class="mt-0.5 block text-[10px] text-slate-400">{{ $order->payment_status }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase {{ $badge }}">{{ $st }}</span>
                            </td>
                            <td class="px-4 py-3 font-semibold tabular-nums text-slate-900">{{ number_format($order->total, 2) }} TL</td>
                            <td class="px-4 py-3 text-xs text-slate-500">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-xs font-semibold text-rose-600 hover:underline">Detay</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-4 py-3">{{ $orders->links() }}</div>
    </div>
@endsection
