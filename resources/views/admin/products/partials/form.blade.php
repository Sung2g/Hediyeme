<div>
    <label class="mb-1 block text-sm font-semibold text-slate-700">Kategori</label>
    <select name="category_id" class="w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500">
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $product?->category_id) == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<div>
    <label class="mb-1 block text-sm font-semibold text-slate-700">Urun adi</label>
    <input type="text" name="name" value="{{ old('name', $product?->name) }}" class="w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500">
    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<div class="rounded-2xl border border-slate-200/80 bg-slate-50/30 p-5">
    <label class="mb-1 block text-sm font-semibold text-slate-800">Urun aciklamasi</label>
    <p class="mb-2 text-xs leading-relaxed text-slate-500">Fiyatin altinda ve liste kartlarinda gorunen <strong>kisa</strong> metin (ozet, tek paragraf onerilir).</p>
    <textarea name="description" rows="4" class="w-full rounded-xl border-slate-200 bg-white text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('description', $product?->description) }}</textarea>
    @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<div class="rounded-2xl border border-rose-100 bg-rose-50/20 p-5">
    <label class="mb-1 block text-sm font-semibold text-slate-800">Urun ozellikleri (detay)</label>
    <p class="mb-2 text-xs leading-relaxed text-slate-500">Urun sayfasinda &quot;Urun ozellikleri&quot; sekmesinde gorunen <strong>uzun ve aciklayici</strong> metin: malzeme, boyut, kullanim, paket icerigi, bakim vb.</p>
    <textarea name="features" rows="10" class="w-full rounded-xl border-slate-200 bg-white text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('features', $product?->features) }}</textarea>
    @error('features')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<div class="grid gap-4 md:grid-cols-3">
    <div>
        <label class="mb-1 block text-sm font-semibold text-slate-700">Fiyat (TL)</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product?->price) }}" class="w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500">
        @error('price')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold text-slate-700">Stok</label>
        <input type="number" name="stock" value="{{ old('stock', $product?->stock) }}" class="w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500">
        @error('stock')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold text-slate-700">Tip</label>
        <select name="type" class="w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500">
            <option value="physical" @selected(old('type', $product?->type) === 'physical')>Fiziksel</option>
            <option value="digital" @selected(old('type', $product?->type) === 'digital')>Dijital</option>
        </select>
        @error('type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-8 space-y-4 rounded-2xl border border-amber-100 bg-amber-50/40 p-5">
    <p class="text-sm font-bold text-slate-800">Indirim / kampanya</p>
    <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-amber-200/80 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-sm">
        <input type="hidden" name="is_on_sale" value="0">
        <input type="checkbox" name="is_on_sale" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500" @checked(old('is_on_sale', $product?->is_on_sale ?? false))>
        <span>Vitrinde indirimli olarak goster (rozet + istege bagli ust cizgili eski fiyat)</span>
    </label>
    <div>
        <label class="mb-1 block text-sm font-semibold text-slate-700">Liste fiyati (TL, ust cizili)</label>
        <input type="number" step="0.01" name="compare_at_price" value="{{ old('compare_at_price', $product?->compare_at_price) }}" placeholder="Ornek: 999.00" class="w-full max-w-xs rounded-xl border-slate-200 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500">
        <p class="mt-1 text-xs text-slate-500">Satis fiyatindan buyuk girin; bos birakirsaniz sadece &quot;indirimde&quot; rozetleri gorunur.</p>
        @error('compare_at_price')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-6 space-y-3 rounded-2xl border border-emerald-100 bg-emerald-50/40 p-5">
    <p class="text-sm font-bold text-slate-800">Kapida odeme</p>
    <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-emerald-200/80 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-sm">
        <input type="hidden" name="cod_enabled" value="0">
        <input type="checkbox" name="cod_enabled" value="1" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" @checked(old('cod_enabled', $product?->cod_enabled ?? true))>
        <span>Vitrinde kapida odemeyle satin al secenegi acik olsun</span>
    </label>
    <p class="text-xs text-slate-500">Kapali ise urun kartinda ve detayda kapida odeme butonu gosterilmez.</p>
</div>

<div class="mt-10 border-t border-slate-200 pt-8">
    <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-700">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500" @checked(old('is_active', $product?->is_active ?? true))>
        Vitrinde aktif
    </label>
</div>

@php
    $attrNames = old('attr_name');
    $attrVals = old('attr_value');
    if (is_array($attrNames) || is_array($attrVals)) {
        $names = is_array($attrNames) ? $attrNames : [];
        $vals = is_array($attrVals) ? $attrVals : [];
        $n = max(count($names), count($vals), 1);
        $attributeRows = [];
        for ($i = 0; $i < $n; $i++) {
            $attributeRows[] = ['name' => $names[$i] ?? '', 'value' => $vals[$i] ?? ''];
        }
    } elseif ($product && $product->relationLoaded('specAttributes') && $product->specAttributes->isNotEmpty()) {
        $attributeRows = $product->specAttributes->map(fn ($a) => ['name' => $a->name, 'value' => $a->value])->all();
    } else {
        $attributeRows = [['name' => '', 'value' => '']];
    }
@endphp

<div class="mt-8 rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" x-data="{
    rows: {{ json_encode(array_values($attributeRows)) }},
    add() { this.rows.push({ name: '', value: '' }) },
    remove(i) { if (this.rows.length > 1) this.rows.splice(i, 1) }
}">
    <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
        <div>
            <p class="text-sm font-bold text-slate-800">Teknik detaylar (tablo)</p>
            <p class="text-xs text-slate-500">Ad/deger satirlari; urun sayfasinda &quot;Teknik detaylar&quot; kutusunda listelenir (kategori, stok, ozel alanlar).</p>
        </div>
        <button type="button" x-on:click="add()" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-100">
            <i data-lucide="plus" class="h-3.5 w-3.5"></i> Satir ekle
        </button>
    </div>
    <div class="space-y-3">
        <template x-for="(row, index) in rows" :key="index">
            <div class="flex flex-col gap-2 rounded-xl border border-slate-100 bg-slate-50/50 p-3 sm:flex-row sm:items-end">
                <div class="min-w-0 flex-1">
                    <label class="mb-1 block text-xs font-semibold text-slate-600">Ozellik adi</label>
                    <input type="text" :name="'attr_name[' + index + ']'" x-model="row.name" class="w-full rounded-lg border-slate-200 text-sm" placeholder="Ornek: Malzeme">
                </div>
                <div class="min-w-0 flex-1">
                    <label class="mb-1 block text-xs font-semibold text-slate-600">Deger</label>
                    <input type="text" :name="'attr_value[' + index + ']'" x-model="row.value" class="w-full rounded-lg border-slate-200 text-sm" placeholder="Ornek: 925 ayar gumus">
                </div>
                <button type="button" x-on:click="remove(index)" class="shrink-0 rounded-lg border border-red-100 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100 sm:mb-0.5" x-show="rows.length > 1">Kaldir</button>
            </div>
        </template>
    </div>
</div>

<div class="mt-6">
    <label class="mb-1 block text-sm font-semibold text-slate-700">Yeni gorseller (coklu, max 2MB)</label>
    <input type="file" name="images[]" accept="image/*" multiple class="w-full rounded-xl border border-dashed border-slate-200 bg-slate-50/50 px-3 py-4 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-rose-600 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
    @error('images')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    @error('images.*')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
