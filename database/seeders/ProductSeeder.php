<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'title' => 'iPhone 14 Pro Max',
                'price' => 1450,
                'compare_price' => 1550,
            ],
            [
                'title' => 'Samsung Galaxy S23 Ultra',
                'price' => 1300,
                'compare_price' => 1400,
            ],
            [
                'title' => 'MacBook Air M2',
                'price' => 1200,
                'compare_price' => 1350,
            ],
            [
                'title' => 'Dell XPS 13',
                'price' => 1100,
                'compare_price' => 1250,
            ],
            [
                'title' => 'Sony WH-1000XM5 Headphones',
                'price' => 350,
                'compare_price' => 400,
            ],
            [
                'title' => 'Apple Watch Series 9',
                'price' => 500,
                'compare_price' => 550,
            ],
            [
                'title' => 'Logitech MX Master 3 Mouse',
                'price' => 120,
                'compare_price' => 150,
            ],
            [
                'title' => 'HP Pavilion Gaming Laptop',
                'price' => 900,
                'compare_price' => 1050,
            ],
            [
                'title' => 'Asus ROG Strix G15',
                'price' => 1400,
                'compare_price' => 1550,
            ],
            [
                'title' => 'Canon EOS M50 Camera',
                'price' => 700,
                'compare_price' => 850,
            ],
            [
                'title' => 'Nike Air Max Sneakers',
                'price' => 180,
                'compare_price' => 220,
            ],
            [
                'title' => 'Adidas Ultraboost Shoes',
                'price' => 200,
                'compare_price' => 240,
            ],
            [
                'title' => 'Wooden Office Desk',
                'price' => 300,
                'compare_price' => 380,
            ],
            [
                'title' => 'Ergonomic Office Chair',
                'price' => 250,
                'compare_price' => 320,
            ],
            [
                'title' => 'LED 4K Smart TV 55 Inch',
                'price' => 800,
                'compare_price' => 950,
            ],
        ];

        foreach ($products as $index => $item) {

            Product::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'description' => "Full description of {$item['title']}",
                'short_description' => "Short description of {$item['title']}",
                'price' => $item['price'],
                'compare_price' => $item['compare_price'],
                'category_id' => 1, // must exist
                'sub_category_id' => null,
                'brand_id' => 1, // must exist
                'is_featured' => $index % 2 == 0 ? 'yes' : 'No',
                'sku' => 'SKU-' . rand(10000,99999),
                'barcode' => rand(1000000000,9999999999),
                'track_qty' => 'Yes',
                'qty' => rand(5, 50),
                'status' => 1,
                'shipping_returns' => "7 days return policy",
                'related_products' => null,
            ]);
        }
    }
}