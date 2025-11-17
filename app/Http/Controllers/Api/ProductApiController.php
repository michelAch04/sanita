<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::All();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'extension' => 'nullable|string|max:10',
            'sku' => 'required|string|max:50',
            'subcategory_id' => 'required|integer|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'small_description' => 'nullable|string',
            'unit_price' => 'required|numeric',
            'shelf_price' => 'required|numeric',
            'threshold' => 'nullable|integer',
            'product_line_code' => 'nullable|string|max:50',
            'product_line_description' => 'nullable|string|max:255',
            'family_code' => 'nullable|string|max:50',
            'family_description' => 'nullable|string|max:255',
            'brand_id' => 'required|integer|exists:brands,id',
            'tax' => 'nullable|numeric',
            'available_quantity' => 'nullable|integer',
            'hidden' => 'nullable|boolean',
            'automatic_hide' => 'nullable|boolean',
            'cancelled' => 'nullable|boolean',
        ]);

        $product = Product::where('sku', $validated['sku'])->first();

        if ($product) {
            $product->update($validated);
            return response()->json([
                'message' => 'Product updated successfully.',
                'product' => $product
            ], 200);
        } else {
            $product = Product::create($validated);
            return response()->json([
                'message' => 'Product created successfully.',
                'product' => $product
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
