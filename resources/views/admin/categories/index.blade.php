@extends('admin.layout')

@section('title', 'Kategoriler')

@section('content')
    <div class="rounded-xl bg-white p-4">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold">Kategoriler</h2>
            <a href="{{ route('admin.categories.create') }}" class="rounded-md bg-gray-900 px-3 py-2 text-xs text-white">Yeni Kategori</a>
        </div>

        <div class="overflow-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Ad</th>
                        <th class="py-2">Slug</th>
                        <th class="py-2">Durum</th>
                        <th class="py-2">Islem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr class="border-b">
                            <td class="py-2">{{ $category->name }}</td>
                            <td class="py-2">{{ $category->slug }}</td>
                            <td class="py-2">{{ $category->is_active ? 'Aktif' : 'Pasif' }}</td>
                            <td class="py-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600">Duzenle</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $categories->links() }}</div>
    </div>
@endsection
