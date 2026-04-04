@extends('layouts.shop')

@section('title', 'Urunler — hediyeme.com')

@section('content')
    @php
        $qParams = fn (array $extra = []) => array_filter(array_merge(request()->only(['category', 'q', 'sort']), $extra));
    @endphp

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Tum urunler</h1>
        <p class="mt-2 text-sm text-gray-500">
            @if($searchTooShort ?? false)
                “{{ request('q') }}” icin arama yapilamadi (en az 3 karakter).
            @else
                {{ $products->total() }} urun listeleniyor
                @if(request()->string('q')->trim()->isNotEmpty())
                    — “{{ request('q') }}” icin sonuclar
                @endif
            @endif
        </p>
    </div>

    <div class="flex flex-col gap-10 lg:flex-row lg:gap-12">
        <aside class="w-full shrink-0 lg:w-64">
            <div class="sticky top-24 space-y-6 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div>
                    <h2 class="text-xs font-bold tracking-wider text-gray-400 uppercase">Kategori</h2>
                    <ul class="mt-3 space-y-1">
                        <li>
                            <a
                                href="{{ route('shop.products.index', $qParams(['category' => null])) }}"
                                class="block rounded-lg px-3 py-2 text-sm font-medium transition {{ ! request('category') ? 'bg-rose-50 text-rose-700' : 'text-gray-600 hover:bg-gray-50' }}"
                            >
                                Tum kategoriler
                            </a>
                        </li>
                        @foreach($shopCategories ?? [] as $cat)
                            <li>
                                <a
                                    href="{{ route('shop.products.index', $qParams(['category' => $cat->slug])) }}"
                                    class="block rounded-lg px-3 py-2 text-sm font-medium transition {{ request('category') === $cat->slug ? 'bg-rose-50 text-rose-700' : 'text-gray-600 hover:bg-gray-50' }}"
                                >
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h2 class="text-xs font-bold tracking-wider text-gray-400 uppercase">Sirala</h2>
                    <form method="GET" action="{{ route('shop.products.index') }}" class="mt-3 space-y-2">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('q'))
                            <input type="hidden" name="q" value="{{ request('q') }}">
                        @endif
                        <select name="sort" onchange="this.form.submit()" class="w-full rounded-xl border-gray-200 text-sm shadow-sm">
                            <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>En yeni</option>
                            <option value="price_asc" {{ $sortBy === 'price_asc' ? 'selected' : '' }}>Fiyat: dusukten yuksege</option>
                            <option value="price_desc" {{ $sortBy === 'price_desc' ? 'selected' : '' }}>Fiyat: yuksekten dusuge</option>
                        </select>
                    </form>
                </div>
            </div>
        </aside>

        <div class="min-w-0 flex-1">
            @if($searchTooShort ?? false)
                <div class="rounded-2xl border border-amber-100 bg-amber-50/60 py-14 text-center">
                    <p class="text-sm font-medium text-gray-800">Aramak icin en az <strong>3 karakter</strong> yazin.</p>
                    <p class="mt-2 text-xs text-gray-600">Canli arama da ayni kurala uyar.</p>
                    <a href="{{ route('shop.products.index', array_filter(['category' => request('category'), 'sort' => request('sort')])) }}" class="mt-5 inline-block text-sm font-semibold text-rose-600 hover:underline">Aramayi temizle</a>
                </div>
            @elseif($products->isEmpty())
                <div class="rounded-2xl border border-dashed border-gray-200 bg-white py-16 text-center">
                    @if(request()->string('q')->trim()->isNotEmpty() && !($searchTooShort ?? false))
                        <p class="text-base font-medium text-gray-800">“{{ request('q') }}” icin urun bulunamadi</p>
                        <p class="mt-2 text-sm text-gray-500">Farkli kelimeler veya daha genel bir arama deneyin.</p>
                    @else
                        <p class="text-gray-500">Kriterlere uygun urun bulunamadi.</p>
                    @endif
                    <a href="{{ route('shop.products.index') }}" class="mt-4 inline-block text-sm font-semibold text-rose-600 hover:underline">Tum urunlere don</a>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($products as $product)
                        @php
                            $thumb = $product->primaryImage();
                            $avg = $product->reviews_avg_rating !== null ? (float) $product->reviews_avg_rating : null;
                            $rcount = (int) ($product->reviews_count ?? 0);
                            $snippet = $product->latestApprovedReview;
                        @endphp
                        <article class="group flex flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition hover:border-rose-100 hover:shadow-lg">
                            <a href="{{ route('shop.products.show', $product->slug) }}" class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                                @if($thumb)
                                    <img src="{{ $thumb->url() }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex h-full items-center justify-center bg-gradient-to-br from-rose-50 to-gray-100">
                                        <i data-lucide="gift" class="h-12 w-12 text-gray-300"></i>
                                    </div>
                                @endif
                                @if($product->is_on_sale)
                                    <span class="absolute top-3 right-3 z-10 rounded-full bg-rose-600 px-2 py-0.5 text-[10px] font-bold text-white shadow">Indirimde</span>
                                @endif
                                @if($product->stock <= 5 && $product->stock > 0)
                                    <span class="absolute top-3 left-3 rounded-full bg-amber-500 px-2 py-0.5 text-xs font-bold text-white">Son {{ $product->stock }}</span>
                                @endif
                            </a>

                            <div class="flex flex-1 flex-col p-4">
                                <div class="mb-2 flex items-start justify-between gap-2">
                                    <span class="rounded-lg bg-gray-100 px-2 py-0.5 text-[11px] font-bold text-gray-500">{{ $product->category->name ?? 'Kategori' }}</span>
                                    @if($rcount > 0 && $avg !== null)
                                        <div class="flex shrink-0 items-center gap-1 text-amber-400" title="{{ number_format($avg, 1) }} / 5">
                                            <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i>
                                            <span class="text-xs font-semibold text-gray-700">{{ number_format($avg, 1) }}</span>
                                            <span class="text-[10px] text-gray-400">({{ $rcount }})</span>
                                        </div>
                                    @endif
                                </div>

                                <a href="{{ route('shop.products.show', $product->slug) }}" class="font-bold text-gray-900 transition group-hover:text-rose-600">
                                    {{ $product->name }}
                                </a>

                                @if($snippet)
                                    <p class="mt-2 line-clamp-2 text-xs italic text-gray-500">
                                        “{{ \Illuminate\Support\Str::limit($snippet->body, 100) }}”
                                        <span class="not-italic text-gray-400">— {{ $snippet->user?->name ?? $snippet->guest_name ?? 'Misafir' }}</span>
                                    </p>
                                @endif

                                <p class="mt-2 line-clamp-2 flex-1 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit(strip_tags($product->description), 80) }}</p>

                                <div class="mt-4 flex items-end justify-between gap-3 border-t border-gray-50 pt-4">
                                    <div>
                                        <p class="text-xl font-extrabold text-rose-600">
                                            @if($product->hasStrikethroughPrice())
                                                <span class="mr-1 text-sm font-semibold text-gray-400 line-through">{{ number_format($product->compare_at_price, 2) }}</span>
                                            @endif
                                            {{ number_format($product->price, 2) }} <span class="text-sm font-semibold text-gray-500">TL</span>
                                        </p>
                                        <p class="text-xs text-gray-400">Stok: {{ $product->stock }}</p>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                                    <a href="{{ route('shop.products.show', $product->slug) }}" class="inline-flex flex-1 items-center justify-center rounded-xl border border-gray-200 py-2.5 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                        Detay
                                    </a>
                                    <form action="{{ route('shop.cart.store', $product->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full rounded-xl bg-gray-900 py-2.5 text-sm font-semibold text-white hover:bg-gray-800">
                                            Sepete ekle
                                        </button>
                                    </form>
                                </div>
                                @if($product->cod_enabled)
                                    <button
                                        type="button"
                                        class="shop-cod-cta mt-2 w-full rounded-xl bg-gradient-to-r from-rose-600 to-rose-500 py-2.5 text-sm font-bold text-white shadow-md transition"
                                        x-on:click="$dispatch('open-shop-cod', { slug: '{{ e($product->slug) }}', title: {{ json_encode($product->name) }} })"
                                    >
                                        Ücretsiz kapıda ödemeyle al
                                    </button>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
