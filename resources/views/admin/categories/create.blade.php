@extends('admin.layout')

@section('title', 'Kategori Ekle')

@section('content')
    <form action="{{ route('admin.categories.store') }}" method="POST" class="rounded-xl bg-white p-4 space-y-3">
        @csrf
        <h2 class="text-lg font-semibold">Yeni Kategori</h2>

        <div>
            <label class="mb-1 block text-sm font-medium">Kategori Adi</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300">
            @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" checked>
            Aktif
        </label>

        <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Kaydet</button>
    </form>
@endsection
