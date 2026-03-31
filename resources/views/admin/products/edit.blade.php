@extends('admin.layout')

@section('title', 'Urun Duzenle')

@section('content')
    <form action="{{ route('admin.products.update', $product) }}" method="POST" class="rounded-xl bg-white p-4 space-y-3">
        @csrf
        @method('PUT')
        <h2 class="text-lg font-semibold">Urun Duzenle</h2>
        @include('admin.products.partials.form', ['product' => $product])
        <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Guncelle</button>
    </form>

    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white">Sil</button>
    </form>
@endsection
