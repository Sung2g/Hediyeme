@extends('shop.layout')

@section('title', 'Sepet')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Sepetim</h1>

    @if($items->isEmpty())
        <p class="rounded-lg bg-white p-4 text-sm text-gray-600">Sepetiniz bos.</p>
    @else
        <div class="space-y-3">
            @foreach($items as $item)
                <div class="rounded-xl border border-gray-200 bg-white p-4">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="font-semibold">{{ $item['name'] }}</p>
                            <p class="text-sm text-gray-500">{{ number_format($item['price'], 2) }} TL</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <form action="{{ route('shop.cart.update', $item['product_id']) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="20" class="w-20 rounded-md border-gray-300 text-sm">
                                <button type="submit" class="rounded-md border px-3 py-2 text-xs">Guncelle</button>
                            </form>
                            <form action="{{ route('shop.cart.destroy', $item['product_id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-xs text-white">Sil</button>
                            </form>
                        </div>
                    </div>
                    <p class="mt-2 text-right text-sm font-semibold">Ara Toplam: {{ number_format($item['line_total'], 2) }} TL</p>
                </div>
            @endforeach
        </div>

        <div class="mt-6 rounded-xl border border-gray-200 bg-white p-4">
            <p class="text-lg font-bold">Genel Toplam: {{ number_format($subtotal, 2) }} TL</p>
            <a href="{{ route('shop.checkout.index') }}" class="mt-4 inline-block rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">
                Odemeye Gec
            </a>
        </div>
    @endif
@endsection
