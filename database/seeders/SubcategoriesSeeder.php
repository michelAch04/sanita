<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Faker\Factory as Faker;

class SubcategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $categories = Category::all();

        if ($categories->isEmpty()) {
            // No categories to assign subcategories to
            return;
        }

        $subcategories = [];
        $position = 1;
        $subcatCount = 50; // Total number of subcategories to create

        for ($i = 0; $i < $subcatCount; $i++) {
            $category = $categories->random(); // Pick a random category

            $subcategories[] = [
                'categories_id' => $category->id,
                'position'      => $position++,
                'name_en'       => $faker->words(2, true) . ' ' . strtoupper($faker->randomLetter),
                'name_ar'       => $faker->words(2, true) . ' ع',
                'name_ku'       => $faker->words(2, true) . ' ک',
                'extension'     => null,
                'hidden'        => $faker->boolean(10) ? 1 : 0,
                'cancelled'     => 0,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        }

        DB::table('subcategories')->insert($subcategories);
    }
}
