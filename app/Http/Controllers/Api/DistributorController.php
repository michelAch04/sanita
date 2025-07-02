<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributorController extends Controller
{
    // Add or update stock for a distributor and item
    public function addStock(Request $request)
    {
        $validated = $request->validate([
            'distributor_id' => 'required|integer',
            'products' => 'required|array|min:1',
            'products.*.item_code' => 'required|string',
            'products.*.stock' => 'required|integer',
        ]);

        foreach ($validated['products'] as $productData) {
            $product = DB::table('products')->where('sku', $productData['item_code'])->first();

            if (!$product) {
                // Optionally skip or return error for missing product
                continue;
            }

            DB::table('distributor_stocks')->updateOrInsert(
                [
                    'distributor_id' => $validated['distributor_id'],
                    'product_id' => $product->id,
                ],
                [
                    'stock' => $productData['stock'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        return response()->json(['success' => true]);
    }

    // Assign a city to a distributor
    public function assignCity(Request $request)
    {
        $validated = $request->validate([
            'distributor_id' => 'required|integer',
            'cities' => 'required|array',
            'cities.*' => 'integer'
        ]);

        $skipped = [];
        $assigned = [];

        foreach ($validated['cities'] as $cityId) {
            // Check if this city is already assigned to another distributor
            $existing = DB::table('distributor_addresses')
                ->where('cities_id', $cityId)
                ->where('distributors_id', '!=', $validated['distributor_id'])
                ->exists();

            if ($existing) {
                $skipped[] = $cityId;
                continue;
            }

            DB::table('distributor_addresses')->updateOrInsert(
                [
                    'distributors_id' => $validated['distributor_id'],
                    'cities_id' => $cityId,
                ],
                [
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
            $assigned[] = $cityId;
        }

        return response()->json([
            'success' => count($assigned) > 0,
            'assigned' => $assigned,
            'skipped' => $skipped,
            'message' =>
                count($assigned) === 0
                    ? 'All selected cities are already assigned to other distributors.'
                    : (count($skipped) === 0
                        ? 'All cities assigned successfully.'
                        : 'Some cities were already assigned to other distributors and were skipped.')
        ]);
    }
}
