@extends('admin.layout')

@section('title', 'Urun Ekle')

@section('content')
    <form action="{{ route('admin.products.store') }}" method="POST" class="rounded-xl bg-white p-4 space-y-3">
        @csrf
        <h2 class="text-lg font-semibold">Yeni Urun</h2>
        @include('admin.products.partials.form', ['product' => null])
        <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Kaydet</button>
    </form>
@endsection
