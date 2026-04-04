@extends('admin.layout')

@section('title', 'Urun duzenle')
@section('subtitle', $product->name)

@section('content')
    @php $hasImages = $product->images->isNotEmpty(); @endphp

    <div class="flex flex-col gap-10 @if($hasImages) xl:grid xl:grid-cols-12 xl:items-start xl:gap-10 @else max-w-5xl mx-auto w-full @endif">
        <div class="@if($hasImages) xl:col-span-7 2xl:col-span-8 @endif w-full min-w-0">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                    @include('admin.products.partials.form', ['product' => $product])
                </div>
                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-slate-800">
                        <i data-lucide="save" class="h-4 w-4"></i>
                        Guncelle
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Listeye don</a>
                </div>
            </form>
        </div>

        @if($hasImages)
            <aside class="w-full min-w-0 xl:col-span-5 2xl:col-span-4">
                <div class="xl:sticky xl:top-28">
                    <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400">Mevcut gorseller</h3>
                        <p class="mt-1 text-xs leading-relaxed text-slate-500">Surukleyerek sirayi degistirin; vitrin galerisi bu sirayi kullanir. Ana rozet ayni gorselde kalir.</p>
                        <p id="image-reorder-status" class="mt-2 hidden text-xs font-medium text-emerald-600" role="status"></p>
                        <p id="image-reorder-error" class="mt-2 hidden text-xs font-medium text-red-600" role="alert"></p>

                        <ul id="product-images-sortable" class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-3">
                            @foreach($product->images as $image)
                                <li
                                    data-image-id="{{ $image->id }}"
                                    class="group relative flex flex-col overflow-hidden rounded-xl border border-slate-200 bg-slate-50/80 shadow-sm transition hover:border-rose-200"
                                >
                                    <div class="flex items-stretch gap-0 border-b border-slate-100 bg-white">
                                        <button
                                            type="button"
                                            class="js-drag-handle flex shrink-0 cursor-grab touch-none items-center justify-center border-r border-slate-100 bg-slate-50 px-2 text-slate-400 hover:bg-rose-50 hover:text-rose-600 active:cursor-grabbing"
                                            title="Surukle"
                                            aria-label="Surukle"
                                        >
                                            <i data-lucide="grip-vertical" class="h-5 w-5"></i>
                                        </button>
                                        <div class="relative min-h-[7rem] flex-1">
                                            <img src="{{ $image->url() }}" alt="" class="h-28 w-full object-cover sm:h-32">
                                            @if($image->is_primary)
                                                <span class="absolute top-2 right-2 rounded-md bg-rose-600 px-1.5 py-0.5 text-[10px] font-bold text-white shadow">Ana</span>
                                            @endif
                                        </div>
                                    </div>
                                    <form action="{{ route('admin.products.images.destroy', [$product, $image]) }}" method="POST" class="border-t border-slate-100 bg-white p-2 text-center">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-red-600 hover:underline">Sil</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </aside>
        @endif
    </div>

    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="mt-10 max-w-5xl border-t border-slate-200 pt-8 @if($hasImages) xl:max-w-none @endif" onsubmit="return confirm('Urunu kalici olarak silmek istediginize emin misiniz?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-bold text-red-700 hover:bg-red-100">Urunu sil</button>
    </form>

    @if($hasImages)
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
            <script>
                (function () {
                    var el = document.getElementById('product-images-sortable');
                    var statusEl = document.getElementById('image-reorder-status');
                    var errEl = document.getElementById('image-reorder-error');
                    var token = document.querySelector('meta[name="csrf-token"]');
                    if (!el || typeof Sortable === 'undefined' || !token) return;

                    var reorderUrl = @json(route('admin.products.images.reorder', $product));

                    function hideMsgs() {
                        statusEl.classList.add('hidden');
                        errEl.classList.add('hidden');
                    }

                    function collectIds() {
                        return Array.prototype.map.call(el.querySelectorAll('[data-image-id]'), function (node) {
                            return parseInt(node.getAttribute('data-image-id'), 10);
                        });
                    }

                    new Sortable(el, {
                        animation: 160,
                        handle: '.js-drag-handle',
                        ghostClass: 'opacity-50',
                        chosenClass: 'ring-2 ring-rose-400 ring-offset-2',
                        dragClass: 'shadow-lg',
                        onEnd: function () {
                            hideMsgs();
                            fetch(reorderUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': token.getAttribute('content'),
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                credentials: 'same-origin',
                                body: JSON.stringify({ image_ids: collectIds() }),
                            })
                                .then(function (res) {
                                    if (!res.ok) return res.json().then(function (j) { throw new Error(j.message || 'Kaydedilemedi'); });
                                    return res.json();
                                })
                                .then(function () {
                                    statusEl.textContent = 'Sira kaydedildi.';
                                    statusEl.classList.remove('hidden');
                                    window.setTimeout(function () { statusEl.classList.add('hidden'); }, 2500);
                                    if (typeof lucide !== 'undefined') lucide.createIcons();
                                })
                                .catch(function () {
                                    errEl.textContent = 'Sira kaydedilemedi; sayfa yenileniyor.';
                                    errEl.classList.remove('hidden');
                                    window.setTimeout(function () { window.location.reload(); }, 800);
                                });
                        },
                    });
                })();
            </script>
        @endpush
    @endif
@endsection
