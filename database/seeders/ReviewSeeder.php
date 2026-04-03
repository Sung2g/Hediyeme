<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $buyers = User::query()
            ->where('is_admin', false)
            ->orderBy('id')
            ->take(3)
            ->get();

        if ($buyers->count() < 2) {
            $buyers = $buyers->merge(
                User::factory()->count(3 - $buyers->count())->create()
            );
        }

        $products = Product::query()->orderBy('id')->take(3)->get();

        $samples = [
            ['rating' => 5, 'body' => 'Urun bekledigimden guzel geldi, paketleme ozenliydi. Tesekkurler!'],
            ['rating' => 4, 'body' => 'Fiyat performans iyi. Kargo bir gun gecikti ama genel olarak memnunum.'],
            ['rating' => 5, 'body' => 'Hediye olarak aldim, cok begenildi. Kesinlikle tavsiye ederim.'],
        ];

        foreach ($products as $index => $product) {
            $user = $buyers[$index % $buyers->count()];
            $text = $samples[$index % count($samples)];

            ProductReview::query()->updateOrCreate(
                [
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                ],
                [
                    'rating' => $text['rating'],
                    'body' => $text['body'],
                    'is_approved' => true,
                ]
            );
        }
    }
}
