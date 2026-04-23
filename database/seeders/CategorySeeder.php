<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'img' => 'categories/electronics.jpg'],
            ['name' => 'Fashion', 'img' => 'categories/fashion.jpg'],
            ['name' => 'Computers & Laptops', 'img' => 'categories/computers.jpg'],
            ['name' => 'Home & Furniture', 'img' => 'categories/home.jpg'],
            ['name' => 'Sports & Fitness', 'img' => 'categories/sports.jpg'],
        ];

        foreach ($categories as $index => $item) {
            Category::create([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'img' => $item['img'],
                'showcat' => $index < 3 ? 'Yes' : 'No', // show first 3
                'status' => 1,
            ]);
        }
    }
}