@extends('admin.layout')

@section('title', 'Kategori duzenle')
@section('subtitle', $category->name)

@section('content')
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="max-w-lg space-y-6">
        @csrf
        @method('PUT')
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm space-y-4">
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Kategori adi</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500">
                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <p class="text-xs text-slate-500">Slug: <code class="rounded bg-slate-100 px-1.5 py-0.5 font-mono">{{ $category->slug }}</code></p>
            <label class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-700">
                <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500" @checked(old('is_active', $category->is_active))>
                Aktif
            </label>
        </div>
        <div class="flex flex-wrap gap-3">
            <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-slate-800">Guncelle</button>
            <a href="{{ route('admin.categories.index') }}" class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Listeye don</a>
        </div>
    </form>
@endsection
