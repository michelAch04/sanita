<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategoriesSeeder::class,
            SubcategoriesSeeder::class,
            BrandsSeeder::class,
            ProductsSeeder::class,
        ]);
    }
}

class SubcategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subcategories')->insert([
            ['id' => 1, 'name' => 'Subcategory 1', 'categories_id' => 1, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Subcategory 2', 'categories_id' => 1, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

class BrandsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('brands')->insert([
            ['id' => 1, 'name' => 'Brand 1', 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Brand 2', 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
