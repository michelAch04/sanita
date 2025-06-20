<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Household Care: Cleaning Solutions
        DB::table('products')->insert([
            ['sku' => 'P0001', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Sanita My Home Floor Detergent', 'unit_price' => 3.50, 'available_quantity' => 100, 'subcategories_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0002', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Sanita My Home Glass Cleaner', 'unit_price' => 2.80, 'available_quantity' => 80, 'subcategories_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0003', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Dreams Facial Tissue Box', 'unit_price' => 1.50, 'available_quantity' => 300, 'subcategories_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0004', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Sanita My Home Surface Wipes', 'unit_price' => 3.00, 'available_quantity' => 120, 'subcategories_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0005', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Sanita My Home Disinfectant Spray', 'unit_price' => 4.00, 'available_quantity' => 150, 'subcategories_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Household Care: Laundry Detergents
        DB::table('products')->insert([
            ['sku' => 'P0006', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Woolite Laundry Detergent', 'unit_price' => 5.00, 'available_quantity' => 200, 'subcategories_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0007', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Tide Powder Detergent', 'unit_price' => 4.50, 'available_quantity' => 150, 'subcategories_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0008', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Ariel Liquid Detergent', 'unit_price' => 6.00, 'available_quantity' => 100, 'subcategories_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0009', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Persil ProClean Detergent', 'unit_price' => 5.50, 'available_quantity' => 120, 'subcategories_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0010', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Surf Excel Powder Detergent', 'unit_price' => 4.00, 'available_quantity' => 180, 'subcategories_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Household Care: Air Fresheners
        DB::table('products')->insert([
            ['sku' => 'P0011', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Febreze Air Freshener', 'unit_price' => 3.50, 'available_quantity' => 200, 'subcategories_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0012', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Air Wick Essential Oils', 'unit_price' => 4.00, 'available_quantity' => 180, 'subcategories_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0013', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Glade Room Spray', 'unit_price' => 2.80, 'available_quantity' => 150, 'subcategories_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0014', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Lysol Air Freshener Spray', 'unit_price' => 3.20, 'available_quantity' => 130, 'subcategories_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0015', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Renuzit Gel Air Freshener', 'unit_price' => 2.50, 'available_quantity' => 220, 'subcategories_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Household Care: Trash Bags
        DB::table('products')->insert([
            ['sku' => 'P0016', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Hefty Strong Trash Bags', 'unit_price' => 5.00, 'available_quantity' => 250, 'subcategories_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0017', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Glad OdorShield Trash Bags', 'unit_price' => 4.50, 'available_quantity' => 230, 'subcategories_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0018', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Glad ForceFlex Plus Trash Bags', 'unit_price' => 5.50, 'available_quantity' => 200, 'subcategories_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0019', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Kirkland Signature Trash Bags', 'unit_price' => 4.80, 'available_quantity' => 180, 'subcategories_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0020', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Simplehuman Custom Fit Trash Bags', 'unit_price' => 6.00, 'available_quantity' => 160, 'subcategories_id' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Household Care: Dishwashing Supplies
        DB::table('products')->insert([
            ['sku' => 'P0021', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Dawn Ultra Dish Soap', 'unit_price' => 3.20, 'available_quantity' => 280, 'subcategories_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0022', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Finish Dishwasher Detergent', 'unit_price' => 5.00, 'available_quantity' => 220, 'subcategories_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0023', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Palmolive Dish Soap', 'unit_price' => 2.80, 'available_quantity' => 200, 'subcategories_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0024', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Cascade Platinum Dishwasher Pods', 'unit_price' => 7.50, 'available_quantity' => 150, 'subcategories_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0025', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Seventh Generation Dish Liquid', 'unit_price' => 4.00, 'available_quantity' => 170, 'subcategories_id' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Personal Care: Hair Care
        DB::table('products')->insert([
            ['sku' => 'P0026', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Shampoo X', 'unit_price' => 5.50, 'available_quantity' => 100, 'subcategories_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0027', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Conditioner Y', 'unit_price' => 6.00, 'available_quantity' => 80, 'subcategories_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0028', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Hair Oil Z', 'unit_price' => 7.00, 'available_quantity' => 60, 'subcategories_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0029', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Hair Mask W', 'unit_price' => 8.00, 'available_quantity' => 90, 'subcategories_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0030', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Hair Growth Serum V', 'unit_price' => 9.00, 'available_quantity' => 70, 'subcategories_id' => 6, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Personal Care: Skin Care
        DB::table('products')->insert([
            ['sku' => 'P0031', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Moisturizer A', 'unit_price' => 12.00, 'available_quantity' => 150, 'subcategories_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0032', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Facial Cleanser B', 'unit_price' => 10.50, 'available_quantity' => 100, 'subcategories_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0033', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Sunscreen C', 'unit_price' => 14.00, 'available_quantity' => 130, 'subcategories_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0034', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Anti-aging Serum D', 'unit_price' => 20.00, 'available_quantity' => 90, 'subcategories_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0035', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Vitamin C Serum E', 'unit_price' => 18.00, 'available_quantity' => 110, 'subcategories_id' => 7, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Personal Care: Oral Care
        DB::table('products')->insert([
            ['sku' => 'P0036', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Colgate Toothpaste', 'unit_price' => 3.00, 'available_quantity' => 200, 'subcategories_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0037', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Oral-B Toothbrush', 'unit_price' => 2.50, 'available_quantity' => 180, 'subcategories_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0038', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Listerine Mouthwash', 'unit_price' => 4.00, 'available_quantity' => 150, 'subcategories_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0039', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Sensodyne Toothpaste', 'unit_price' => 3.80, 'available_quantity' => 130, 'subcategories_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0040', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'TePe Interdental Brushes', 'unit_price' => 5.00, 'available_quantity' => 90, 'subcategories_id' => 8, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Baby Care: Diapers
        DB::table('products')->insert([
            ['sku' => 'P0041', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Pampers Premium Care Diapers', 'unit_price' => 20.00, 'available_quantity' => 100, 'subcategories_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0042', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Huggies Ultra Comfort Diapers', 'unit_price' => 18.50, 'available_quantity' => 110, 'subcategories_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0043', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Bambo Nature Diapers', 'unit_price' => 22.00, 'available_quantity' => 80, 'subcategories_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0044', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Luvs Triple Leakguards Diapers', 'unit_price' => 17.00, 'available_quantity' => 90, 'subcategories_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0045', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Seventh Generation Diapers', 'unit_price' => 21.00, 'available_quantity' => 95, 'subcategories_id' => 9, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Baby Care: Baby Wipes
        DB::table('products')->insert([
            ['sku' => 'P0046', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'WaterWipes Baby Wipes', 'unit_price' => 4.50, 'available_quantity' => 200, 'subcategories_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0047', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Huggies Natural Care Wipes', 'unit_price' => 3.80, 'available_quantity' => 220, 'subcategories_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0048', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Pampers Sensitive Wipes', 'unit_price' => 4.00, 'available_quantity' => 210, 'subcategories_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0049', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Honest Baby Wipes', 'unit_price' => 5.00, 'available_quantity' => 180, 'subcategories_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['sku' => 'P0050', 'brands_id' => 1, 'name_ar' => 'سانيتا منظف الأرضيات', 'name_ku' => 'سانیتا پاككەرەوەی زەوی', 'name_en' => 'Mama Bear Baby Wipes', 'unit_price' => 3.60, 'available_quantity' => 230, 'subcategories_id' => 10, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
