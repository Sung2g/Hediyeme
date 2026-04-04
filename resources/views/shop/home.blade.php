@extends('layouts.shop')

@section('title', 'hediyeme.com — Hediyeler ve daha fazlasi')

@section('content')
    <div class="space-y-10 sm:space-y-12">
        <section class="grid h-auto grid-cols-1 gap-4 md:grid-cols-4 md:h-[480px]">
            <div class="group relative flex cursor-pointer flex-col justify-between overflow-hidden rounded-3xl bg-gradient-to-br from-gray-900 via-gray-800 to-rose-900 p-8 text-white shadow-xl md:col-span-2 md:row-span-2">
                <div class="absolute top-0 right-0 p-8 opacity-10 transition-transform duration-500 group-hover:scale-110">
                    <i data-lucide="monitor" class="h-[200px] w-[200px]"></i>
                </div>
                <div class="relative z-10">
                    <span class="rounded-full border border-rose-400/30 bg-rose-500/30 px-3 py-1 text-xs font-bold text-rose-100 backdrop-blur-sm">Dijital Cozumler</span>
                    <h1 class="mt-6 text-3xl leading-tight font-extrabold sm:text-5xl">
                        Profesyonel <br><span class="bg-gradient-to-r from-rose-300 to-rose-100 bg-clip-text text-transparent">E-Ticaret</span> Siteniz Hazir!
                    </h1>
                    <p class="mt-4 max-w-sm text-sm text-gray-300 sm:text-base">Tasarim, altyapi ve SEO kurulumu dahil anahtar teslim web tasarim paketleri.</p>
                </div>
                <div class="relative z-10 mt-8">
                    <a href="{{ route('shop.products.index') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-bold text-gray-900 shadow-lg transition hover:bg-rose-50 hover:text-rose-700 sm:text-base">
                        Paketleri Incele <i data-lucide="chevron-right" class="h-[18px] w-[18px]"></i>
                    </a>
                </div>
            </div>

            <div class="group flex cursor-pointer flex-col justify-between rounded-3xl bg-rose-50 p-6 transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="rounded-full bg-rose-200/50 px-2 py-1 text-xs font-bold text-rose-600">Guzellik ve Taki</span>
                        <h3 class="mt-2 text-lg font-bold text-gray-800 transition group-hover:text-rose-600 sm:text-xl">Zarafetinizi Taclandirin</h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-rose-500 shadow-sm">
                        <i data-lucide="heart" class="h-6 w-6"></i>
                    </div>
                </div>
                <p class="mt-4 text-sm text-gray-500">%40'a varan indirimler</p>
            </div>

            <div class="group flex cursor-pointer flex-col justify-between rounded-3xl bg-emerald-50 p-6 transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="rounded-full bg-emerald-200/50 px-2 py-1 text-xs font-bold text-emerald-700">Gunluk Ihtiyac</span>
                        <h3 class="mt-2 text-lg font-bold text-gray-800 transition group-hover:text-emerald-600 sm:text-xl">Dogal Bakim Urunleri</h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-emerald-500 shadow-sm">
                        <i data-lucide="sparkles" class="h-6 w-6"></i>
                    </div>
                </div>
                <p class="mt-4 text-sm text-gray-500">Cevre dostu secimler</p>
            </div>

            <div class="group relative flex cursor-pointer items-center justify-between overflow-hidden rounded-3xl bg-stone-100 p-6 transition hover:shadow-md md:col-span-2">
                <div class="relative z-10 w-2/3">
                    <span class="rounded-full bg-stone-200 px-2 py-1 text-xs font-bold text-stone-600">Koleksiyon</span>
                    <h3 class="mt-2 text-xl font-bold text-gray-800 sm:text-2xl">Ozel Tasarim Tesbihler ve Dini Eserler</h3>
                    <p class="mt-2 text-sm text-gray-500">Usta isi, garantili oltu ve kehribar.</p>
                </div>
                <div class="relative z-10 flex h-24 w-24 items-center justify-center rounded-full bg-stone-200 transition-transform group-hover:scale-110">
                    <i data-lucide="book-open" class="h-10 w-10 text-stone-500"></i>
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="grid grid-cols-2 gap-6 divide-x divide-gray-100 text-center md:grid-cols-4">
                <div class="flex flex-col items-center gap-2 px-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-rose-50 text-rose-600"><i data-lucide="shield-check" class="h-5 w-5"></i></div>
                    <h4 class="text-sm font-bold text-gray-800">Guvenli Alisveris</h4>
                    <p class="text-xs text-gray-500">SSL Korumasi</p>
                </div>
                <div class="flex flex-col items-center gap-2 px-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600"><i data-lucide="truck" class="h-5 w-5"></i></div>
                    <h4 class="text-sm font-bold text-gray-800">Hizli Kargo</h4>
                    <p class="text-xs text-gray-500">Hizli teslimat</p>
                </div>
                <div class="flex flex-col items-center gap-2 px-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-blue-600"><i data-lucide="monitor" class="h-5 w-5"></i></div>
                    <h4 class="text-sm font-bold text-gray-800">Dijital Teslimat</h4>
                    <p class="text-xs text-gray-500">Aninda erisim</p>
                </div>
                <div class="flex flex-col items-center gap-2 px-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-stone-100 text-stone-600"><i data-lucide="credit-card" class="h-5 w-5"></i></div>
                    <h4 class="text-sm font-bold text-gray-800">Esnek Odeme</h4>
                    <p class="text-xs text-gray-500">Kapida odeme</p>
                </div>
            </div>
        </section>

        <section>
            <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Karma Firsatlar</h2>
                    <p class="mt-1 text-sm text-gray-500">Farkli kategorilerden secilenler</p>
                </div>
                <a href="{{ route('shop.products.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-rose-600 hover:underline">
                    Tumunu Gor <i data-lucide="chevron-right" class="h-4 w-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($featuredProducts as $product)
                    @php
                        $icon = match($product->type) {
                            'digital' => 'monitor',
                            default => match($product->category->name ?? '') {
                                'Taki ve Mucevher' => 'gem',
                                'Kisisel Bakim' => 'sparkles',
                                'Dini Urunler' => 'book-open',
                                default => 'gift',
                            }
                        };

                        $color = match($product->category->name ?? '') {
                            'Taki ve Mucevher' => 'bg-amber-100',
                            'Kisisel Bakim' => 'bg-emerald-100',
                            'Dini Urunler' => 'bg-stone-200',
                            default => 'bg-rose-100',
                        };

                        $cover = $product->primaryImage();
                        $avgRating = $product->reviews_avg_rating !== null ? (float) $product->reviews_avg_rating : null;
                        $reviewCount = (int) ($product->reviews_count ?? 0);
                    @endphp
                    <div class="group rounded-2xl border border-gray-100 bg-white p-4 shadow-sm transition-shadow hover:shadow-xl">
                        <a href="{{ route('shop.products.show', $product->slug) }}" class="block">
                            <div class="{{ $color }} relative mb-4 flex h-48 w-full items-center justify-center overflow-hidden rounded-xl transition-transform group-hover:scale-[1.02]">
                                @if($product->is_on_sale)
                                    <span class="absolute top-2 left-2 z-10 rounded-full bg-rose-600 px-2 py-0.5 text-[10px] font-bold text-white shadow">Indirimde</span>
                                @endif
                                @if($cover)
                                    <img src="{{ $cover->url() }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-white/50 shadow-sm backdrop-blur-sm">
                                        <i data-lucide="{{ $icon }}" class="h-8 w-8 text-gray-600"></i>
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="mb-2 flex items-start justify-between gap-2">
                            <span class="rounded bg-gray-100 px-2 py-1 text-xs font-bold text-gray-500">{{ $product->category->name ?? 'Kategori' }}</span>
                            @if($reviewCount > 0 && $avgRating !== null)
                                <div class="flex shrink-0 text-amber-400" title="{{ number_format($avgRating, 1) }} / 5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i data-lucide="star" class="h-[14px] w-[14px] {{ $i <= round($avgRating) ? 'fill-current' : 'text-gray-200' }}"></i>
                                    @endfor
                                </div>
                            @else
                                <span class="text-[10px] text-gray-400">Henuz degerlendirme yok</span>
                            @endif
                        </div>
                        <a href="{{ route('shop.products.show', $product->slug) }}" class="block">
                            <h3 class="mb-2 min-h-10 font-bold text-gray-800 transition group-hover:text-rose-600">{{ $product->name }}</h3>
                        </a>
                        <div class="mt-4 flex flex-wrap items-center justify-between gap-2">
                            <span class="text-lg font-extrabold text-rose-600">
                                @if($product->hasStrikethroughPrice())
                                    <span class="mr-2 text-sm font-semibold text-gray-400 line-through">{{ number_format($product->compare_at_price, 2) }}</span>
                                @endif
                                {{ number_format($product->price, 2) }} TL
                            </span>
                            <form action="{{ route('shop.cart.store', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="rounded-xl bg-gray-900 p-2 text-white transition-colors hover:bg-rose-600" aria-label="Sepete ekle">
                                    <i data-lucide="shopping-cart" class="h-[18px] w-[18px]"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
