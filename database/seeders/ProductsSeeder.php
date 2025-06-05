<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'extension' => 'jpg',
                'sku' => 'SSU001',
                'subcategories_id' => 1, // e.g., Paper Towels
                'name' => 'Sanita Serv-U Maxi Roll 350m',
                'description' => '1-ply embossed white paper towel roll, 350 meters.',
                'unit_price' => 3.50,
                'shelf_price' => 4.00,
                'threshold' => 10,
                'product_line_code' => 'PT001',
                'product_line_description' => 'Paper Towels',
                'family_code' => 'FAM001',
                'family_description' => 'Home Care',
                'brands_id' => 1, // e.g., Sanita Serv-U
                'tax' => 5,
                'available_quantity' => 500,
                'hidden' => 0,
                'automatic_hide' => 0,
                'cancelled' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'extension' => 'jpg',
                'sku' => 'SSU002',
                'subcategories_id' => 2, // e.g., Sanitizers
                'name' => 'Sanita Serv-U Floor Mopping Sanitizer 5L',
                'description' => '5-liter blue floor mopping sanitizer for effective cleaning.',
                'unit_price' => 15.00,
                'shelf_price' => 17.00,
                'threshold' => 5,
                'product_line_code' => 'CL001',
                'product_line_description' => 'Cleaning Products',
                'family_code' => 'FAM002',
                'family_description' => 'Professional Hygiene',
                'brands_id' => 1,
                'tax' => 10,
                'available_quantity' => 200,
                'hidden' => 0,
                'automatic_hide' => 0,
                'cancelled' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'extension' => 'jpg',
                'sku' => 'SSU003',
                'subcategories_id' => 3, // e.g., Gloves
                'name' => 'Sanita Serv-U Disposable Vinyl Gloves - Medium',
                'description' => 'Box of 100 medium-sized blue vinyl disposable gloves.',
                'unit_price' => 8.00,
                'shelf_price' => 9.50,
                'threshold' => 20,
                'product_line_code' => 'GL001',
                'product_line_description' => 'Gloves',
                'family_code' => 'FAM003',
                'family_description' => 'Personal Protection',
                'brands_id' => 1,
                'tax' => 5,
                'available_quantity' => 300,
                'hidden' => 0,
                'automatic_hide' => 0,
                'cancelled' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'extension' => 'jpg',
                'sku' => 'SSU004',
                'subcategories_id' => 4, // e.g., Napkins
                'name' => 'Sanita Serv-U 150 Sheets Brown Interfold Towel Tissue',
                'description' => '150-sheet pack of 2-ply brown interfold towel tissues made from recycled materials.',
                'unit_price' => 2.00,
                'shelf_price' => 2.50,
                'threshold' => 15,
                'product_line_code' => 'NT001',
                'product_line_description' => 'Napkins & Tissues',
                'family_code' => 'FAM004',
                'family_description' => 'Home Essentials',
                'brands_id' => 1,
                'tax' => 5,
                'available_quantity' => 400,
                'hidden' => 0,
                'automatic_hide' => 0,
                'cancelled' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
