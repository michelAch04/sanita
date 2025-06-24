<?php

use App\Http\Controllers\Api\BrandApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\SubcategoryApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\Api\GovernorateController;
use App\Http\Controllers\Api\DistrictController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api.key')->group(function () {
    Route::apiResource('products', ProductApiController::class);
    Route::apiResource('categories', CategoryApiController::class);
    Route::apiResource('subcategories', SubcategoryApiController::class);
    Route::apiResource('brands', BrandApiController::class);
});



Route::get('/recalculate-shelf-prices', function () {
    // Step 1: Set tax_id = 1 for all products
    Product::query()->update(['tax_id' => 1]);

    // Step 2: Re-fetch products with tax relationship (now all have tax_id = 1)
    $products = Product::with('tax')->get();

    foreach ($products as $product) {
        $taxRate = $product->tax->rate ?? 0;
        $product->shelf_price = $product->unit_price + ($product->unit_price * $taxRate / 100);
        $product->old_price = null; // reset old_price by default
        $product->save();
    }

    // Step 3: Randomly select 25 products and set old_price
    $randomProducts = $products->random(min(25, $products->count()));

    foreach ($randomProducts as $product) {
        $increasePercentage = rand(10, 30); // 10% - 30% higher
        $product->old_price = round($product->shelf_price * (1 + $increasePercentage / 100), 2);
        $product->save();
    }

    return 'All products updated with tax_id = 1, shelf prices recalculated, and old_price added for 25 random products.';
});
