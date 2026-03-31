<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::query()->latest()->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Category::query()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']).'-'.Str::random(4),
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori olusturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): RedirectResponse
    {
        return redirect()->route('admin.categories.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']).'-'.Str::random(4),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori guncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori silindi.');
    }
}
