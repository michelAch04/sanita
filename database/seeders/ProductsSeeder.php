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

        $uoms = ['EA', 'CA', 'PL'];

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

            foreach (['b2b', 'b2c'] as $type) {
                foreach ($uoms as $uom) {
                    $unitPrice = rand(40, 120);
                    ListPrice::create([
                        'products_id' => $product->id,
                        'type' => $type,
                        'unit_price' => $unitPrice,
                        'shelf_price' => $this->calcShelf($unitPrice, $tax?->rate),
                        'old_price' => $unitPrice + rand(5, 20),
                        'min_quantity_to_order' => rand(1, 5),
                        'max_quantity_to_order' => rand(10, 50),
                        'trade_loader' => rand(0, 5),
                        'trade_loader_quantity' => rand(1, 20),
                        'UOM' => $uom,
                        'hidden' => false,
                        'automatic_hide' => false,
                    ]);
                }
            }
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
