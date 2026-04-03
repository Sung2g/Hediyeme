<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        if ($request->filled('website')) {
            return back()->with('error', 'Gonderim reddedildi.');
        }

        $rules = [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'body' => ['required', 'string', 'min:10', 'max:2000'],
        ];

        if (! $request->user()) {
            $rules['guest_name'] = ['required', 'string', 'max:100'];
            $rules['guest_email'] = ['required', 'email', 'max:255'];
        }

        $validated = $request->validate($rules);

        if ($request->user()) {
            if ($product->reviews()->where('user_id', $request->user()->id)->exists()) {
                return back()->with('error', 'Bu urun icin zaten bir degerlendirme yaptiniz.');
            }

            $product->reviews()->create([
                'user_id' => $request->user()->id,
                'guest_name' => null,
                'guest_email' => null,
                'rating' => $validated['rating'],
                'body' => $validated['body'],
                'is_approved' => true,
            ]);
        } else {
            if ($product->reviews()
                ->whereNull('user_id')
                ->where('guest_email', $validated['guest_email'])
                ->exists()) {
                return back()->with('error', 'Bu e-posta ile bu urune zaten yorum yaptiniz.');
            }

            $product->reviews()->create([
                'user_id' => null,
                'guest_name' => $validated['guest_name'],
                'guest_email' => $validated['guest_email'],
                'rating' => $validated['rating'],
                'body' => $validated['body'],
                'is_approved' => true,
            ]);
        }

        return back()->with('success', 'Degerlendirmeniz kaydedildi. Tesekkurler!');
    }
}
