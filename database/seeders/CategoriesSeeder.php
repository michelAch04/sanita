<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'name' => 'Cleaning Supplies',
                'hidden' => 0,
                'extension' => 'jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Paper Products',
                'hidden' => 0,
                'extension' => 'png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Disposable Wear',
                'hidden' => 1,
                'extension' => 'jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
