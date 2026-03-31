@extends('admin.layout')

@section('title', 'Urunler')

@section('content')
    <div class="rounded-xl bg-white p-4">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold">Urunler</h2>
            <a href="{{ route('admin.products.create') }}" class="rounded-md bg-gray-900 px-3 py-2 text-xs text-white">Yeni Urun</a>
        </div>

        <div class="overflow-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Ad</th>
                        <th class="py-2">Kategori</th>
                        <th class="py-2">Fiyat</th>
                        <th class="py-2">Stok</th>
                        <th class="py-2">Durum</th>
                        <th class="py-2">Islem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="border-b">
                            <td class="py-2">{{ $product->name }}</td>
                            <td class="py-2">{{ $product->category->name ?? '-' }}</td>
                            <td class="py-2">{{ number_format($product->price, 2) }} TL</td>
                            <td class="py-2">{{ $product->stock }}</td>
                            <td class="py-2">{{ $product->is_active ? 'Aktif' : 'Pasif' }}</td>
                            <td class="py-2"><a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600">Duzenle</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
@endsection
