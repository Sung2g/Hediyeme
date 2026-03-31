@extends('shop.layout')

@section('title', $product->name)

@section('content')
    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-2xl border border-gray-200 bg-white p-6">
            <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
            <p class="mt-2 text-sm text-gray-500">{{ $product->category->name ?? '-' }}</p>
            <p class="mt-6 text-gray-700">{{ $product->description }}</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6">
            <p class="text-3xl font-bold text-rose-600">{{ number_format($product->price, 2) }} TL</p>
            <p class="mt-2 text-sm text-gray-500">Stok: {{ $product->stock }}</p>
            <form action="{{ route('shop.cart.store', $product->id) }}" method="POST" class="mt-6 space-y-3">
                @csrf
                <label class="block text-sm font-medium text-gray-700">Adet</label>
                <input type="number" name="quantity" value="1" min="1" max="20" class="w-full rounded-lg border-gray-300">
                <button type="submit" class="w-full rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">
                    Sepete Ekle
                </button>
            </form>
        </div>
    </div>
@endsection
