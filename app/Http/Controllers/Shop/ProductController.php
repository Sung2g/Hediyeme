<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\TurkeyGeoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
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
            'specAttributes' => fn ($query) => $query->orderBy('sort_order'),
        ]);

        $reviews = $product->approvedReviews()->with('user')->get();
        $reviewAverage = $reviews->avg('rating');
        $reviewCount = $reviews->count();

        $webUser = $request->user('web');
        $userHasReviewed = $webUser
            && $product->reviews()->where('user_id', $webUser->id)->exists();

        return view('shop.products.show', [
            'product' => $product,
            'reviews' => $reviews,
            'reviewAverage' => $reviewAverage !== null ? round((float) $reviewAverage, 1) : null,
            'reviewCount' => $reviewCount,
            'userHasReviewed' => $userHasReviewed,
        ]);
    }

    public function addAndCheckoutCod(
        Request $request,
        Product $product,
        CartService $cart,
        OrderService $orderService,
        TurkeyGeoService $geo,
    ): RedirectResponse {
        abort_unless($product->is_active && $product->cod_enabled, 404);

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:20'],
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'shipping_city' => ['required', 'string', 'max:120', Rule::in($geo->provinceNames())],
            'shipping_district' => ['required', 'string', 'max:120'],
            'shipping_address' => ['required', 'string', 'max:2000'],
            'seller_note' => ['nullable', 'string', 'max:2000'],
        ]);

        if (! $geo->isValidDistrictForCity($validated['shipping_city'], $validated['shipping_district'])) {
            throw ValidationException::withMessages([
                'shipping_district' => ['Secilen ilce bu ile ait degil.'],
            ]);
        }

        $cart->add($product, $validated['quantity'] ?? 1);
        $shippingFee = (float) config('shop.cod_shipping_fee', 49.9);

        $order = $orderService->createFromCart(
            $cart->items()->all(),
            [
                'name' => trim($validated['first_name'].' '.$validated['last_name']),
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'],
                'shipping_fee' => $shippingFee,
                'shipping_city' => $validated['shipping_city'],
                'shipping_district' => $validated['shipping_district'],
                'shipping_address' => $validated['shipping_address'],
                'seller_note' => $validated['seller_note'] ?? null,
            ],
            'cash_on_delivery',
            $request->user('web')
        );

        $cart->clear();
        $request->session()->forget(['checkout_payment_method', 'checkout_guest_prefill']);

        return redirect()
            ->route('shop.checkout.success', $order)
            ->with('success', 'Siparisiniz olusturuldu.');
    }
}
