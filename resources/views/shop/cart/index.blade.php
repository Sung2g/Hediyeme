@extends('layouts.shop')

@section('title', 'Sepetim — hediyeme.com')

@section('content')
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Sepetim</h1>
    <p class="mt-2 text-sm text-gray-500">Urunleri guncelleyebilir veya odemeye gecebilirsiniz.</p>

    @if($items->isEmpty())
        <div class="mt-10 flex flex-col items-center rounded-3xl border border-dashed border-gray-200 bg-white py-16 text-center">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-rose-50 text-rose-500">
                <i data-lucide="shopping-bag" class="h-8 w-8"></i>
            </div>
            <p class="mt-4 text-gray-600">Sepetiniz bos.</p>
            <a href="{{ route('shop.products.index') }}" class="mt-6 inline-flex rounded-xl bg-rose-600 px-6 py-3 text-sm font-bold text-white hover:bg-rose-700">
                Alisverise basla
            </a>
        </div>
    @else
        <div class="mt-8 space-y-4">
            @foreach($items as $item)
                <div class="flex flex-col gap-4 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0 flex-1">
                        <a href="{{ route('shop.products.show', $item['slug']) }}" class="font-semibold text-gray-900 hover:text-rose-600">{{ $item['name'] }}</a>
                        <p class="mt-1 text-sm text-gray-500">{{ number_format($item['price'], 2) }} TL / adet</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <form action="{{ route('shop.cart.update', $item['product_id']) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <label class="sr-only">Adet</label>
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="20" class="w-16 rounded-xl border-gray-200 text-center text-sm shadow-sm">
                            <button type="submit" class="rounded-xl border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">Guncelle</button>
                        </form>
                        <form action="{{ route('shop.cart.destroy', $item['product_id']) }}" method="POST" onsubmit="return confirm('Urunu cikarmak istiyor musunuz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-xl bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100">Kaldir</button>
                        </form>
                    </div>
                    <p class="text-right text-base font-bold text-rose-600 sm:min-w-[100px]">{{ number_format($item['line_total'], 2) }} TL</p>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex flex-col gap-4 rounded-2xl border border-gray-100 bg-white p-6 shadow-md sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-500">Genel toplam</p>
                <p class="text-2xl font-extrabold text-gray-900">{{ number_format($subtotal, 2) }} TL</p>
            </div>
            <a href="{{ route('shop.checkout.index') }}" class="inline-flex justify-center rounded-xl bg-gray-900 px-8 py-3.5 text-sm font-bold text-white shadow-lg hover:bg-gray-800">
                Odemeye gec
            </a>
        </div>
    @endif
@endsection
