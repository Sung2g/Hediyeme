<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductReviewController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->string('durum')->toString();
        if (! in_array($filter, ['tumu', 'bekleyen', 'onayli'], true)) {
            $filter = 'tumu';
        }

        $reviews = ProductReview::query()
            ->with(['product', 'user'])
            ->when($filter === 'bekleyen', fn ($q) => $q->where('is_approved', false))
            ->when($filter === 'onayli', fn ($q) => $q->where('is_approved', true))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            'filter' => $filter,
        ]);
    }

    public function update(Request $request, ProductReview $review): RedirectResponse
    {
        $validated = $request->validate([
            'is_approved' => ['required', 'in:0,1'],
        ]);

        $review->update(['is_approved' => (bool) (int) $validated['is_approved']]);

        $msg = $validated['is_approved'] ? 'Yorum onaylandi.' : 'Yorum onayi kaldirildi.';

        return back()->with('success', $msg);
    }

    public function destroy(ProductReview $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', 'Yorum silindi.');
    }
}
