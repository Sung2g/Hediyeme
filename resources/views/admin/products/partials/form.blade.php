<div>
    <label class="mb-1 block text-sm font-medium">Kategori</label>
    <select name="category_id" class="w-full rounded-lg border-gray-300">
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $product?->category_id) == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium">Urun Adi</label>
    <input type="text" name="name" value="{{ old('name', $product?->name) }}" class="w-full rounded-lg border-gray-300">
    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium">Aciklama</label>
    <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300">{{ old('description', $product?->description) }}</textarea>
    @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<div class="grid gap-3 md:grid-cols-3">
    <div>
        <label class="mb-1 block text-sm font-medium">Fiyat</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product?->price) }}" class="w-full rounded-lg border-gray-300">
        @error('price')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Stok</label>
        <input type="number" name="stock" value="{{ old('stock', $product?->stock) }}" class="w-full rounded-lg border-gray-300">
        @error('stock')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Tip</label>
        <select name="type" class="w-full rounded-lg border-gray-300">
            <option value="physical" @selected(old('type', $product?->type) === 'physical')>Physical</option>
            <option value="digital" @selected(old('type', $product?->type) === 'digital')>Digital</option>
        </select>
        @error('type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<label class="flex items-center gap-2 text-sm">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product?->is_active ?? true))>
    Aktif
</label>
