<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['category' => 'Dijital Hizmetler', 'name' => 'E-Ticaret Kurulum Paketi', 'price' => 4500, 'stock' => 999, 'type' => 'digital'],
            ['category' => 'Taki ve Mucevher', 'name' => 'Zirkon Tasli Gumus Kolye', 'price' => 850, 'stock' => 25, 'type' => 'physical'],
            ['category' => 'Kisisel Bakim', 'name' => 'Bambu Dis Fircasi Seti', 'price' => 120, 'stock' => 80, 'type' => 'physical'],
            ['category' => 'Dini Urunler', 'name' => 'Oltu Tasi Tesbih', 'price' => 450, 'stock' => 30, 'type' => 'physical'],
            ['category' => 'Ev ve Yasam', 'name' => 'Kisisel Hediye Kutusu', 'price' => 399, 'stock' => 60, 'type' => 'physical'],
        ];

        foreach ($products as $item) {
            $category = Category::query()->where('name', $item['category'])->first();
            if (! $category) {
                continue;
            }

            Product::query()->updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'description' => $item['name'].' icin ornek urun aciklamasi.',
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'type' => $item['type'],
                    'is_active' => true,
                ]
            );
        }
    }
}
