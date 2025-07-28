<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            GovernorateSeeder::class,
            DistrictSeeder::class,
            CitySeeder::class,
            // CategoriesSeeder::class,
            // BrandsSeeder::class,
            // SubcategoriesSeeder::class,
            // TaxesSeeder::class,
            // ProductsSeeder::class,
            // PricesSeeder::class,
            // PagesSeeder::class,
            // UserSeeder::class,
            // PermissionSeeder::class,
            // StatusesTableSeeder::class,
        ]);
    }
}
