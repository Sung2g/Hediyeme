@extends('admin.layout')

@section('title', 'Urun duzenle')
@section('subtitle', $product->name)

@section('content')
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="max-w-3xl space-y-6">
        @csrf
        @method('PUT')
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            @include('admin.products.partials.form', ['product' => $product])
        </div>
        <div class="flex flex-wrap gap-3">
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-slate-800">
                <i data-lucide="save" class="h-4 w-4"></i>
                Guncelle
            </button>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Listeye don</a>
        </div>
    </form>

    @if($product->images->isNotEmpty())
        <div class="mt-8 max-w-3xl rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400">Mevcut gorseller</h3>
            <ul class="mt-4 flex flex-wrap gap-4">
                @foreach($product->images as $image)
                    <li class="relative w-28 shrink-0">
                        <img src="{{ $image->url() }}" alt="" class="h-28 w-28 rounded-xl border border-slate-100 object-cover shadow-sm">
                        @if($image->is_primary)
                            <span class="absolute top-2 left-2 rounded-lg bg-rose-600 px-2 py-0.5 text-[10px] font-bold text-white shadow">Ana</span>
                        @endif
                        <form action="{{ route('admin.products.images.destroy', [$product, $image]) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-red-600 hover:underline">Sil</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="mt-8 max-w-3xl" onsubmit="return confirm('Urunu kalici olarak silmek istediginize emin misiniz?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-bold text-red-700 hover:bg-red-100">Urunu sil</button>
    </form>
@endsection
