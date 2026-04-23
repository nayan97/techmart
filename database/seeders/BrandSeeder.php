<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Apple',
            'Samsung',
            'Sony',
            'Dell',
            'HP',
            'Asus',
            'Lenovo',
            'Microsoft',
            'Nike',
            'Adidas',
            'Puma',
            'Canon',
            'LG',
            'Panasonic',
            'Logitech',
        ];

        foreach ($brands as $name) {
            Brand::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => 1,
            ]);
        }
    }
}