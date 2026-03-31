<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Hediyeme') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 text-slate-900">
        <main class="mx-auto max-w-6xl px-6 py-10">
            <header class="mb-8 rounded-2xl bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Hediyeme</h1>
                        <p class="mt-2 text-sm text-slate-600">Laravel + Tailwind + jQuery kurulumlu e-ticaret baslangic sayfasi</p>
                    </div>
                    <div class="rounded-xl bg-indigo-600 px-4 py-2 text-white">
                        Sepet: <span id="cart-count" class="font-semibold">0</span>
                    </div>
                </div>
            </header>

            <section>
                <h2 class="mb-4 text-xl font-semibold">Ornek urunler</h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <article class="product-card rounded-2xl bg-white p-5 shadow-sm">
                        <h3 class="text-lg font-semibold">Kisisel Kupa</h3>
                        <p class="mt-2 text-sm text-slate-600">Isme ozel baskili seramik kupa.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="font-bold">249 TL</span>
                            <button class="js-add-cart rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                                Sepete Ekle
                            </button>
                        </div>
                    </article>

                    <article class="product-card rounded-2xl bg-white p-5 shadow-sm">
                        <h3 class="text-lg font-semibold">Foto Magnet Seti</h3>
                        <p class="mt-2 text-sm text-slate-600">4 adet kare fotograf magnet paketi.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="font-bold">179 TL</span>
                            <button class="js-add-cart rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                                Sepete Ekle
                            </button>
                        </div>
                    </article>

                    <article class="product-card rounded-2xl bg-white p-5 shadow-sm">
                        <h3 class="text-lg font-semibold">Hediye Kutusu</h3>
                        <p class="mt-2 text-sm text-slate-600">Defter, kalem ve minik surprizlerle dolu kutu.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="font-bold">399 TL</span>
                            <button class="js-add-cart rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                                Sepete Ekle
                            </button>
                        </div>
                    </article>
                </div>
            </section>
        </main>
    </body>
</html>
