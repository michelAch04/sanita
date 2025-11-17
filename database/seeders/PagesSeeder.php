<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            ['name' => 'Dashboard', 'url' => 'dashboard.index', 'icon' => 'bi-house',   'order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'About Us', 'url' => 'aboutus.edit', 'icon' => 'bi-info-circle',   'order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Users', 'url' => 'users.index', 'icon' => 'bi-people',   'order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Brands', 'url' => 'brands.index', 'icon' => 'bi-tags',   'order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Products', 'url' => 'products.index', 'icon' => 'bi-box',   'order' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Subcategories', 'url' => 'subcategories.index', 'icon' => 'bi-diagram-3',   'order' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Categories', 'url' => 'categories.index', 'icon' => 'bi-list',   'order' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Orders', 'url' => 'orders.index', 'icon' => 'bi-cart',   'order' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Customers', 'url' => 'customers.index', 'icon' => 'bi-person',   'order' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Slideshow', 'url' => 'slideshow.index', 'icon' => 'bi-images',   'order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Carts', 'url' => 'cart.index', 'icon' => 'bi-cart4',   'order' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Taxes', 'url' => 'tax.index', 'icon' => 'bi-percent',   'order' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Distributors', 'url' => 'distributor.index', 'icon' => 'bi-truck',   'order' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Promo Codes', 'url' => 'promocodes.index', 'icon' => 'bi-gift', 'order' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'POS Locations', 'url' => 'pos_locations.index', 'icon' => 'bi-geo-alt',  'order' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Permissions', 'url' => 'permissions.index', 'icon' => 'bi-shield-lock',  'order' => 16, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('pages')->insert($pages);
    }
}
