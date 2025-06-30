<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ListPrice;
use App\Models\Brand;
use App\Models\Subcategory;
use App\Models\Tax;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $brand = Brand::first() ?? Brand::factory()->create();
        $subcategory = Subcategory::first() ?? Subcategory::factory()->create();
        $tax = Tax::first();

        for ($i = 1; $i <= 24; $i++) {
            $product = Product::create([
                'sku' => 'SKU' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name_en' => "Product $i",
                'name_ar' => "منتج $i",
                'name_ku' => "بەرھەم $i",
                'small_description_en' => "Small description for Product $i",
                'small_description_ar' => "وصف صغير للمنتج $i",
                'small_description_ku' => "وەسفی کەمەکە بۆ بەرھەم $i",
                'ea_ca' => rand(1, 10),
                'ea_pl' => rand(1, 10),
                'subcategories_id' => $subcategory->id,
                'brands_id' => $brand->id,
                'tax_id' => $tax?->id,
                'extension' => 'png',
                'cancelled' => 0,
            ]);

            // B2B Price
            ListPrice::create([
                'products_id' => $product->id,
                'type' => 'b2b',
                'unit_price' => $unitPriceB2B = rand(50, 100),
                'shelf_price' => $this->calcShelf($unitPriceB2B, $tax?->rate),
                'old_price' => $unitPriceB2B + rand(5, 20),
                'min_quantity_to_order' => 1,
                'max_quantity_to_order' => 100,
                'trade_loader' => rand(1, 5),
                'trade_loader_quantity' => rand(10, 50),
                'UOM' => 'CTN',
                'hidden' => false,
                'automatic_hide' => false,
            ]);

            // B2C Price
            ListPrice::create([
                'products_id' => $product->id,
                'type' => 'b2c',
                'unit_price' => $unitPriceB2C = rand(60, 120),
                'shelf_price' => $this->calcShelf($unitPriceB2C, $tax?->rate),
                'old_price' => $unitPriceB2C + rand(5, 15),
                'min_quantity_to_order' => 1,
                'max_quantity_to_order' => 10,
                'trade_loader' => rand(0, 3),
                'trade_loader_quantity' => rand(1, 10),
                'UOM' => 'PCS',
                'hidden' => false,
                'automatic_hide' => false,
            ]);
        }
    }

    private function calcShelf($unitPrice, $taxRate)
    {
        if ($taxRate) {
            return round($unitPrice * (1 + $taxRate / 100), 2);
        }
        return $unitPrice;
    }
}
