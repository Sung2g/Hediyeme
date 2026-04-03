<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $sort = $request->string('sort')->toString();
        if (! in_array($sort, ['newest', 'price_asc', 'price_desc'], true)) {
            $sort = 'newest';
        }

        $qRaw = $request->string('q')->trim()->toString();
        $hasSearchQuery = $qRaw !== '';
        $searchTooShort = $hasSearchQuery && mb_strlen($qRaw) < 3;

        $products = Product::query()
            ->with(['category', 'images', 'latestApprovedReview.user'])
            ->where('is_active', true)
            ->when(
                $request->filled('category'),
                fn ($query) => $query->whereHas(
                    'category',
                    fn ($categoryQuery) => $categoryQuery->where('slug', $request->string('category'))
                )
            )
            ->when($searchTooShort, fn ($query) => $query->whereRaw('0 = 1'))
            ->when($hasSearchQuery && ! $searchTooShort, function ($query) use ($qRaw) {
                $term = '%'.$qRaw.'%';
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', $term)
                        ->orWhere('description', 'like', $term)
                        ->orWhereHas('category', fn ($cq) => $cq->where('name', 'like', $term));
                });
            })
            ->withAvg([
                'reviews as reviews_avg_rating' => fn ($q) => $q->where('is_approved', true),
            ], 'rating')
            ->withCount([
                'reviews as reviews_count' => fn ($q) => $q->where('is_approved', true),
            ])
            ->when($sort === 'price_asc', fn ($q) => $q->orderBy('price'))
            ->when($sort === 'price_desc', fn ($q) => $q->orderByDesc('price'))
            ->when($sort === 'newest', fn ($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        return view('shop.products.index', [
            'products' => $products,
            'sortBy' => $sort,
            'searchTooShort' => $searchTooShort,
        ]);
    }

    public function searchSuggestions(Request $request): JsonResponse
    {
        $q = mb_substr($request->string('q')->trim()->toString(), 0, 120);

        if (mb_strlen($q) < 3) {
            return response()->json([
                'query' => $q,
                'products' => [],
                'all_results_url' => route('shop.products.index', array_filter(['q' => $q])),
                'state' => 'too_short',
            ]);
        }

        $term = '%'.$q.'%';

        $products = Product::query()
            ->with(['category', 'images' => fn ($iq) => $iq->orderBy('sort_order')])
            ->where('is_active', true)
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhereHas('category', fn ($cq) => $cq->where('name', 'like', $term));
            })
            ->latest()
            ->limit(10)
            ->get();

        return response()->json([
            'query' => $q,
            'products' => $products->map(fn (Product $p) => [
                'name' => $p->name,
                'slug' => $p->slug,
                'url' => route('shop.products.show', $p->slug),
                'price_label' => number_format((float) $p->price, 2).' TL',
                'category' => $p->category?->name,
                'thumb' => $p->primaryImage()?->url(),
            ])->values(),
            'all_results_url' => route('shop.products.index', array_filter(['q' => $q])),
            'state' => $products->isEmpty() ? 'empty' : 'ok',
        ]);
    }

    public function show(Request $request, Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load([
            'category',
            'images' => fn ($query) => $query->orderBy('sort_order'),
        ]);

        $reviews = $product->approvedReviews()->with('user')->get();
        $reviewAverage = $reviews->avg('rating');
        $reviewCount = $reviews->count();

        $userHasReviewed = $request->user()
            && $product->reviews()->where('user_id', $request->user()->id)->exists();

        return view('shop.products.show', [
            'product' => $product,
            'reviews' => $reviews,
            'reviewAverage' => $reviewAverage !== null ? round((float) $reviewAverage, 1) : null,
            'reviewCount' => $reviewCount,
            'userHasReviewed' => $userHasReviewed,
        ]);
    }

    public function addAndCheckoutCod(Request $request, Product $product, CartService $cart): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:20'],
        ]);

        $cart->add($product, $validated['quantity'] ?? 1);
        $request->session()->put('checkout_payment_method', 'cash_on_delivery');

        return redirect()
            ->route('shop.checkout.index')
            ->with('success', 'Urun sepete eklendi. Kapida odeme secili.');
    }
}
