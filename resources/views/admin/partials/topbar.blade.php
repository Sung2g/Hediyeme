<header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-slate-200/80 bg-white/90 px-4 backdrop-blur-md sm:px-6 lg:px-8">
    <div class="flex items-center gap-3">
        <button
            type="button"
            class="rounded-xl p-2 text-slate-600 hover:bg-slate-100 lg:hidden"
            x-on:click="sidebarOpen = true"
            aria-label="Menu"
        >
            <i data-lucide="menu" class="h-6 w-6"></i>
        </button>
        <div>
            <h1 class="text-lg font-bold tracking-tight text-slate-900 sm:text-xl">@yield('title', 'Panel')</h1>
            @hasSection('subtitle')
                <p class="text-xs text-slate-500 sm:text-sm">@yield('subtitle')</p>
            @endif
        </div>
    </div>

    <div class="flex items-center gap-2 sm:gap-3">
        <span class="hidden max-w-[140px] truncate text-xs text-slate-500 sm:block sm:max-w-[200px]" title="{{ auth()->user()->email }}">
            {{ auth()->user()->email }}
        </span>
        <form method="POST" action="{{ route('acp.logout') }}">
            @csrf
            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-700 sm:text-sm">
                <i data-lucide="log-out" class="h-4 w-4"></i>
                <span class="hidden sm:inline">Cikis</span>
            </button>
        </form>
    </div>
</header>
