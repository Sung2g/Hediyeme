@php
    $activeCategory = request('category');
    $onProducts = request()->routeIs('shop.products.index');
@endphp
<div
    class="sticky top-0 z-50 bg-white shadow-sm"
    x-data="shopSearchNav({
        initialQ: {{ json_encode(request('q') ?? '') }},
        searchUrl: {{ json_encode(route('shop.products.search')) }},
        productsIndexUrl: {{ json_encode(route('shop.products.index')) }},
    })"
    x-on:keydown.escape.window="closePanels()"
>
    <header>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-3 sm:h-20">
                <a href="{{ route('shop.home') }}" class="flex shrink-0 cursor-pointer items-center gap-2">
                    @if (file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="hediyeme" width="40" height="40" class="h-9 w-9 rounded-xl object-cover shadow-lg shadow-rose-200 sm:h-10 sm:w-10" />
                    @else
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-rose-600 text-lg font-bold text-white shadow-lg shadow-rose-200 sm:h-10 sm:w-10 sm:text-xl">
                            <i data-lucide="gift" class="h-5 w-5 sm:h-6 sm:w-6"></i>
                        </div>
                    @endif
                    <span class="text-lg font-extrabold tracking-tight text-gray-900 sm:text-2xl">
                        hediyeme<span class="text-rose-600">.com</span>
                    </span>
                </a>

                <form
                    action="{{ route('shop.products.index') }}"
                    method="GET"
                    class="relative mx-4 hidden max-w-2xl flex-1 md:block"
                    x-on:submit="onSubmitSearch($event)"
                    x-on:click.outside="closePanels()"
                >
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ e(request('category')) }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ e(request('sort')) }}">
                    @endif
                    <div class="relative w-full">
                        <input
                            type="search"
                            name="q"
                            x-model="q"
                            x-on:input="onSearchInput(false)"
                            x-on:focus="onSearchFocus(false)"
                            placeholder="Urun, kategori veya dijital hizmet arayin..."
                            class="w-full rounded-full border-2 border-gray-100 bg-gray-50 py-2.5 pr-28 pl-11 text-sm outline-none transition-all focus:border-rose-500 focus:bg-white focus:ring-0 sm:py-3 sm:pr-32 sm:pl-12"
                            autocomplete="off"
                            aria-autocomplete="list"
                            :aria-expanded="panelOpen"
                        />
                        <i data-lucide="search" class="pointer-events-none absolute top-1/2 left-3.5 h-5 w-5 -translate-y-1/2 text-gray-400 sm:left-4"></i>
                        <button type="submit" class="absolute top-1/2 right-1.5 -translate-y-1/2 rounded-full bg-rose-600 px-4 py-1.5 text-xs font-medium text-white shadow-md shadow-rose-200 transition hover:bg-rose-700 sm:px-5 sm:text-sm">
                            Ara
                        </button>
                    </div>

                    <div
                        x-show="panelOpen"
                        x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute top-full right-0 left-0 z-[60] mt-2 max-h-[min(70vh,28rem)] overflow-y-auto rounded-2xl border border-gray-100 bg-white py-2 shadow-2xl ring-1 ring-black/5"
                        role="listbox"
                    >
                        <div x-show="suggestState === 'short'" class="px-4 py-3 text-sm text-gray-600">
                            Aramak icin en az <strong class="text-gray-900">3 karakter</strong> yazin.
                        </div>
                        <div x-show="suggestState === 'loading'" class="px-4 py-4 text-center text-sm text-gray-500">
                            Araniyor...
                        </div>
                        <div x-show="suggestState === 'error'" class="px-4 py-3 text-sm text-red-600">
                            Bir hata olustu. Lutfen tekrar deneyin.
                        </div>
                        <div x-show="suggestState === 'empty'" class="px-4 py-4 text-center">
                            <p class="text-sm font-medium text-gray-800">Eslesen urun bulunamadi</p>
                            <p class="mt-1 text-xs text-gray-500">Farkli bir kelime deneyin veya tum sonuclar sayfasina gidin.</p>
                            <a
                                :href="allResultsUrl"
                                class="mt-3 inline-flex text-sm font-semibold text-rose-600 hover:underline"
                                x-on:click="pickResult()"
                            >
                                Tum sonuclari gor
                            </a>
                        </div>
                        <div x-show="suggestState === 'results'">
                            <ul class="divide-y divide-gray-50">
                                <template x-for="item in results" :key="item.slug">
                                    <li>
                                        <a
                                            :href="item.url"
                                            class="flex gap-3 px-3 py-2.5 transition hover:bg-rose-50/80"
                                            x-on:click="pickResult()"
                                        >
                                            <span class="relative h-14 w-14 shrink-0 overflow-hidden rounded-xl bg-gray-100">
                                                <img x-show="item.thumb" :src="item.thumb" :alt="item.name" class="h-full w-full object-cover" />
                                                <span x-show="!item.thumb" class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-gray-400">—</span>
                                            </span>
                                            <span class="min-w-0 flex-1">
                                                <span class="line-clamp-2 text-sm font-semibold text-gray-900" x-text="item.name"></span>
                                                <span class="mt-0.5 block text-xs text-gray-500" x-text="item.category || ''"></span>
                                                <span class="mt-1 text-sm font-bold text-rose-600" x-text="item.price_label"></span>
                                            </span>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                            <div class="border-t border-gray-100 px-3 py-2">
                                <a
                                    :href="allResultsUrl"
                                    class="block w-full rounded-xl py-2 text-center text-sm font-semibold text-rose-600 hover:bg-rose-50"
                                    x-on:click="pickResult()"
                                >
                                    Tum sonuclari gor
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="flex items-center gap-2 sm:gap-4">
                    <button type="button" x-on:click="mobileSearch = !mobileSearch; if(!mobileSearch) { mobilePanelOpen = false }" class="rounded-lg p-2 text-gray-600 hover:bg-gray-50 hover:text-rose-600 md:hidden" aria-label="Ara">
                        <i data-lucide="search" class="h-6 w-6"></i>
                    </button>
                    <button type="button" x-on:click="mobileMenu = !mobileMenu" class="rounded-lg p-2 text-gray-600 hover:bg-gray-50 hover:text-rose-600 lg:hidden" aria-label="Menu">
                        <i data-lucide="menu" class="h-6 w-6"></i>
                    </button>
                    <a href="{{ auth('web')->check() ? route('dashboard') : route('login') }}" class="hidden flex-col items-center gap-0.5 text-gray-600 hover:text-rose-600 sm:flex">
                        <i data-lucide="user" class="h-[22px] w-[22px]"></i>
                        <span class="hidden text-[10px] font-medium lg:block">Hesabim</span>
                    </a>
                    <a href="{{ route('shop.cart.index') }}" class="relative flex flex-col items-center gap-0.5 text-gray-600 hover:text-rose-600">
                        <div class="relative">
                            <i data-lucide="shopping-cart" class="h-[22px] w-[22px]"></i>
                            <span class="absolute -top-2 -right-2 flex min-h-4 min-w-4 items-center justify-center rounded-full border border-white bg-rose-600 px-0.5 text-[10px] font-bold text-white">
                                {{ $cartCount ?? 0 }}
                            </span>
                        </div>
                        <span class="hidden text-[10px] font-medium sm:block">Sepet</span>
                    </a>
                </div>
            </div>

            <div x-show="mobileSearch" x-cloak x-transition class="border-t border-gray-100 py-3 md:hidden">
                <form
                    action="{{ route('shop.products.index') }}"
                    method="GET"
                    class="relative space-y-2"
                    x-on:submit="onSubmitSearch($event)"
                    x-on:click.outside="mobilePanelOpen = false"
                >
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ e(request('category')) }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ e(request('sort')) }}">
                    @endif
                    <input
                        type="search"
                        name="q"
                        x-model="q"
                        x-on:input="onSearchInput(true)"
                        x-on:focus="onSearchFocus(true)"
                        placeholder="En az 3 karakter..."
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm"
                        autocomplete="off"
                    />
                    <button type="submit" class="w-full rounded-xl bg-rose-600 py-2.5 text-sm font-semibold text-white">Ara</button>

                    <div
                        x-show="mobilePanelOpen && suggestState !== 'idle'"
                        x-cloak
                        class="max-h-64 overflow-y-auto rounded-xl border border-gray-100 bg-white shadow-lg"
                    >
                        <div x-show="suggestState === 'short'" class="px-3 py-2 text-xs text-gray-600">En az 3 karakter yazin.</div>
                        <div x-show="suggestState === 'loading'" class="px-3 py-3 text-center text-xs text-gray-500">Araniyor...</div>
                        <div x-show="suggestState === 'error'" class="px-3 py-2 text-xs text-red-600">Hata. Tekrar deneyin.</div>
                        <div x-show="suggestState === 'empty'" class="px-3 py-3 text-center text-xs">
                            <p class="font-medium text-gray-800">Urun bulunamadi</p>
                            <a :href="allResultsUrl" class="mt-2 inline-block font-semibold text-rose-600" x-on:click="pickResult()">Tum sonuclar</a>
                        </div>
                        <ul x-show="suggestState === 'results'" class="divide-y divide-gray-50 text-sm">
                            <template x-for="item in results" :key="item.slug">
                                <li>
                                    <a :href="item.url" class="block px-3 py-2 hover:bg-rose-50" x-on:click="pickResult()" x-text="item.name"></a>
                                </li>
                            </template>
                        </ul>
                    </div>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-100">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="no-scrollbar flex gap-4 overflow-x-auto py-2.5 sm:space-x-6 sm:py-3">
                    <a
                        href="{{ route('shop.products.index', array_filter(['q' => request('q'), 'sort' => request('sort')])) }}"
                        class="flex shrink-0 items-center gap-2 whitespace-nowrap text-sm font-semibold transition {{ $onProducts && ! $activeCategory ? 'text-rose-600' : 'text-gray-600 hover:text-rose-600' }}"
                    >
                        <i data-lucide="layout-grid" class="h-4 w-4"></i>
                        Tum Urunler
                    </a>
                    @foreach($shopCategories ?? [] as $category)
                        <a
                            href="{{ route('shop.products.index', array_filter(['category' => $category->slug, 'q' => request('q'), 'sort' => request('sort')])) }}"
                            class="shrink-0 whitespace-nowrap text-sm font-medium transition {{ $activeCategory === $category->slug ? 'text-rose-600' : 'text-gray-600 hover:text-rose-600' }}"
                        >
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div x-show="mobileMenu" x-cloak x-transition class="border-t border-gray-100 px-4 py-3 lg:hidden">
            <nav class="flex flex-col gap-2">
                <a href="{{ auth('web')->check() ? route('dashboard') : route('login') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Hesabim</a>
                <a href="{{ route('shop.home') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Anasayfa</a>
            </nav>
        </div>
    </header>
</div>
