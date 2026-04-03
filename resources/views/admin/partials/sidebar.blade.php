@php
    $pendingReviews = \App\Models\ProductReview::query()->where('is_approved', false)->count();
@endphp
<aside
    class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-slate-800/80 bg-slate-900 text-slate-200 transition-transform duration-200 ease-out max-lg:-translate-x-full lg:static lg:translate-x-0"
    :class="{ 'max-lg:translate-x-0': sidebarOpen }"
>
    <div class="flex h-16 items-center gap-2 border-b border-slate-800 px-5">
        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-rose-600 text-white shadow-lg shadow-rose-900/40">
            <i data-lucide="gauge" class="h-5 w-5"></i>
        </span>
        <div>
            <p class="text-sm font-bold tracking-tight text-white">hediyeme</p>
            <p class="text-[10px] font-medium uppercase tracking-wider text-slate-500">Yonetim</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
        <a
            href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-rose-600/20 text-white ring-1 ring-rose-500/40' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
        >
            <i data-lucide="home" class="h-4 w-4 shrink-0 opacity-80"></i>
            Ozet
        </a>
        <a
            href="{{ route('admin.orders.index') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.orders.*') ? 'bg-rose-600/20 text-white ring-1 ring-rose-500/40' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
        >
            <i data-lucide="shopping-bag" class="h-4 w-4 shrink-0 opacity-80"></i>
            Siparisler
        </a>
        <a
            href="{{ route('admin.products.index') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.products.*') ? 'bg-rose-600/20 text-white ring-1 ring-rose-500/40' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
        >
            <i data-lucide="package" class="h-4 w-4 shrink-0 opacity-80"></i>
            Urunler
        </a>
        <a
            href="{{ route('admin.categories.index') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.categories.*') ? 'bg-rose-600/20 text-white ring-1 ring-rose-500/40' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
        >
            <i data-lucide="folder" class="h-4 w-4 shrink-0 opacity-80"></i>
            Kategoriler
        </a>
        <a
            href="{{ route('admin.reviews.index') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.reviews.*') ? 'bg-rose-600/20 text-white ring-1 ring-rose-500/40' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
        >
            <i data-lucide="message-square-text" class="h-4 w-4 shrink-0 opacity-80"></i>
            Yorumlar
            @if($pendingReviews > 0)
                <span class="ml-auto rounded-full bg-amber-500 px-2 py-0.5 text-[10px] font-bold text-slate-900">{{ $pendingReviews }}</span>
            @endif
        </a>
    </nav>

    <div class="border-t border-slate-800 p-3">
        <a
            href="{{ route('shop.home') }}"
            target="_blank"
            rel="noopener"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-400 transition hover:bg-slate-800 hover:text-white"
        >
            <i data-lucide="external-link" class="h-4 w-4 shrink-0"></i>
            Siteyi ac
        </a>
    </div>
</aside>

<div
    x-show="sidebarOpen"
    x-transition.opacity
    class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden"
    x-on:click="sidebarOpen = false"
    style="display: none;"
></div>
