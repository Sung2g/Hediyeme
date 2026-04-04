@php
    $baseUrl = rtrim(url('/'), '/');
    $turkeyProvinces = app(\App\Services\TurkeyGeoService::class)->provincesForSelect();
@endphp
<div
    x-data="{
        open: false,
        slug: '',
        title: '',
        quantity: 1,
        firstName: '',
        lastName: '',
        phone: '',
        city: '',
        district: '',
        address: '',
        sellerNote: '',
        provinces: @js($turkeyProvinces),
        baseUrl: @js($baseUrl),
        previewUrl: @js(route('shop.cart.cod_preview')),
        codShipping: @js((float) config('shop.cod_shipping_fee', 0)),
        preview: { items: [], subtotal: 0, shipping: 0, total: 0 },
        previewLoading: false,
        get action() { return this.baseUrl + '/urunler/' + this.slug + '/kapida-odeme'; },
        get districtsList() {
            const p = this.provinces.find((x) => x.name === this.city);
            return p ? p.districts : [];
        },
        formatTl(n) {
            return new Intl.NumberFormat('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(Number(n || 0));
        },
        async loadPreview() {
            if (!this.slug) return;
            this.previewLoading = true;
            try {
                const u = new URL(this.previewUrl, window.location.origin);
                u.searchParams.set('product_slug', this.slug);
                u.searchParams.set('quantity', String(this.quantity));
                const r = await fetch(u.toString(), { headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
                if (!r.ok) throw new Error('preview');
                this.preview = await r.json();
            } catch (e) {
                this.preview = {
                    items: [],
                    subtotal: 0,
                    shipping: 0,
                    total: 0,
                };
            } finally {
                this.previewLoading = false;
                this.$nextTick(() => { if (window.lucide) lucide.createIcons(); });
            }
        },
        openModal(detail) {
            this.open = true;
            this.slug = detail.slug || '';
            this.title = detail.title || '';
            this.quantity = detail.quantity != null ? Math.min(20, Math.max(1, Number(detail.quantity))) : 1;
            this.firstName = '';
            this.lastName = '';
            this.phone = '';
            this.city = '';
            this.district = '';
            this.address = '';
            this.sellerNote = '';
            this.$nextTick(() => this.loadPreview());
        }
    }"
    x-on:open-shop-cod.window="openModal($event.detail)"
    class="relative z-[200]"
>
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"
        x-on:click="open = false"
        aria-hidden="true"
    ></div>

    <div
        x-show="open"
        x-cloak
        x-transition
        class="fixed inset-0 z-[201] flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
        aria-labelledby="cod-modal-title"
    >
        <div
            class="max-h-[92vh] w-full max-w-xl overflow-y-auto rounded-2xl bg-white text-gray-900 shadow-2xl ring-1 ring-gray-200"
            x-on:click.stop
        >
            <div class="sticky top-0 z-10 flex items-start justify-between gap-4 border-b border-gray-100 bg-white/95 px-5 py-4 backdrop-blur supports-[backdrop-filter]:bg-white/80">
                <div>
                    <h2 id="cod-modal-title" class="text-lg font-bold tracking-tight text-gray-900 sm:text-xl">Kapıda ödeme ile sipariş</h2>
                    <p class="mt-0.5 text-sm leading-snug text-gray-600 sm:mt-1 sm:text-base" x-text="title"></p>
                </div>
                <button type="button" class="rounded-lg px-2 py-1 text-2xl leading-none text-gray-400 hover:bg-gray-100 hover:text-gray-700" x-on:click="open = false" aria-label="Kapat">&times;</button>
            </div>

            <div class="px-5 pb-6 pt-5">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                    <p class="text-sm font-semibold tracking-wide text-gray-800">Sepet özeti</p>
                    <template x-if="previewLoading">
                        <p class="mt-4 text-base text-gray-600">Yükleniyor…</p>
                    </template>
                    <template x-if="!previewLoading && preview.items.length === 0">
                        <p class="mt-4 text-base text-gray-600">Sepet satırı bulunamadı.</p>
                    </template>
                    <ul class="mt-4 space-y-3" x-show="!previewLoading && preview.items.length">
                        <template x-for="(row, idx) in preview.items" :key="idx">
                            <li class="flex gap-3 sm:gap-4">
                                <div class="relative h-14 w-14 shrink-0 sm:h-16 sm:w-16">
                                    <div class="h-full w-full overflow-hidden rounded-xl bg-gray-200 ring-1 ring-gray-200/90">
                                        <img x-show="row.thumb_url" :src="row.thumb_url" :alt="row.name" class="h-full w-full object-cover" width="64" height="64" loading="lazy">
                                        <div x-show="!row.thumb_url" class="flex h-full w-full items-center justify-center text-gray-400">
                                            <i data-lucide="image" class="h-5 w-5 sm:h-6 sm:w-6"></i>
                                        </div>
                                    </div>
                                    <span class="absolute right-0.5 top-0.5 z-10 flex h-5 min-w-[1.125rem] items-center justify-center rounded-full bg-rose-600 px-1 text-[10px] font-bold tabular-nums leading-none text-white shadow ring-1 ring-white/90" x-text="row.quantity"></span>
                                </div>
                                <div class="min-w-0 flex-1 pt-0.5">
                                    <p class="text-sm font-semibold leading-snug text-gray-900 sm:text-base" x-text="row.name"></p>
                                    <p class="mt-1 text-sm tabular-nums font-medium text-gray-700 sm:text-base"><span x-text="formatTl(row.line_total)"></span> TL</p>
                                </div>
                            </li>
                        </template>
                    </ul>
                    <div class="mt-5 space-y-2 border-t border-gray-200 pt-4 text-base" x-show="!previewLoading && preview.items.length">
                        <div class="flex justify-between leading-relaxed text-gray-700">
                            <span class="font-medium">Ara toplam</span>
                            <span class="tabular-nums font-semibold text-gray-900"><span x-text="formatTl(preview.subtotal)"></span> TL</span>
                        </div>
                        <div class="flex justify-between leading-relaxed text-gray-700">
                            <span class="font-medium">Kargo</span>
                            <span x-show="Number(preview.shipping) === 0" class="font-semibold text-emerald-700">Ücretsiz</span>
                            <span x-show="Number(preview.shipping) !== 0" class="tabular-nums font-semibold text-gray-900"><span x-text="formatTl(preview.shipping)"></span> TL</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-3 text-lg font-bold leading-snug text-gray-900">
                            <span>Toplam</span>
                            <span class="tabular-nums text-rose-600"><span x-text="formatTl(preview.total)"></span> TL</span>
                        </div>
                    </div>
                </div>

                <form method="POST" :action="action" class="mt-5 space-y-3">
                    @csrf
                    <input type="hidden" name="quantity" :value="quantity">

                    <div class="flex items-center gap-2 sm:gap-3">
                        <label for="cod-first-name" class="flex w-[6.75rem] shrink-0 items-center gap-1.5 text-xs font-semibold leading-none text-gray-800 sm:w-32 sm:text-sm">
                            <i data-lucide="user" class="h-3.5 w-3.5 shrink-0 text-rose-600 sm:h-4 sm:w-4"></i>
                            <span>İsim<span class="text-rose-600">*</span></span>
                        </label>
                        <input id="cod-first-name" type="text" name="first_name" x-model="firstName" required autocomplete="given-name" placeholder="İsim" class="min-w-0 flex-1 rounded-lg border-gray-300 py-2 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:rounded-xl sm:py-2.5">
                    </div>
                    <div class="flex items-center gap-2 sm:gap-3">
                        <label for="cod-last-name" class="flex w-[6.75rem] shrink-0 items-center gap-1.5 text-xs font-semibold leading-none text-gray-800 sm:w-32 sm:text-sm">
                            <i data-lucide="user-circle" class="h-3.5 w-3.5 shrink-0 text-rose-600 sm:h-4 sm:w-4"></i>
                            <span>Soyisim<span class="text-rose-600">*</span></span>
                        </label>
                        <input id="cod-last-name" type="text" name="last_name" x-model="lastName" required autocomplete="family-name" placeholder="Soyisim" class="min-w-0 flex-1 rounded-lg border-gray-300 py-2 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:rounded-xl sm:py-2.5">
                    </div>
                    <div class="flex items-center gap-2 sm:gap-3">
                        <label for="cod-phone" class="flex w-[6.75rem] shrink-0 items-center gap-1.5 text-xs font-semibold leading-none text-gray-800 sm:w-32 sm:text-sm">
                            <i data-lucide="phone" class="h-3.5 w-3.5 shrink-0 text-rose-600 sm:h-4 sm:w-4"></i>
                            <span class="whitespace-nowrap">Telefon<span class="text-rose-600">*</span></span>
                        </label>
                        <input id="cod-phone" type="text" name="phone" x-model="phone" required autocomplete="tel" placeholder="Telefon" class="min-w-0 flex-1 rounded-lg border-gray-300 py-2 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:rounded-xl sm:py-2.5">
                    </div>
                    <div class="flex items-center gap-2 sm:gap-3">
                        <label for="cod-city" class="flex w-[6.75rem] shrink-0 items-center gap-1.5 text-xs font-semibold leading-none text-gray-800 sm:w-32 sm:text-sm">
                            <i data-lucide="map-pin" class="h-3.5 w-3.5 shrink-0 text-rose-600 sm:h-4 sm:w-4"></i>
                            <span>Şehir<span class="text-rose-600">*</span></span>
                        </label>
                        <select id="cod-city" name="shipping_city" x-model="city" required class="min-w-0 flex-1 rounded-lg border-gray-300 py-2 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:rounded-xl sm:py-2.5" x-on:change="district = ''">
                            <option value="">İl seçin</option>
                            <template x-for="p in provinces" :key="p.name">
                                <option :value="p.name" x-text="p.name"></option>
                            </template>
                        </select>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-3">
                        <label for="cod-district" class="flex w-[6.75rem] shrink-0 items-center gap-1.5 text-xs font-semibold leading-none text-gray-800 sm:w-32 sm:text-sm">
                            <i data-lucide="map" class="h-3.5 w-3.5 shrink-0 text-rose-600 sm:h-4 sm:w-4"></i>
                            <span>İlçe<span class="text-rose-600">*</span></span>
                        </label>
                        <select id="cod-district" name="shipping_district" x-model="district" required :disabled="!city" class="min-w-0 flex-1 rounded-lg border-gray-300 py-2 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500 disabled:cursor-not-allowed disabled:bg-gray-100 sm:rounded-xl sm:py-2.5">
                            <option value="">İlçe seçin</option>
                            <template x-for="d in districtsList" :key="d">
                                <option :value="d" x-text="d"></option>
                            </template>
                        </select>
                    </div>
                    <div class="flex items-start gap-2 sm:gap-3">
                        <label for="cod-address" class="flex w-[6.75rem] shrink-0 items-center gap-1.5 pt-2 text-xs font-semibold leading-none text-gray-800 sm:w-32 sm:items-start sm:pt-2.5 sm:text-sm">
                            <i data-lucide="home" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-rose-600 sm:h-4 sm:w-4"></i>
                            <span>Adres<span class="text-rose-600">*</span></span>
                        </label>
                        <textarea id="cod-address" name="shipping_address" x-model="address" required rows="2" placeholder="Adres" class="min-h-[3rem] min-w-0 flex-1 resize-y rounded-lg border-gray-300 py-2 text-sm leading-snug shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:min-h-[3.25rem] sm:rounded-xl"></textarea>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-3">
                        <label for="cod-note" class="flex w-[6.75rem] shrink-0 items-center gap-1.5 text-xs font-semibold leading-none text-gray-800 sm:w-32 sm:text-sm">
                            <i data-lucide="sticky-note" class="h-3.5 w-3.5 shrink-0 text-rose-600 sm:h-4 sm:w-4"></i>
                            <span class="leading-tight">Satıcıya not</span>
                        </label>
                        <input id="cod-note" type="text" name="seller_note" x-model="sellerNote" class="min-w-0 flex-1 rounded-lg border-gray-300 py-2 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:rounded-xl sm:py-2.5" placeholder="İsteğe bağlı" maxlength="2000" autocomplete="off">
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <button type="submit" class="flex w-full items-center justify-center gap-2.5 rounded-xl bg-rose-600 px-4 py-3 text-sm font-bold text-white shadow-md transition hover:bg-rose-700 disabled:opacity-60 sm:py-3.5 sm:text-base" :disabled="previewLoading">
                            <i data-lucide="shopping-cart" class="h-5 w-5 shrink-0 sm:h-6 sm:w-6"></i>
                            <span>Siparişi Tamamla — </span>
                            <span class="tabular-nums" x-text="formatTl(preview.total)"></span>
                            <span> TL</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
