<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ListPrice;

class PricesSeeder extends Seeder
{
    protected $uoms = ['EA', 'CA', 'PL'];

    public function calcShelf(float $unitPrice, ?float $taxRate): float
    {
        if (!$taxRate) return $unitPrice;
        return round($unitPrice * (1 + $taxRate / 100), 2);
    }

    public function run(): void
    {
        $taxRate = 15; // example tax rate

        $products = Product::all();

        foreach ($products as $product) {
            foreach (['b2b', 'b2c'] as $type) {
                foreach ($this->uoms as $uom) {
                    $unitPrice = rand(40, 120);

                    ListPrice::updateOrCreate(
                        [
                            'products_id' => $product->id,
                            'type' => $type,
                            'UOM' => $uom,
                        ],
                        [
                            'unit_price' => $unitPrice,
                            'shelf_price' => $this->calcShelf($unitPrice, $taxRate),
                            'old_price' => $unitPrice + rand(5, 20),
                            'min_quantity_to_order' => rand(1, 5),
                            'max_quantity_to_order' => rand(10, 50),
                            'trade_loader' => rand(0, 5),
                            'trade_loader_quantity' => rand(1, 20),
                            'hidden' => false,
                            'automatic_hide' => false,
                        ]
                    );
                }
            }
        }
    }
}
