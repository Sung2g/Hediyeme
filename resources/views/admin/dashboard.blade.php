@extends('admin.layout')

@section('title', 'Ozet')
@section('subtitle', 'Magaza durumu ve hizli erisim')

@section('content')
    @php
        $s = $stats;
    @endphp
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Urunler</span>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                    <i data-lucide="package" class="h-5 w-5"></i>
                </span>
            </div>
            <p class="mt-3 text-3xl font-extrabold tabular-nums text-slate-900">{{ $s['products'] }}</p>
            <p class="mt-1 text-sm text-slate-500">{{ $s['products_active'] }} aktif</p>
            <a href="{{ route('admin.products.index') }}" class="mt-4 inline-flex text-sm font-semibold text-rose-600 hover:underline">Urunleri yonet</a>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Siparisler</span>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <i data-lucide="shopping-bag" class="h-5 w-5"></i>
                </span>
            </div>
            <p class="mt-3 text-3xl font-extrabold tabular-nums text-slate-900">{{ $s['orders'] }}</p>
            <p class="mt-1 text-sm text-slate-500">
                @if($s['orders_new'] > 0)
                    <span class="font-semibold text-amber-600">{{ $s['orders_new'] }} yeni</span>
                @else
                    Yeni siparis yok
                @endif
            </p>
            <a href="{{ route('admin.orders.index') }}" class="mt-4 inline-flex text-sm font-semibold text-rose-600 hover:underline">Siparisleri ac</a>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Yorumlar</span>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <i data-lucide="message-square-text" class="h-5 w-5"></i>
                </span>
            </div>
            <p class="mt-3 text-3xl font-extrabold tabular-nums text-slate-900">{{ $s['reviews_total'] }}</p>
            <p class="mt-1 text-sm text-slate-500">
                @if($s['reviews_pending'] > 0)
                    <span class="font-semibold text-amber-600">{{ $s['reviews_pending'] }} onay bekliyor</span>
                @else
                    Bekleyen yok
                @endif
            </p>
            <a href="{{ route('admin.reviews.index', ['durum' => 'bekleyen']) }}" class="mt-4 inline-flex text-sm font-semibold text-rose-600 hover:underline">Yorumlari ac</a>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Dusuk stok</span>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                    <i data-lucide="alert-triangle" class="h-5 w-5"></i>
                </span>
            </div>
            <p class="mt-3 text-3xl font-extrabold tabular-nums text-slate-900">{{ $s['low_stock'] }}</p>
            <p class="mt-1 text-sm text-slate-500">Stok 1–5 arasi (aktif)</p>
            <a href="{{ route('admin.products.index', ['dusuk_stok' => 1]) }}" class="mt-4 inline-flex text-sm font-semibold text-rose-600 hover:underline">Listele</a>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200/80 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <h2 class="text-sm font-bold text-slate-900">Son siparisler</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-rose-600 hover:underline">Tumu</a>
            </div>
            <ul class="divide-y divide-slate-50">
                @forelse($recent_orders as $order)
                    <li>
                        <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between gap-3 px-5 py-3 transition hover:bg-slate-50">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-slate-900">#{{ $order->id }} — {{ $order->user?->name ?? $order->guest_name ?? 'Misafir' }}</p>
                            <p class="text-xs text-slate-500">{{ number_format($order->total, 2) }} TL · {{ $order->created_at->diffForHumans() }}</p>
                        </div>
                        @php
                            $st = $order->status;
                            $badge = match ($st) {
                                'new' => 'bg-amber-100 text-amber-800',
                                'completed' => 'bg-emerald-100 text-emerald-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                default => 'bg-slate-100 text-slate-700',
                            };
                        @endphp
                        <span class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase {{ $badge }}">{{ $st }}</span>
                        </a>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-slate-500">Henuz siparis yok.</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <h2 class="text-sm font-bold text-slate-900">Dusuk stoklu urunler</h2>
                <a href="{{ route('admin.products.index', ['dusuk_stok' => 1]) }}" class="text-xs font-semibold text-rose-600 hover:underline">Tumu</a>
            </div>
            <ul class="divide-y divide-slate-50">
                @forelse($low_stock_products as $product)
                    <li class="flex items-center justify-between gap-3 px-5 py-3">
                        <div class="min-w-0">
                            <a href="{{ route('admin.products.edit', $product) }}" class="truncate text-sm font-semibold text-slate-900 hover:text-rose-600">{{ $product->name }}</a>
                            <p class="text-xs text-slate-500">{{ $product->category->name ?? '-' }}</p>
                        </div>
                        <span class="shrink-0 rounded-lg bg-orange-100 px-2 py-1 text-xs font-bold text-orange-800">{{ $product->stock }} adet</span>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-slate-500">Dusuk stoklu urun yok.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Yeni urun
        </a>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm transition hover:border-rose-200 hover:bg-rose-50">
            <i data-lucide="folder-plus" class="h-4 w-4"></i>
            Yeni kategori
        </a>
    </div>
@endsection
