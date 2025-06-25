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
        ]);
        //     $this->call(CategoriesSeeder::class);

        //     $this->call(BrandsSeeder::class);

        //     $this->call(SubcategoriesSeeder::class);

        //     $this->call(TaxesSeeder::class);

        //     $this->call(ProductsSeeder::class);

        // $this->call(PagesSeeder::class);

        // $this->call(UserSeeder::class);

        // $this->call(PermissionSeeder::class);
    }
}
