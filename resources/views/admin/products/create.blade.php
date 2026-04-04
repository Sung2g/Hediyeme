@extends('admin.layout')

@section('title', 'Yeni urun')
@section('subtitle', 'Vitrine eklenecek urun bilgileri')

@section('content')
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="mx-auto w-full max-w-5xl space-y-6">
        @csrf
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
            @include('admin.products.partials.form', ['product' => null])
        </div>
        <div class="flex flex-wrap gap-3">
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-slate-800">
                <i data-lucide="save" class="h-4 w-4"></i>
                Kaydet
            </button>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Vazgec</a>
        </div>
    </form>
@endsection
