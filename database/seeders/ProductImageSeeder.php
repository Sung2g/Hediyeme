<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Product::query()->cursor() as $product) {
            ProductImage::query()->updateOrCreate(
                [
                    'product_id' => $product->id,
                    'path' => 'https://picsum.photos/seed/hediyeme-'.$product->id.'-a/800/800',
                ],
                [
                    'sort_order' => 0,
                    'is_primary' => true,
                ]
            );

            ProductImage::query()->updateOrCreate(
                [
                    'product_id' => $product->id,
                    'path' => 'https://picsum.photos/seed/hediyeme-'.$product->id.'-b/600/600',
                ],
                [
                    'sort_order' => 1,
                    'is_primary' => false,
                ]
            );
        }
    }
}
