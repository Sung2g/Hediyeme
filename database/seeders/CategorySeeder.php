<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Dijital Hizmetler',
            'Taki ve Mucevher',
            'Kisisel Bakim',
            'Dini Urunler',
            'Ev ve Yasam',
        ];

        foreach ($names as $name) {
            Category::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'is_active' => true]
            );
        }
    }
}
