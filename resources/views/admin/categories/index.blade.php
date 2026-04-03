@extends('admin.layout')

@section('title', 'Kategoriler')
@section('subtitle', 'Urun gruplarini yonetin')

@section('content')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-bold text-white shadow-md shadow-rose-200 hover:bg-rose-700">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Yeni kategori
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[560px] text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="px-4 py-3">Ad</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Durum</th>
                        <th class="px-4 py-3 text-right">Islem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($categories as $category)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $category->name }}</td>
                            <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $category->slug }}</td>
                            <td class="px-4 py-3">
                                @if($category->is_active)
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase text-emerald-800">Aktif</span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-200 px-2 py-0.5 text-[10px] font-bold uppercase text-slate-600">Pasif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center justify-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-xs font-semibold text-rose-600 hover:underline">Duzenle</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Kategoriyi silmek bagli tum urunleri de silebilir. Devam?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-red-600 hover:underline">Sil</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-4 py-3">{{ $categories->links() }}</div>
    </div>
@endsection
