<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {

        $this->createRandomCategories(10);
    }

    public function createRandomCategories($count = 10)
    {
        $faker = Faker::create();
        $categories = [];

        for ($i = 0; $i < $count; $i++) {
            $categories[] = [
                'position'    => $i + 1,
                'name_en'     => $faker->words(2, true) . ' ' . Str::random(3),
                'name_ar'     => $faker->words(2, true) . ' ع',
                'name_ku'     => $faker->words(2, true) . ' ک',
                'extension'   => null,
                'hidden'      => $faker->boolean(10) ? 1 : 0, // 10% hidden
                'cancelled'   => 0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        DB::table('categories')->insert($categories);
    }
}
