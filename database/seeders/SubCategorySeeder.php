<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\SubCategory;
use App\Models\Category;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Electronics' => [
                'Mobile Phones',
                'Televisions',
                'Cameras'
            ],
            'Fashion' => [
                'Men Clothing',
                'Women Clothing',
                'Shoes'
            ],
            'Computers & Laptops' => [
                'Laptops',
                'Desktops',
                'Accessories'
            ],
            'Home & Furniture' => [
                'Furniture',
                'Kitchen',
                'Decor'
            ],
            'Sports & Fitness' => [
                'Gym Equipment',
                'Outdoor Sports',
                'Cycling'
            ],
        ];

        foreach ($data as $categoryName => $subs) {

            $category = Category::where('name', $categoryName)->first();

            if (!$category) continue;

            foreach ($subs as $index => $sub) {
                SubCategory::create([
                    'name' => $sub,
                    'slug' => Str::slug($sub),
                    'category_id' => $category->id,
                    'showcat' => $index == 0 ? 'Yes' : 'No', // first one visible
                    'status' => 1,
                ]);
            }
        }
    }
}