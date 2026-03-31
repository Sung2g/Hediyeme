<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hediyeme')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">
    <header class="bg-white border-b border-gray-200">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
            <a href="{{ route('shop.home') }}" class="text-xl font-bold">hediyeme.com</a>
            <nav class="flex items-center gap-4 text-sm">
                <a href="{{ route('shop.products.index') }}" class="hover:text-rose-600">Urunler</a>
                <a href="{{ route('shop.cart.index') }}" class="hover:text-rose-600">
                    Sepet ({{ $cartCount ?? 0 }})
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-rose-600">Panel</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-rose-600">Giris</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8">
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
