<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subcategories')->insert([
            [
                'name' => 'Subcategory 1',
                'categories_id' => 1,
                'hidden' => 0,
                'cancelled' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more subcategories as needed
        ]);
    }
}
