<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call CategoriesSeeder first
        $this->call(CategoriesSeeder::class);

        // // Then BrandsSeeder
        $this->call(BrandsSeeder::class);

        // Then SubcategoriesSeeder (which needs categories)
        $this->call(SubcategoriesSeeder::class);

        // // Finally, ProductsSeeder (which needs subcategories and brands)
        $this->call(ProductsSeeder::class);

        $this->call(PermissionSeeder::class);
        
        $this->call(PagesSeeder::class);

        $this->call(UserSeeder::class);

    }
}
