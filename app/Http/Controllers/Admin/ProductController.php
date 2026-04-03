<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with('category')
            ->withCount('reviews')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%'.$request->string('q')->trim()->toString().'%';
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', $term)
                        ->orWhere('slug', 'like', $term);
                });
            })
            ->when($request->boolean('dusuk_stok'), function ($query) {
                $query->where('stock', '>', 0)->where('stock', '<=', 5);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => Category::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'type' => ['required', 'in:physical,digital'],
            'is_active' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
        ]);

        $product = Product::query()->create([
            ...collect($validated)->except(['images', 'is_active'])->all(),
            'slug' => Str::slug($validated['name']).'-'.Str::random(4),
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        $this->storeUploadedImages($product, $request);

        return redirect()->route('admin.products.index')->with('success', 'Urun olusturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): RedirectResponse
    {
        return redirect()->route('admin.products.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product->load(['images' => fn ($q) => $q->orderBy('sort_order')]),
            'categories' => Category::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'type' => ['required', 'in:physical,digital'],
            'is_active' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
        ]);

        $product->update([
            ...collect($validated)->except(['images', 'is_active'])->all(),
            'slug' => Str::slug($validated['name']).'-'.Str::random(4),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        $this->storeUploadedImages($product, $request);

        return redirect()->route('admin.products.index')->with('success', 'Urun guncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        foreach ($product->images as $image) {
            if (! Str::startsWith($image->path, ['http://', 'https://'])) {
                Storage::disk('public')->delete($image->path);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Urun silindi.');
    }

    public function destroyImage(Product $product, ProductImage $productImage): RedirectResponse
    {
        abort_unless($productImage->product_id === $product->id, 404);

        if (! Str::startsWith($productImage->path, ['http://', 'https://'])) {
            Storage::disk('public')->delete($productImage->path);
        }

        $wasPrimary = $productImage->is_primary;
        $productImage->delete();

        if ($wasPrimary) {
            $next = $product->images()->orderBy('sort_order')->first();
            if ($next) {
                $next->update(['is_primary' => true]);
            }
        }

        return back()->with('success', 'Gorsel silindi.');
    }

    private function storeUploadedImages(Product $product, Request $request): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $files = $request->file('images');
        $maxOrder = (int) $product->images()->max('sort_order');
        $hasPrimary = $product->images()->where('is_primary', true)->exists();

        foreach ($files as $idx => $file) {
            if (! $file?->isValid()) {
                continue;
            }

            $path = $file->store('products/'.$product->id, 'public');
            $setPrimary = ! $hasPrimary && $idx === 0;

            $product->images()->create([
                'path' => $path,
                'sort_order' => $maxOrder + $idx + 1,
                'is_primary' => $setPrimary,
            ]);

            if ($setPrimary) {
                $hasPrimary = true;
            }
        }
    }
}
