@extends('admin.layout')

@section('title', 'Yorumlar')
@section('subtitle', 'Musteri degerlendirmelerini onaylayin veya silin')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="inline-flex rounded-xl border border-slate-200 bg-white p-1 shadow-sm">
            <a
                href="{{ route('admin.reviews.index', ['durum' => 'tumu']) }}"
                class="rounded-lg px-3 py-1.5 text-xs font-semibold sm:text-sm {{ $filter === 'tumu' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50' }}"
            >Tumu</a>
            <a
                href="{{ route('admin.reviews.index', ['durum' => 'bekleyen']) }}"
                class="rounded-lg px-3 py-1.5 text-xs font-semibold sm:text-sm {{ $filter === 'bekleyen' ? 'bg-amber-500 text-white' : 'text-slate-600 hover:bg-slate-50' }}"
            >Bekleyen</a>
            <a
                href="{{ route('admin.reviews.index', ['durum' => 'onayli']) }}"
                class="rounded-lg px-3 py-1.5 text-xs font-semibold sm:text-sm {{ $filter === 'onayli' ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-50' }}"
            >Onayli</a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="px-4 py-3">Urun</th>
                        <th class="px-4 py-3">Yazar</th>
                        <th class="px-4 py-3">Puan</th>
                        <th class="px-4 py-3">Yorum</th>
                        <th class="px-4 py-3">Durum</th>
                        <th class="px-4 py-3 text-right">Islem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($reviews as $review)
                        @php
                            $author = $review->user?->name ?? $review->guest_name ?? 'Misafir';
                        @endphp
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.products.edit', $review->product_id) }}" class="font-semibold text-slate-900 hover:text-rose-600">
                                    {{ \Illuminate\Support\Str::limit($review->product->name ?? '-', 36) }}
                                </a>
                                @if($review->product)
                                    <a href="{{ route('shop.products.show', $review->product->slug) }}" target="_blank" rel="noopener" class="mt-0.5 block text-xs text-slate-400 hover:text-rose-600">Vitrin</a>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-700">
                                <span class="font-medium">{{ $author }}</span>
                                @if($review->guest_email)
                                    <span class="mt-0.5 block text-xs text-slate-400">{{ $review->guest_email }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-0.5 rounded-lg bg-amber-50 px-2 py-1 text-xs font-bold text-amber-800">
                                    {{ $review->rating }}/5
                                </span>
                            </td>
                            <td class="max-w-xs px-4 py-3 text-slate-600">
                                <p class="line-clamp-2">{{ $review->body }}</p>
                                <time class="mt-1 block text-[10px] text-slate-400" datetime="{{ $review->created_at->toIso8601String() }}">{{ $review->created_at->format('d.m.Y H:i') }}</time>
                            </td>
                            <td class="px-4 py-3">
                                @if($review->is_approved)
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase text-emerald-800">Onayli</span>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold uppercase text-amber-800">Bekliyor</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center justify-end gap-2">
                                    @unless($review->is_approved)
                                        <form action="{{ route('admin.reviews.update', $review) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="is_approved" value="1">
                                            <button type="submit" class="rounded-lg bg-emerald-600 px-2.5 py-1 text-xs font-semibold text-white hover:bg-emerald-700">Onayla</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.reviews.update', $review) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="is_approved" value="0">
                                            <button type="submit" class="rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-semibold text-slate-600 hover:bg-slate-50">Kaldir</button>
                                        </form>
                                    @endunless
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Bu yorumu silmek istediginize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 hover:bg-red-100">Sil</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-sm text-slate-500">Bu filtrede yorum yok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-4 py-3">{{ $reviews->links() }}</div>
    </div>
@endsection
