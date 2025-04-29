<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('cancelled', 0)->get();
        return view('cms.products.index', compact('products'));
    }

    public function create()
    {
        return view('cms.products.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'hidden' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Create the product
            $product = Product::create($request->only(['name', 'description', 'price', 'quantity', 'hidden']));

            // Handle the image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension(); // Get the file extension
                $imageName = $product->id . '.' . $extension; // Rename the image to the product ID
                $image->storeAs('products', $imageName, 'public'); // Save the image in 'storage/app/public/products'

                // Update the product with the image name and extension
                $product->update([
                    'extension' => $extension,
                ]);
            }

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('products.create')->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        return view('cms.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        try {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hidden' => 'required|boolean',
        ]);

      
            $product->update($request->only(['name', 'description', 'price', 'quantity', 'hidden']));

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $product->id . '.' . $image->getClientOriginalExtension();
                $image->storeAs('products', $imageName, 'public');
                $product->update(['image' => $imageName]);
            }

            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('products.index', $product->id)->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->update(['cancelled' => 1]);
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
}
