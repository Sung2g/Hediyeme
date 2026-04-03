@php
    $baseUrl = rtrim(url('/'), '/');
@endphp
<div
    x-data="{
        open: false,
        slug: '',
        title: '',
        quantity: 1,
        baseUrl: @js($baseUrl),
        get action() { return this.baseUrl + '/urunler/' + this.slug + '/kapida-odeme'; }
    }"
    x-on:open-shop-cod.window="open = true; slug = $event.detail.slug; title = $event.detail.title || ''; quantity = $event.detail.quantity != null ? Math.min(20, Math.max(1, Number($event.detail.quantity))) : 1"
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
    >
        <div
            class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl ring-1 ring-gray-200"
            x-on:click.stop
        >
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Kapida odemeyle satin al</h2>
                    <p class="mt-1 text-sm text-gray-500" x-text="title"></p>
                </div>
                <button type="button" class="rounded-lg px-2 py-1 text-2xl leading-none text-gray-400 hover:bg-gray-100 hover:text-gray-700" x-on:click="open = false" aria-label="Kapat">&times;</button>
            </div>

            <p class="mt-4 text-sm text-gray-600">
                Urun sepete eklenecek ve odeme sayfasinda <strong>kapida nakit</strong> secenegi on secili gelecektir.
            </p>

            <form x-ref="codForm" method="POST" :action="action" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Adet</label>
                    <input type="number" name="quantity" x-model.number="quantity" min="1" max="20" class="w-full rounded-xl border-gray-200 shadow-sm">
                </div>
                <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                    <button type="button" class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50" x-on:click="open = false">
                        Vazgec
                    </button>
                    <button type="submit" class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-rose-700">
                        Sepete ekle ve devam et
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
