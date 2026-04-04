@extends('layouts.shop')

@section('title', $product->name.' — hediyeme.com')

@section('content')
    @php
        $primary = $product->primaryImage();
        $mainSrc = $primary ? $primary->url() : null;
        $openReviewModalOnError = $errors->hasAny(['guest_name', 'guest_email', 'rating', 'body']);
        $icon = match ($product->type) {
            'digital' => 'monitor',
            default => match ($product->category->name ?? '') {
                'Taki ve Mucevher' => 'gem',
                'Kisisel Bakim' => 'sparkles',
                'Dini Urunler' => 'book-open',
                default => 'gift',
            }
        };
        $typeLabel = match ($product->type) {
            'digital' => 'Dijital hizmet',
            default => 'Fiziksel urun',
        };
        $ratingDist = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach ($reviews as $rv) {
            $r = (int) $rv->rating;
            if ($r >= 1 && $r <= 5) {
                $ratingDist[$r]++;
            }
        }
        $distTotal = max(1, $reviewCount);
    @endphp

    {{-- Breadcrumb (ornek tasarim) --}}
    <nav class="mb-8 flex flex-wrap items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('shop.home') }}" class="flex items-center gap-1 font-medium transition hover:text-rose-600">
            <i data-lucide="chevron-left" class="h-4 w-4"></i>
            Anasayfa
        </a>
        <span>/</span>
        @if($product->category)
            <a href="{{ route('shop.products.index', ['category' => $product->category->slug]) }}" class="transition hover:text-rose-600">
                {{ $product->category->name }}
            </a>
        @else
            <a href="{{ route('shop.products.index') }}" class="transition hover:text-rose-600">Urunler</a>
        @endif
        <span>/</span>
        <span class="font-medium text-gray-900">{{ \Illuminate\Support\Str::limit($product->name, 56) }}</span>
    </nav>

    <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
        {{-- Sol: galeri --}}
        <div class="space-y-4">
            <div class="relative flex aspect-square items-center justify-center overflow-hidden rounded-3xl border border-amber-100 bg-amber-50/80 group">
                @if($product->is_on_sale)
                    <span class="absolute top-4 left-4 z-10 rounded-full bg-rose-600 px-3 py-1 text-xs font-bold text-white shadow-md">Indirimde</span>
                @endif
                @if($mainSrc)
                    <img
                        src="{{ $mainSrc }}"
                        alt="{{ $product->name }}"
                        id="product-main-image"
                        class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]"
                    >
                @else
                    <div class="flex h-full w-full flex-col items-center justify-center p-8">
                        <i data-lucide="{{ $icon }}" class="h-28 w-28 text-amber-400 transition duration-500 group-hover:scale-110 sm:h-32 sm:w-32"></i>
                        <p class="mt-4 text-sm text-gray-500">Gorsel yakinda</p>
                    </div>
                @endif
            </div>

            @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->images as $img)
                        <button
                            type="button"
                            class="product-thumb flex aspect-square cursor-pointer items-center justify-center overflow-hidden rounded-2xl border-2 transition {{ $loop->first ? 'border-rose-500 bg-amber-50' : 'border-transparent bg-gray-100 hover:border-gray-300' }}"
                            data-src="{{ $img->url() }}"
                        >
                            <img src="{{ $img->url() }}" alt="" class="h-full w-full object-cover">
                        </button>
                    @endforeach
                </div>
                @push('scripts')
                    <script>
                        document.querySelectorAll('.product-thumb').forEach((btn) => {
                            btn.addEventListener('click', () => {
                                const main = document.getElementById('product-main-image');
                                if (!main) return;
                                main.src = btn.dataset.src;
                                document.querySelectorAll('.product-thumb').forEach((b) => {
                                    b.classList.remove('border-rose-500', 'bg-amber-50');
                                    b.classList.add('border-transparent', 'bg-gray-100');
                                });
                                btn.classList.remove('border-transparent', 'bg-gray-100');
                                btn.classList.add('border-rose-500', 'bg-amber-50');
                            });
                        });
                    </script>
                @endpush
            @endif

            <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm lg:hidden">
                <h2 class="text-lg font-bold text-gray-900">Urun aciklamasi</h2>
                <div class="mt-3 text-sm leading-relaxed text-gray-600">
                    @if(filled($product->description))
                        {{ \Illuminate\Support\Str::limit(strip_tags($product->description), 200) }}
                    @else
                        <span class="text-gray-400">Aciklama yakinda.</span>
                    @endif
                </div>
            </section>
        </div>

        {{-- Sag: bilgi + aksiyon --}}
        <div class="flex flex-col">
            <div class="mb-6">
                <span class="rounded bg-rose-50 px-2 py-1 text-xs font-bold tracking-wider text-rose-600 uppercase">hediyeme ozel</span>
                <h1 class="mt-4 text-3xl leading-tight font-extrabold text-gray-900 sm:text-4xl">{{ $product->name }}</h1>
                <div class="mt-4 flex flex-wrap items-center gap-3 text-sm sm:gap-4">
                    <div class="flex text-amber-400">
                        @for($i = 1; $i <= 5; $i++)
                            <i data-lucide="star" class="h-[18px] w-[18px] {{ $reviewCount > 0 && $i <= round($reviewAverage) ? 'fill-current' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                    @if($reviewCount > 0)
                        <a href="#yorumlar" class="cursor-pointer font-medium text-indigo-600 hover:underline">{{ $reviewCount }} degerlendirme</a>
                    @else
                        <span class="font-medium text-gray-400">Henuz degerlendirme yok</span>
                    @endif
                    <span class="hidden text-gray-300 sm:inline">|</span>
                    @if($product->stock > 0)
                        <span class="flex items-center gap-1 font-bold text-emerald-600">
                            <i data-lucide="check" class="h-4 w-4"></i>
                            Stokta ({{ $product->stock }} adet)
                        </span>
                    @else
                        <span class="font-bold text-red-600">Stokta yok</span>
                    @endif
                </div>
            </div>

            <div class="mb-6">
                <div class="flex flex-wrap items-end gap-3">
                    @if($product->hasStrikethroughPrice())
                        <span class="text-xl font-semibold text-gray-400 line-through">{{ number_format($product->compare_at_price, 2) }} TL</span>
                    @endif
                    <span class="text-4xl font-extrabold text-rose-600">{{ number_format($product->price, 2) }} TL</span>
                    @if($product->is_on_sale && $product->hasStrikethroughPrice())
                        @php
                            $pct = round((1 - (float) $product->price / (float) $product->compare_at_price) * 100);
                        @endphp
                        <span class="rounded-lg bg-amber-100 px-2 py-1 text-sm font-bold text-amber-800">%{{ max(0, min(99, $pct)) }} indirim</span>
                    @endif
                </div>
                <p class="mt-2 flex items-center gap-1 text-sm font-medium text-emerald-600">
                    <i data-lucide="sparkles" class="h-4 w-4"></i>
                    Sepette ek avantaj ve kampanyalardan haberdar olun.
                </p>
            </div>

            <div class="mb-6 space-y-4 border-t border-b border-gray-100 py-6">
                <p class="leading-relaxed text-gray-600">
                    @if(filled($product->description))
                        {{ \Illuminate\Support\Str::limit(strip_tags($product->description), 200) }}
                    @else
                        <span class="text-gray-400">Bu ürün için kısa açıklama henüz eklenmedi.</span>
                    @endif
                </p>
                <ul class="mt-4 grid grid-cols-1 gap-4 text-sm font-medium text-gray-700 sm:grid-cols-2">
                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-rose-100 text-rose-600"><i data-lucide="check" class="h-3.5 w-3.5"></i></span>
                        Ozenli hediye paketi
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-rose-100 text-rose-600"><i data-lucide="check" class="h-3.5 w-3.5"></i></span>
                        Guvenli odeme
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-rose-100 text-rose-600"><i data-lucide="check" class="h-3.5 w-3.5"></i></span>
                        Hizli kargo secenekleri
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-rose-100 text-rose-600"><i data-lucide="check" class="h-3.5 w-3.5"></i></span>
                        14 gun icinde iade
                    </li>
                </ul>
            </div>

            <form id="product-add-cart-form" action="{{ route('shop.cart.store', $product->id) }}" method="POST" class="mb-8 flex flex-row items-stretch gap-2 sm:gap-3" x-data="{ qty: {{ (int) old('quantity', 1) }} }">
                @csrf
                <div class="flex h-12 w-[5.75rem] shrink-0 items-center rounded-lg border border-gray-200 bg-white px-0.5 shadow-sm sm:h-14 sm:w-36 sm:rounded-xl sm:border-2 sm:px-1 sm:shadow-none" aria-label="Adet">
                    <button type="button" class="flex h-full min-w-[1.75rem] items-center justify-center rounded-md p-0.5 text-gray-500 transition hover:bg-gray-50 hover:text-rose-600 sm:min-w-[2rem] sm:p-1.5" x-on:click.prevent="qty = Math.max(1, qty - 1)" aria-label="Azalt">
                        <i data-lucide="minus" class="h-3.5 w-3.5 sm:h-4 sm:w-4"></i>
                    </button>
                    <input type="number" id="product-qty" name="quantity" x-model.number="qty" min="1" max="20" class="min-w-0 flex-1 border-0 bg-transparent px-0.5 text-center text-sm font-bold tabular-nums text-gray-900 focus:ring-0 sm:text-base">
                    <button type="button" class="flex h-full min-w-[1.75rem] items-center justify-center rounded-md p-0.5 text-gray-500 transition hover:bg-gray-50 hover:text-rose-600 sm:min-w-[2rem] sm:p-1.5" x-on:click.prevent="qty = Math.min(20, qty + 1)" aria-label="Arttir">
                        <i data-lucide="plus" class="h-3.5 w-3.5 sm:h-4 sm:w-4"></i>
                    </button>
                </div>
                <button type="submit" class="flex min-h-12 flex-1 items-center justify-center gap-2 rounded-lg bg-rose-600 px-3 text-base font-extrabold tracking-tight text-white shadow-md shadow-rose-200/80 transition active:scale-[0.98] sm:min-h-14 sm:rounded-xl sm:px-5 sm:text-lg sm:shadow-lg sm:shadow-rose-200 hover:bg-rose-700 sm:hover:-translate-y-0.5">
                    <i data-lucide="shopping-cart" class="h-5 w-5 shrink-0 sm:h-5 sm:w-5"></i>
                    <span>Sepete ekle</span>
                </button>
            </form>

            @if($product->cod_enabled)
                <div class="mb-8 space-y-3">
                    <button
                        type="button"
                        class="shop-cod-cta relative w-full overflow-hidden rounded-2xl bg-gradient-to-r from-rose-600 via-rose-500 to-amber-500 py-4 text-base font-extrabold tracking-tight text-white shadow-lg transition duration-200"
                        x-on:click="$dispatch('open-shop-cod', { slug: '{{ e($product->slug) }}', title: {{ json_encode($product->name) }}, quantity: Number(document.getElementById('product-qty')?.value) || 1 })"
                    >
                        <span class="relative z-10 flex items-center justify-center gap-2 text-center leading-tight">
                            <i data-lucide="truck" class="h-6 w-6 shrink-0"></i>
                            Ücretsiz kapıda ödemeyle satın al
                        </span>
                    </button>
                
                </div>
            @endif

            <div class="flex items-start gap-4 rounded-2xl border border-gray-100 bg-gray-50 p-5">
                <i data-lucide="shield-check" class="mt-1 h-7 w-7 shrink-0 text-indigo-600"></i>
                <div>
                    <h4 class="text-base font-bold text-gray-900">hediyeme.com guvencesi</h4>
                    <p class="mt-1 text-sm leading-relaxed text-gray-500">
                        Bu urun hediyeme.com kalite anlayisiyla sunulmaktadir. 14 gun icinde kosullu iade hakkinizi kullanabilirsiniz.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <x-shop.review-modal :product="$product" :user-has-reviewed="$userHasReviewed" :open-on-error="$openReviewModalOnError" />

    {{-- Sekmeler (ornek: ozellikler / degerlendirmeler / iade) --}}
    <div id="yorumlar" class="mt-16 scroll-mt-28 border-t border-gray-200 pt-12" x-data="{ tab: 'ozellikler' }">
        <div class="mb-8 flex space-x-8 overflow-x-auto border-b border-gray-200 no-scrollbar">
            <button type="button" class="whitespace-nowrap px-2 pb-4 text-lg font-bold transition-colors" :class="tab === 'ozellikler' ? 'border-b-2 border-rose-600 text-rose-600' : 'text-gray-500 hover:text-gray-800'" x-on:click="tab = 'ozellikler'">
                Urun ozellikleri
            </button>
            <button type="button" class="whitespace-nowrap px-2 pb-4 text-lg font-bold transition-colors" :class="tab === 'degerlendirmeler' ? 'border-b-2 border-rose-600 text-rose-600' : 'text-gray-500 hover:text-gray-800'" x-on:click="tab = 'degerlendirmeler'">
                Degerlendirmeler ({{ $reviewCount }})
            </button>
            <button type="button" class="whitespace-nowrap px-2 pb-4 text-lg font-bold transition-colors" :class="tab === 'iade' ? 'border-b-2 border-rose-600 text-rose-600' : 'text-gray-500 hover:text-gray-800'" x-on:click="tab = 'iade'">
                Iade ve degisim
            </button>
        </div>

        <div x-show="tab === 'ozellikler'" class="grid grid-cols-1 gap-12 md:grid-cols-2">
            <div>
                <h3 class="mb-4 flex items-center gap-2 text-xl font-bold text-gray-900">
                    <i data-lucide="sparkles" class="h-6 w-6 text-amber-500"></i>
                    Urun ozellikleri
                </h3>
                <div class="space-y-4 whitespace-pre-line text-base leading-relaxed text-gray-600">
                    @if(filled($product->features))
                        {{ $product->features }}
                    @elseif(filled($product->description))
                        {{ $product->description }}
                    @else
                        <span class="text-gray-400">Bu ürün için detaylı özellik metni henüz eklenmedi.</span>
                    @endif
                </div>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-bold text-gray-900">Teknik detaylar</h3>
                <ul class="divide-y divide-gray-50 space-y-0">
                    <li class="flex justify-between gap-4 pt-2 text-sm">
                        <span class="text-gray-500">Kategori</span>
                        <span class="max-w-[60%] text-right font-bold text-gray-900">{{ $product->category->name ?? '—' }}</span>
                    </li>
                    <li class="flex justify-between gap-4 pt-4 text-sm">
                        <span class="text-gray-500">Urun tipi</span>
                        <span class="max-w-[60%] text-right font-bold text-gray-900">{{ $typeLabel }}</span>
                    </li>
                    <li class="flex justify-between gap-4 pt-4 text-sm">
                        <span class="text-gray-500">Stok</span>
                        <span class="max-w-[60%] text-right font-bold text-gray-900">{{ $product->stock }} adet</span>
                    </li>
                    <li class="flex justify-between gap-4 py-4 text-sm">
                        <span class="text-gray-500">Fiyat</span>
                        <span class="max-w-[60%] text-right font-bold text-gray-900">
                            @if($product->hasStrikethroughPrice())
                                <span class="mr-2 text-gray-400 line-through">{{ number_format($product->compare_at_price, 2) }} TL</span>
                            @endif
                            {{ number_format($product->price, 2) }} TL
                        </span>
                    </li>
                    @foreach($product->specAttributes as $attr)
                        <li class="flex justify-between gap-4 py-4 text-sm">
                            <span class="text-gray-500">{{ $attr->name }}</span>
                            <span class="max-w-[60%] whitespace-pre-line text-right font-bold text-gray-900">{{ $attr->value }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div x-show="tab === 'degerlendirmeler'" class="grid grid-cols-1 gap-12 lg:grid-cols-3">
            <div class="h-fit rounded-3xl border border-gray-100 bg-gray-50 p-8">
                <div class="mb-6 text-center">
                    <h3 class="text-5xl font-extrabold text-gray-900">{{ $reviewCount > 0 ? number_format($reviewAverage, 1) : '—' }}</h3>
                    <div class="my-3 flex justify-center text-amber-400">
                        @for($i = 1; $i <= 5; $i++)
                            <i data-lucide="star" class="h-6 w-6 {{ $reviewCount > 0 && $i <= round($reviewAverage) ? 'fill-current' : 'text-amber-400/30' }}"></i>
                        @endfor
                    </div>
                    <p class="font-medium text-gray-500">{{ $reviewCount }} degerlendirme</p>
                </div>
                <div class="space-y-3">
                    @foreach([5, 4, 3, 2, 1] as $stars)
                        @php $pct = round(($ratingDist[$stars] / $distTotal) * 100); @endphp
                        <div class="flex items-center gap-3 text-sm">
                            <span class="w-3 font-medium text-gray-700">{{ $stars }}</span>
                            <i data-lucide="star" class="h-3.5 w-3.5 fill-current text-amber-400"></i>
                            <div class="h-2.5 flex-1 overflow-hidden rounded-full bg-gray-200">
                                <div class="h-full rounded-full bg-amber-400" style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="w-6 text-right text-gray-500">{{ $ratingDist[$stars] }}</span>
                        </div>
                    @endforeach
                </div>
                @unless($userHasReviewed)
                    <button type="button" class="mt-8 w-full rounded-xl border-2 border-gray-200 bg-white py-3 font-bold text-gray-800 transition hover:border-rose-600 hover:text-rose-600" x-on:click="$dispatch('open-shop-review')">
                        Degerlendirme yaz
                    </button>
                @endunless
                @if($userHasReviewed)
                    <p class="mt-6 rounded-xl border border-gray-200 bg-white px-3 py-2 text-center text-xs text-gray-600">Bu urun icin zaten yorum yaptiniz.</p>
                @endif
            </div>

            <div class="space-y-6 lg:col-span-2">
                @forelse($reviews as $review)
                    @php
                        $name = $review->user?->name ?? $review->guest_name ?? 'Misafir';
                        $initial = mb_strtoupper(mb_substr($name, 0, 1));
                        $verified = $review->user_id !== null;
                    @endphp
                    <div class="border-b border-gray-100 pb-6 last:border-0">
                        <div class="mb-3 flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-rose-100 text-sm font-bold text-rose-600">
                                    {{ $initial }}
                                </div>
                                <div>
                                    <p class="flex flex-wrap items-center gap-2 font-bold text-gray-900">
                                        {{ $name }}
                                        @if($verified)
                                            <span class="flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold text-emerald-700">
                                                <i data-lucide="check" class="h-2.5 w-2.5"></i>
                                                Onayli alici
                                            </span>
                                        @endif
                                    </p>
                                    <div class="mt-1 flex items-center gap-2 text-xs text-gray-500">
                                        <div class="flex text-amber-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i data-lucide="star" class="h-3 w-3 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}"></i>
                                            @endfor
                                        </div>
                                        <span>· {{ $review->created_at->translatedFormat('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="mb-2 text-sm leading-relaxed text-gray-600 whitespace-pre-line">{{ $review->body }}</p>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50/50 py-12 text-center text-sm text-gray-500">
                        Henuz yorum yok. Ilk degerlendirmeyi siz yazin.
                    </div>
                @endforelse
            </div>
        </div>

        <div x-show="tab === 'iade'">
            <div class="mb-12 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="group rounded-2xl border border-gray-200 bg-white p-6 text-center transition hover:border-rose-300">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-rose-50 text-rose-600 transition-transform group-hover:scale-110">
                        <i data-lucide="refresh-cw" class="h-7 w-7"></i>
                    </div>
                    <h4 class="mb-2 font-bold text-gray-900">1. Talebinizi olusturun</h4>
                    <p class="text-sm text-gray-500">Siparisiniz icin 14 gun icinde iade talebini iletin.</p>
                </div>
                <div class="group rounded-2xl border border-gray-200 bg-white p-6 text-center transition hover:border-blue-300">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-50 text-blue-600 transition-transform group-hover:scale-110">
                        <i data-lucide="truck" class="h-7 w-7"></i>
                    </div>
                    <h4 class="mb-2 font-bold text-gray-900">2. Gonderin</h4>
                    <p class="text-sm text-gray-500">Urunu talimatlara uygun sekilde kargoya verin.</p>
                </div>
                <div class="group rounded-2xl border border-gray-200 bg-white p-6 text-center transition hover:border-emerald-300">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 transition-transform group-hover:scale-110">
                        <i data-lucide="credit-card" class="h-7 w-7"></i>
                    </div>
                    <h4 class="mb-2 font-bold text-gray-900">3. Iadenizi alin</h4>
                    <p class="text-sm text-gray-500">Inceleme sonrasi odeme iadeniz yansitilir.</p>
                </div>
            </div>
            <div class="rounded-3xl border border-gray-100 bg-gray-50 p-8">
                <h3 class="mb-6 flex items-center gap-2 text-xl font-bold text-gray-900">
                    <i data-lucide="alert-circle" class="h-6 w-6 text-rose-600"></i>
                    Iade ve degisim sartlari
                </h3>
                <div class="grid grid-cols-1 gap-6 text-sm text-gray-600 md:grid-cols-2">
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i data-lucide="check" class="mt-0.5 h-[18px] w-[18px] shrink-0 text-emerald-500"></i>
                            <span>Siparisiniz size ulastiktan sonraki <strong>14 gun icinde</strong> iade veya degisim talebinde bulunabilirsiniz.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i data-lucide="check" class="mt-0.5 h-[18px] w-[18px] shrink-0 text-emerald-500"></i>
                            <span>Iade edilecek urunlerin <strong>kullanilmamis</strong>, etiketleri acilmamis ve orijinal ambalajinda olmasi gerekir.</span>
                        </li>
                    </ul>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i data-lucide="check" class="mt-0.5 h-[18px] w-[18px] shrink-0 text-emerald-500"></i>
                            <span><strong>Dijital hizmetler:</strong> Teslim edilen dijital urunler dogasi geregi iade edilemeyebilir.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i data-lucide="check" class="mt-0.5 h-[18px] w-[18px] shrink-0 text-emerald-500"></i>
                            <span><strong>Hijyen urunleri:</strong> Ambalaji acilmis kisisel bakim urunlerinde iade kabul edilmeyebilir.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
