<footer class="mt-auto border-t border-gray-800 bg-gray-900 py-12 text-gray-300 sm:py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10 grid grid-cols-1 gap-10 border-b border-gray-800 pb-10 md:grid-cols-2 lg:grid-cols-4">
            <div>
                <div class="mb-4 flex items-center gap-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-600 text-lg font-bold text-white shadow-lg shadow-rose-900/50">
                        <i data-lucide="gift" class="h-5 w-5"></i>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-white sm:text-2xl">
                        hediyeme<span class="text-rose-500">.com</span>
                    </span>
                </div>
                <p class="max-w-sm text-sm leading-relaxed text-gray-400">
                    Sevdiklerinize ozel hediyeler ve gunluk ihtiyaclariniz icin guvenli alisveris.
                </p>
                <div class="mt-4 flex gap-2">
                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-800 transition hover:bg-rose-600"><i data-lucide="facebook" class="h-4 w-4"></i></a>
                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-800 transition hover:bg-rose-600"><i data-lucide="instagram" class="h-4 w-4"></i></a>
                </div>
            </div>

            <div>
                <h3 class="mb-4 text-xs font-bold tracking-wider text-white uppercase">Kategoriler</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    @foreach($shopCategories ?? [] as $category)
                        <li>
                            <a href="{{ route('shop.products.index', ['category' => $category->slug]) }}" class="inline-flex items-center gap-1.5 transition hover:text-rose-400">
                                <i data-lucide="chevron-right" class="h-3.5 w-3.5 text-rose-600"></i> {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="mb-4 text-xs font-bold tracking-wider text-white uppercase">Musteri</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-rose-400">Hakkimizda</a></li>
                    <li><a href="#" class="hover:text-rose-400">Siparis takibi</a></li>
                    <li><a href="#" class="hover:text-rose-400">Iade kosullari</a></li>
                    <li><a href="#" class="hover:text-rose-400">SSS</a></li>
                </ul>
            </div>

            <div>
                <h3 class="mb-4 text-xs font-bold tracking-wider text-white uppercase">Iletisim</h3>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex gap-2"><i data-lucide="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-rose-500"></i> Sakarya, Turkiye</li>
                    <li class="flex gap-2"><i data-lucide="phone" class="h-4 w-4 shrink-0 text-rose-500"></i> +90 (850) 123 45 67</li>
                    <li class="flex gap-2"><i data-lucide="mail" class="h-4 w-4 shrink-0 text-rose-500"></i> destek@hediyeme.com</li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col items-center justify-between gap-4 text-sm text-gray-500 sm:flex-row">
            <p>&copy; {{ now()->year }} hediyeme.com</p>
            <div class="flex gap-2 opacity-70">
                <span class="rounded bg-white px-2 py-1 text-[10px] font-bold text-blue-900">VISA</span>
                <span class="rounded bg-white px-2 py-1 text-[10px] font-bold text-red-600">MC</span>
            </div>
        </div>
    </div>
</footer>
