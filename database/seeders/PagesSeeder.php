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
            ['name' => 'Dashboard', 'url' => 'dashboard.index', 'icon' => 'bi-house', 'permission_id' => 1,  'order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'About Us', 'url' => 'aboutus.edit', 'icon' => 'bi-info-circle', 'permission_id' => 1,  'order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Users', 'url' => 'users.index', 'icon' => 'bi-people', 'permission_id' => 1,  'order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Brands', 'url' => 'brands.index', 'icon' => 'bi-tags', 'permission_id' => 1,  'order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Products', 'url' => 'products.index', 'icon' => 'bi-box', 'permission_id' => 1,  'order' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Subcategories', 'url' => 'subcategories.index', 'icon' => 'bi-diagram-3', 'permission_id' => 1,  'order' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Categories', 'url' => 'categories.index', 'icon' => 'bi-list', 'permission_id' => 1,  'order' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Orders', 'url' => 'orders.index', 'icon' => 'bi-cart', 'permission_id' => 1,  'order' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Customers', 'url' => 'customers.index', 'icon' => 'bi-person', 'permission_id' => 1,  'order' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Slideshow', 'url' => 'slideshow.index', 'icon' => 'bi-images', 'permission_id' => 1,  'order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Permission', 'url' => 'permissions.index', 'icon' => 'bi-images', 'permission_id' => 1,  'order' => 11, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('pages')->insert($pages);
    }
}
