@extends('admin.layout')

@section('title', 'Kategori Duzenle')

@section('content')
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="rounded-xl bg-white p-4 space-y-3">
        @csrf
        @method('PUT')
        <h2 class="text-lg font-semibold">Kategori Duzenle</h2>

        <div>
            <label class="mb-1 block text-sm font-medium">Kategori Adi</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full rounded-lg border-gray-300">
            @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active))>
            Aktif
        </label>

        <div class="flex gap-2">
            <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Guncelle</button>
        </div>
    </form>

    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white">Sil</button>
    </form>
@endsection
