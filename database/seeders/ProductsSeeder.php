<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'extension' => 'jpg',
                'sku' => 'SKU001',
                'subcategory_id' => 1,
                'name' => 'Sample Product 1',
                'description' => 'A sample product 1.',
                'unit_price' => 10.00,
                'shelf_price' => 12.00,
                'threshold' => 5,
                'product_line_code' => 'PLC001',
                'product_line_description' => 'Sample Line 1',
                'family_code' => 'FAM001',
                'family_description' => 'Sample Family 1',
                'brand_id' => 1,
                'tax' => 5,
                'available_quantity' => 100,
                'hidden' => 0,
                'automatic_hide' => 0,
                'cancelled' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'extension' => 'png',
                'sku' => 'SKU002',
                'subcategory_id' => 2,
                'name' => 'Sample Product 2',
                'description' => 'A sample product 2.',
                'unit_price' => 20.00,
                'shelf_price' => 22.00,
                'threshold' => 10,
                'product_line_code' => 'PLC002',
                'product_line_description' => 'Sample Line 2',
                'family_code' => 'FAM002',
                'family_description' => 'Sample Family 2',
                'brand_id' => 2,
                'tax' => 10,
                'available_quantity' => 200,
                'hidden' => 0,
                'automatic_hide' => 0,
                'cancelled' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'extension' => 'jpeg',
                'sku' => 'SKU003',
                'subcategory_id' => 1,
                'name' => 'Sample Product 3',
                'description' => 'A sample product 3.',
                'unit_price' => 15.50,
                'shelf_price' => 18.00,
                'threshold' => 8,
                'product_line_code' => 'PLC003',
                'product_line_description' => 'Sample Line 3',
                'family_code' => 'FAM003',
                'family_description' => 'Sample Family 3',
                'brand_id' => 1,
                'tax' => 8,
                'available_quantity' => 150,
                'hidden' => 1,
                'automatic_hide' => 1,
                'cancelled' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
