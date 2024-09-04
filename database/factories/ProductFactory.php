<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->name();
        $slug =Str::slug($title);
        $subCategories = [3, 4, 6, 7];
        $subCatRandkey= array_rand($subCategories);

        $brands = [1, 2, 3, 5, 6];
        $brandRandkey = array_rand($brands);

      
        return [
            'title' => $title,
            'slug' => $slug,
            'category_id' => 2,
            'sub_category_id' => $subCategories[$subCatRandkey],
            'brand_id' => $brands[$brandRandkey],
            'price' => rand(10,1000),
            'sku' => rand(100,1000),
            'track_qty' => 'Yes',
            'qty' => rand(10,100),
            'is_featured' => 'Yes',
            'status' => 1

        ];
    }
}
