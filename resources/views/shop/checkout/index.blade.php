@extends('shop.layout')

@section('title', 'Checkout')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Siparisi Tamamla</h1>

    <div class="grid gap-6 md:grid-cols-2">
        <form action="{{ route('shop.checkout.store') }}" method="POST" class="rounded-xl border border-gray-200 bg-white p-5 space-y-4">
            @csrf

            @guest
                <div>
                    <label class="mb-1 block text-sm font-medium">Ad Soyad</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300">
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium">E-Posta</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300">
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            @endguest

            <div>
                <label class="mb-1 block text-sm font-medium">Telefon</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-lg border-gray-300">
                @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium">Odeme Yontemi</label>
                <select name="payment_method" class="w-full rounded-lg border-gray-300">
                    @foreach($paymentMethods as $key => $label)
                        <option value="{{ $key }}" @selected(old('payment_method') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('payment_method')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="w-full rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">
                Siparisi Onayla
            </button>
        </form>

        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <h2 class="font-semibold">Sepet Ozeti</h2>
            <div class="mt-4 space-y-2">
                @foreach($items as $item)
                    <div class="flex justify-between text-sm">
                        <span>{{ $item['name'] }} x{{ $item['quantity'] }}</span>
                        <span>{{ number_format($item['line_total'], 2) }} TL</span>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 border-t pt-4 text-right">
                <p class="text-lg font-bold">Toplam: {{ number_format($subtotal, 2) }} TL</p>
            </div>
        </div>
    </div>
@endsection
