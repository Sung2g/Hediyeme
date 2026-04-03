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

<div>
    <label class="mb-1 block text-sm font-semibold text-slate-700">Aciklama</label>
    <textarea name="description" rows="5" class="w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('description', $product?->description) }}</textarea>
    @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
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

<label class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-700">
    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500" @checked(old('is_active', $product?->is_active ?? true))>
    Vitrinde aktif
</label>

<div>
    <label class="mb-1 block text-sm font-semibold text-slate-700">Yeni gorseller (coklu, max 2MB)</label>
    <input type="file" name="images[]" accept="image/*" multiple class="w-full rounded-xl border border-dashed border-slate-200 bg-slate-50/50 px-3 py-4 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-rose-600 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
    @error('images')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    @error('images.*')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
