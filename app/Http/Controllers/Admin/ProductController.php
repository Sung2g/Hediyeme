<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::query()->with('category')->latest()->paginate(20),
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
        ]);

        Product::query()->create([
            ...$validated,
            'slug' => Str::slug($validated['name']).'-'.Str::random(4),
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

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
            'product' => $product,
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
        ]);

        $product->update([
            ...$validated,
            'slug' => Str::slug($validated['name']).'-'.Str::random(4),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Urun guncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Urun silindi.');
    }
}
