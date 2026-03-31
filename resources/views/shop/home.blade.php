<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hediyeme.com</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 font-sans text-gray-800">
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <a href="{{ route('shop.home') }}" class="flex shrink-0 cursor-pointer items-center gap-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-600 text-xl font-bold text-white shadow-lg shadow-rose-200">
                        <i data-lucide="gift" class="h-6 w-6"></i>
                    </div>
                    <span class="hidden text-2xl font-extrabold tracking-tight text-gray-900 sm:block">
                        hediyeme<span class="text-rose-600">.com</span>
                    </span>
                </a>

                <div class="mx-8 hidden max-w-2xl flex-1 md:flex">
                    <div class="relative w-full">
                        <input
                            type="text"
                            placeholder="Urun, kategori veya dijital hizmet arayin..."
                            class="w-full rounded-full border-2 border-gray-100 bg-gray-50 py-3 pr-4 pl-12 outline-none transition-all focus:border-rose-500 focus:bg-white focus:ring-0"
                        />
                        <i data-lucide="search" class="absolute top-3.5 left-4 h-5 w-5 text-gray-400"></i>
                        <button class="absolute top-2 right-2 rounded-full bg-rose-600 px-5 py-1.5 text-sm font-medium text-white shadow-md shadow-rose-200 transition hover:bg-rose-700">
                            Ara
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-4 sm:gap-6">
                    <button class="text-gray-600 hover:text-rose-600 md:hidden"><i data-lucide="search" class="h-6 w-6"></i></button>
                    <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="flex flex-col items-center gap-1 text-gray-600 hover:text-rose-600">
                        <i data-lucide="user" class="h-[22px] w-[22px]"></i>
                        <span class="hidden text-[10px] font-medium sm:block">Hesabim</span>
                    </a>
                    <a href="{{ route('shop.cart.index') }}" class="relative flex flex-col items-center gap-1 text-gray-600 hover:text-rose-600">
                        <div class="relative">
                            <i data-lucide="shopping-cart" class="h-[22px] w-[22px]"></i>
                            <span class="absolute -top-2 -right-2 flex h-4 w-4 items-center justify-center rounded-full border border-white bg-rose-600 text-[10px] font-bold text-white">
                                {{ $cartCount ?? 0 }}
                            </span>
                        </div>
                        <span class="hidden text-[10px] font-medium sm:block">Sepetim</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="no-scrollbar flex space-x-8 overflow-x-auto py-3">
                    <button class="flex items-center gap-2 whitespace-nowrap font-bold text-rose-600">
                        <i data-lucide="menu" class="h-[18px] w-[18px]"></i> Tum Kategoriler
                    </button>
                    @foreach($categories as $category)
                        <a href="{{ route('shop.products.index', ['category' => $category->slug]) }}" class="whitespace-nowrap font-medium text-gray-600 transition hover:text-rose-600">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl space-y-12 px-4 py-8 sm:px-6 lg:px-8">
        <section class="grid h-auto grid-cols-1 gap-4 md:grid-cols-4 md:h-[480px]">
            <div class="group relative flex cursor-pointer flex-col justify-between overflow-hidden rounded-3xl bg-gradient-to-br from-gray-900 via-gray-800 to-rose-900 p-8 text-white shadow-xl md:col-span-2 md:row-span-2">
                <div class="absolute top-0 right-0 p-8 opacity-10 transition-transform duration-500 group-hover:scale-110">
                    <i data-lucide="monitor" class="h-[200px] w-[200px]"></i>
                </div>
                <div class="relative z-10">
                    <span class="rounded-full border border-rose-400/30 bg-rose-500/30 px-3 py-1 text-xs font-bold text-rose-100 backdrop-blur-sm">Dijital Cozumler</span>
                    <h1 class="mt-6 text-4xl leading-tight font-extrabold sm:text-5xl">
                        Profesyonel <br><span class="bg-gradient-to-r from-rose-300 to-rose-100 bg-clip-text text-transparent">E-Ticaret</span> Siteniz Hazir!
                    </h1>
                    <p class="mt-4 max-w-sm text-gray-300">Tasarim, altyapi ve SEO kurulumu dahil anahtar teslim web tasarim paketleri.</p>
                </div>
                <div class="relative z-10 mt-8">
                    <a href="{{ route('shop.products.index') }}" class="flex items-center gap-2 rounded-full bg-white px-6 py-3 font-bold text-gray-900 shadow-lg transition hover:bg-rose-50 hover:text-rose-700">
                        Paketleri Incele <i data-lucide="chevron-right" class="h-[18px] w-[18px]"></i>
                    </a>
                </div>
            </div>

            <div class="group flex cursor-pointer flex-col justify-between rounded-3xl bg-rose-50 p-6 transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="rounded-full bg-rose-200/50 px-2 py-1 text-xs font-bold text-rose-600">Guzellik ve Taki</span>
                        <h3 class="mt-2 text-xl font-bold text-gray-800 transition group-hover:text-rose-600">Zarafetinizi Taclandirin</h3>
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
                        <h3 class="mt-2 text-xl font-bold text-gray-800 transition group-hover:text-emerald-600">Dogal Bakim Urunleri</h3>
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
                    <h3 class="mt-2 text-2xl font-bold text-gray-800">Ozel Tasarim Tesbihler ve Dini Eserler</h3>
                    <p class="mt-2 text-sm text-gray-500">Usta isi, garantili oltu ve kehribar.</p>
                </div>
                <div class="relative z-10 flex h-24 w-24 items-center justify-center rounded-full bg-stone-200 transition-transform group-hover:scale-110">
                    <i data-lucide="book-open" class="h-10 w-10 text-stone-500"></i>
                </div>
                <div class="absolute right-0 -bottom-10 opacity-5 transition-opacity group-hover:opacity-10">
                    <i data-lucide="book-open" class="h-[150px] w-[150px] text-stone-900"></i>
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="grid grid-cols-2 gap-6 divide-x divide-gray-100 text-center md:grid-cols-4">
                <div class="flex flex-col items-center gap-2 px-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-rose-50 text-rose-600"><i data-lucide="shield-check" class="h-5 w-5"></i></div>
                    <h4 class="text-sm font-bold text-gray-800">Guvenli Alisveris</h4>
                    <p class="text-xs text-gray-500">256-bit SSL Korumasi</p>
                </div>
                <div class="flex flex-col items-center gap-2 px-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600"><i data-lucide="truck" class="h-5 w-5"></i></div>
                    <h4 class="text-sm font-bold text-gray-800">Hizli Kargo</h4>
                    <p class="text-xs text-gray-500">Ayni gun teslimat secenegi</p>
                </div>
                <div class="flex flex-col items-center gap-2 px-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-blue-600"><i data-lucide="monitor" class="h-5 w-5"></i></div>
                    <h4 class="text-sm font-bold text-gray-800">Aninda Teslimat</h4>
                    <p class="text-xs text-gray-500">Dijital urunlerde aninda kurulum</p>
                </div>
                <div class="flex flex-col items-center gap-2 px-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-stone-100 text-stone-600"><i data-lucide="credit-card" class="h-5 w-5"></i></div>
                    <h4 class="text-sm font-bold text-gray-800">Taksit Imkani</h4>
                    <p class="text-xs text-gray-500">Tum kartlara 12 ay taksit</p>
                </div>
            </div>
        </section>

        <section>
            <div class="mb-6 flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Karma Firsatlar</h2>
                    <p class="mt-1 text-sm text-gray-500">Farkli kategorilerden sizin icin secilenler</p>
                </div>
                <a href="{{ route('shop.products.index') }}" class="flex items-center text-sm font-medium text-rose-600 hover:underline">
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
                    @endphp
                    <div class="group rounded-2xl border border-gray-100 bg-white p-4 shadow-sm transition-shadow hover:shadow-xl">
                        <div class="{{ $color }} mb-4 flex h-48 w-full items-center justify-center rounded-xl transition-transform group-hover:scale-[1.02]">
                            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-white/50 shadow-sm backdrop-blur-sm">
                                <i data-lucide="{{ $icon }}" class="h-8 w-8 text-gray-600"></i>
                            </div>
                        </div>
                        <div class="mb-2 flex items-start justify-between">
                            <span class="rounded bg-gray-100 px-2 py-1 text-xs font-bold text-gray-500">{{ $product->category->name ?? 'Kategori' }}</span>
                            <div class="flex text-amber-400">
                                <i data-lucide="star" class="h-[14px] w-[14px] fill-current"></i>
                                <i data-lucide="star" class="h-[14px] w-[14px] fill-current"></i>
                                <i data-lucide="star" class="h-[14px] w-[14px] fill-current"></i>
                                <i data-lucide="star" class="h-[14px] w-[14px] fill-current"></i>
                                <i data-lucide="star" class="h-[14px] w-[14px] fill-current"></i>
                            </div>
                        </div>
                        <h3 class="mb-2 h-10 font-bold text-gray-800">{{ $product->name }}</h3>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-lg font-extrabold text-rose-600">{{ number_format($product->price, 2) }} TL</span>
                            <form action="{{ route('shop.cart.store', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="rounded-xl bg-gray-900 p-2 text-white transition-colors hover:bg-rose-600">
                                    <i data-lucide="shopping-cart" class="h-[18px] w-[18px]"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="mt-12 border-t border-gray-800 bg-gray-900 py-16 text-gray-300">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 grid grid-cols-1 gap-12 border-b border-gray-800 pb-12 md:grid-cols-2 lg:grid-cols-4">
                <div class="col-span-1 lg:col-span-1">
                    <div class="mb-6 flex items-center gap-2">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-600 text-lg font-bold text-white shadow-lg shadow-rose-900/50">
                            <i data-lucide="gift" class="h-5 w-5"></i>
                        </div>
                        <span class="text-2xl font-extrabold tracking-tight text-white">
                            hediyeme<span class="text-rose-500">.com</span>
                        </span>
                    </div>
                    <p class="mb-6 pr-4 text-sm leading-relaxed text-gray-400">
                        Sevdiklerinize ve kendinize en ozel hediyeler, profesyonel dijital cozumlerden gunluk kisisel bakima kadar aradiginiz her sey tek bir adreste.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-800 transition-all hover:-translate-y-1 hover:bg-rose-600 hover:text-white"><i data-lucide="facebook" class="h-[18px] w-[18px]"></i></a>
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-800 transition-all hover:-translate-y-1 hover:bg-rose-600 hover:text-white"><i data-lucide="instagram" class="h-[18px] w-[18px]"></i></a>
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-800 transition-all hover:-translate-y-1 hover:bg-rose-600 hover:text-white"><i data-lucide="twitter" class="h-[18px] w-[18px]"></i></a>
                    </div>
                </div>

                <div>
                    <h3 class="mb-6 text-sm font-bold tracking-wider text-white uppercase">Kategoriler</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('shop.products.index', ['category' => $category->slug]) }}" class="flex items-center gap-2 transition-colors hover:text-rose-400">
                                    <i data-lucide="chevron-right" class="h-[14px] w-[14px] text-rose-600"></i> {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="mb-6 text-sm font-bold tracking-wider text-white uppercase">Musteri Hizmetleri</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="flex items-center gap-2 transition-colors hover:text-rose-400"><i data-lucide="chevron-right" class="h-[14px] w-[14px] text-rose-600"></i> Hakkimizda</a></li>
                        <li><a href="#" class="flex items-center gap-2 transition-colors hover:text-rose-400"><i data-lucide="chevron-right" class="h-[14px] w-[14px] text-rose-600"></i> Siparis Takibi</a></li>
                        <li><a href="#" class="flex items-center gap-2 transition-colors hover:text-rose-400"><i data-lucide="chevron-right" class="h-[14px] w-[14px] text-rose-600"></i> Iade ve Degisim Sartlari</a></li>
                        <li><a href="#" class="flex items-center gap-2 transition-colors hover:text-rose-400"><i data-lucide="chevron-right" class="h-[14px] w-[14px] text-rose-600"></i> Sikca Sorulan Sorular</a></li>
                        <li><a href="#" class="flex items-center gap-2 transition-colors hover:text-rose-400"><i data-lucide="chevron-right" class="h-[14px] w-[14px] text-rose-600"></i> Gizlilik ve Cerez Politikasi</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-6 text-sm font-bold tracking-wider text-white uppercase">Iletisim ve Bulten</h3>
                    <ul class="mb-6 space-y-4 text-sm text-gray-400">
                        <li class="flex items-start gap-3"><i data-lucide="map-pin" class="mt-0.5 h-[18px] w-[18px] shrink-0 text-rose-500"></i> <span>Istiklal Cad. No:123<br>Sakarya, Turkiye</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="phone" class="h-[18px] w-[18px] shrink-0 text-rose-500"></i> <span>+90 (850) 123 45 67</span></li>
                        <li class="flex items-center gap-3"><i data-lucide="mail" class="h-[18px] w-[18px] shrink-0 text-rose-500"></i> <span>destek@hediyeme.com</span></li>
                    </ul>
                    <form class="mt-4 flex" action="#" method="POST" onsubmit="event.preventDefault();">
                        <input type="email" placeholder="E-posta adresiniz" class="w-full rounded-l-lg border border-gray-700 bg-gray-800 px-4 py-2.5 text-sm text-white focus:border-rose-500 focus:outline-none">
                        <button type="submit" class="whitespace-nowrap rounded-r-lg bg-rose-600 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-rose-700">
                            Abone Ol
                        </button>
                    </form>
                </div>
            </div>

            <div class="flex flex-col items-center justify-between gap-6 md:flex-row">
                <div class="text-center text-sm text-gray-500 md:text-left">
                    &copy; {{ now()->year }} hediyeme.com. Tum haklari saklidir.
                </div>
                <div class="flex gap-3 opacity-70">
                    <div class="flex h-8 w-12 items-center justify-center rounded bg-white text-[11px] font-extrabold text-blue-900 italic">VISA</div>
                    <div class="flex h-8 w-12 items-center justify-center rounded bg-white text-[11px] font-extrabold text-red-600">MASTER</div>
                    <div class="flex h-8 w-12 items-center justify-center rounded bg-white text-[11px] font-extrabold text-cyan-700">AMEX</div>
                    <div class="flex h-8 w-12 items-center justify-center rounded border border-gray-600 bg-gray-800 text-[11px] font-extrabold text-white">TROY</div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
