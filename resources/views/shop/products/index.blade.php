@extends('shop.layout')

@section('title', 'Urunler')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Urunler</h1>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($products as $product)
            <article class="rounded-xl border border-gray-200 bg-white p-4">
                <p class="text-xs text-gray-500">{{ $product->category->name ?? '-' }}</p>
                <h2 class="mt-1 font-semibold">{{ $product->name }}</h2>
                <p class="mt-2 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($product->description, 90) }}</p>
                <p class="mt-4 font-bold text-rose-600">{{ number_format($product->price, 2) }} TL</p>
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('shop.products.show', $product->slug) }}" class="rounded-md border px-3 py-2 text-xs">Detay</a>
                    <form action="{{ route('shop.cart.store', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-md bg-gray-900 px-3 py-2 text-xs text-white">Sepete Ekle</button>
                    </form>
                </div>
            </article>
        @empty
            <p class="text-sm text-gray-500">Urun bulunamadi.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
@endsection
