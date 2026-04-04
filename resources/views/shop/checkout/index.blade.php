@extends('layouts.shop')

@section('title', 'Odeme — hediyeme.com')

@section('content')
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Siparisi tamamla</h1>
    <p class="mt-2 text-sm text-gray-500">Iletisim ve odeme yonteminizi secin.</p>

    <div class="mt-10 grid gap-8 lg:grid-cols-2 lg:gap-12">
        <form action="{{ route('shop.checkout.store') }}" method="POST" class="space-y-5 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            @csrf

            @guest('web')
                @php $pf = $checkoutPrefill ?? []; @endphp
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Ad Soyad</label>
                    <input type="text" name="name" value="{{ old('name', $pf['name'] ?? '') }}" class="w-full rounded-xl border-gray-200 shadow-sm">
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">E-posta</label>
                    <input type="email" name="email" value="{{ old('email', $pf['email'] ?? '') }}" class="w-full rounded-xl border-gray-200 shadow-sm">
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            @endguest

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Telefon</label>
                <input type="text" name="phone" value="{{ old('phone', ($checkoutPrefill ?? [])['phone'] ?? '') }}" class="w-full rounded-xl border-gray-200 shadow-sm" placeholder="+90 ...">
                @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Odeme yontemi</label>
                <select name="payment_method" class="w-full rounded-xl border-gray-200 shadow-sm">
                    @foreach($paymentMethods as $key => $label)
                        <option value="{{ $key }}" @selected(old('payment_method', $selectedPaymentMethod ?? 'simulated_online') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('payment_method')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="w-full rounded-xl bg-rose-600 py-3.5 text-sm font-bold text-white shadow-md hover:bg-rose-700">
                Siparisi onayla
            </button>
        </form>

        <div class="h-fit rounded-2xl border border-gray-100 bg-gray-50/80 p-6">
            <h2 class="font-bold text-gray-900">Sepet ozeti</h2>
            <ul class="mt-4 space-y-3">
                @foreach($items as $item)
                    <li class="flex justify-between gap-4 text-sm">
                        <span class="text-gray-600">{{ $item['name'] }} <span class="text-gray-400">×{{ $item['quantity'] }}</span></span>
                        <span class="shrink-0 font-semibold text-gray-900">{{ number_format($item['line_total'], 2) }} TL</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-6 border-t border-gray-200 pt-4">
                <div class="flex items-center justify-between text-lg font-extrabold text-gray-900">
                    <span>Toplam</span>
                    <span class="text-rose-600">{{ number_format($subtotal, 2) }} TL</span>
                </div>
            </div>
        </div>
    </div>
@endsection
