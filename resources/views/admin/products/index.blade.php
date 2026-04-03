@extends('admin.layout')

@section('title', 'Urunler')
@section('subtitle', 'Stok, fiyat ve vitrin durumu')

@section('content')
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-1 flex-col gap-3 sm:flex-row sm:items-center">
            <div class="relative max-w-md flex-1">
                <i data-lucide="search" class="pointer-events-none absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                <input
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Urun adi veya slug ara..."
                    class="w-full rounded-xl border border-slate-200 py-2.5 pr-3 pl-10 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500"
                >
            </div>
            <label class="flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-600">
                <input type="checkbox" name="dusuk_stok" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500" @checked(request()->boolean('dusuk_stok'))>
                Dusuk stok (1–5)
            </label>
            <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Filtrele</button>
            @if(request()->filled('q') || request()->boolean('dusuk_stok'))
                <a href="{{ route('admin.products.index') }}" class="text-center text-sm font-semibold text-rose-600 hover:underline">Temizle</a>
            @endif
        </form>
        <a href="{{ route('admin.products.create') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-bold text-white shadow-md shadow-rose-200 hover:bg-rose-700">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Yeni urun
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="px-4 py-3">Urun</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Fiyat</th>
                        <th class="px-4 py-3">Stok</th>
                        <th class="px-4 py-3">Yorum</th>
                        <th class="px-4 py-3">Durum</th>
                        <th class="px-4 py-3 text-right">Islem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($products as $product)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-slate-900">{{ \Illuminate\Support\Str::limit($product->name, 48) }}</p>
                                <p class="text-xs text-slate-400">{{ $product->slug }}</p>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $product->category->name ?? '—' }}</td>
                            <td class="px-4 py-3 font-semibold tabular-nums text-slate-900">{{ number_format($product->price, 2) }} TL</td>
                            <td class="px-4 py-3">
                                @if($product->stock <= 0)
                                    <span class="rounded-lg bg-red-100 px-2 py-1 text-xs font-bold text-red-800">Tukendi</span>
                                @elseif($product->stock <= 5)
                                    <span class="rounded-lg bg-orange-100 px-2 py-1 text-xs font-bold text-orange-800">{{ $product->stock }}</span>
                                @else
                                    <span class="tabular-nums text-slate-700">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $product->reviews_count }}</td>
                            <td class="px-4 py-3">
                                @if($product->is_active)
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase text-emerald-800">Aktif</span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-200 px-2 py-0.5 text-[10px] font-bold uppercase text-slate-600">Pasif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center justify-end gap-2">
                                    <a href="{{ route('shop.products.show', $product->slug) }}" target="_blank" rel="noopener" class="text-xs font-semibold text-slate-500 hover:text-rose-600">Vitrin</a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-xs font-semibold text-rose-600 hover:underline">Duzenle</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Urunu silmek istediginize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-red-600 hover:underline">Sil</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-4 py-3">{{ $products->links() }}</div>
    </div>
@endsection
