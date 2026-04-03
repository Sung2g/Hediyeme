@extends('admin.layout')

@section('title', 'Siparis #'.$order->id)
@section('subtitle', $order->user?->name ?? $order->guest_name ?? 'Misafir')

@section('content')
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400">Kalemler</h2>
                <ul class="mt-4 divide-y divide-slate-100">
                    @foreach($order->items as $item)
                        <li class="flex items-center justify-between gap-4 py-3 first:pt-0">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $item->product->name ?? 'Urun' }}</p>
                                <p class="text-sm text-slate-500">Adet: {{ $item->quantity }}</p>
                            </div>
                            <p class="shrink-0 font-semibold tabular-nums text-slate-900">{{ number_format($item->line_total, 2) }} TL</p>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-4 flex justify-between border-t border-slate-200 pt-4">
                    <span class="text-sm font-medium text-slate-500">Toplam</span>
                    <span class="text-xl font-extrabold tabular-nums text-rose-600">{{ number_format($order->total, 2) }} TL</span>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400">Bilgi</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="text-slate-500">E-posta</dt>
                        <dd class="font-medium text-slate-900">{{ $order->guest_email ?? $order->user?->email ?? '—' }}</dd>
                    </div>
                    @if($order->guest_phone)
                        <div>
                            <dt class="text-slate-500">Telefon</dt>
                            <dd class="font-medium text-slate-900">{{ $order->guest_phone }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-slate-500">Odeme</dt>
                        <dd class="font-medium text-slate-900">{{ $order->payment_method }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Odeme durumu</dt>
                        <dd class="font-medium text-slate-900">{{ $order->payment_status }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400">Siparis durumu</h2>
                <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500">
                        @foreach($statuses as $st)
                            <option value="{{ $st }}" @selected($order->status === $st)>{{ $st }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full rounded-xl bg-slate-900 py-3 text-sm font-bold text-white hover:bg-slate-800">
                        Durumu kaydet
                    </button>
                </form>
            </div>

            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-rose-600 hover:underline">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Siparis listesine don
            </a>
        </div>
    </div>
@endsection
