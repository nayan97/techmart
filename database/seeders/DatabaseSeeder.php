<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\SubCategorySeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    $this->call([
        UserSeeder::class,
        CategorySeeder::class,
        SubCategorySeeder::class,
        BrandSeeder::class,
        ProductSeeder::class,
        ProductImageSeeder::class,
    ]);
    
    }
}
