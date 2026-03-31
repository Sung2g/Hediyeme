<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="mx-auto max-w-7xl px-4 py-8">
        <header class="mb-6 flex flex-wrap items-center justify-between gap-3 rounded-xl bg-white p-4">
            <h1 class="text-xl font-bold">Admin Panel</h1>
            <nav class="flex items-center gap-3 text-sm">
                <a href="{{ route('admin.orders.index') }}" class="hover:text-rose-600">Siparisler</a>
                <a href="{{ route('admin.categories.index') }}" class="hover:text-rose-600">Kategoriler</a>
                <a href="{{ route('admin.products.index') }}" class="hover:text-rose-600">Urunler</a>
                <a href="{{ route('shop.home') }}" class="hover:text-rose-600">Siteye Don</a>
            </nav>
        </header>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
