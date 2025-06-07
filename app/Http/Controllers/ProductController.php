<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::query();

            if ($request->filled('query')) {
                $search = $request->query('query');

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('small_description', 'like', "$search%");
                });
            }

            $products = $query->get();

            if ($request->ajax()) {
                return view('cms.products.index', compact('products'))->renderSections()['products_list'];
            }

            return view('cms.products.index', compact('products'));
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Failed to fetch products: ' . $e->getMessage());
        }
    }


    public function create()
    {
        $brands = Brand::where('cancelled', 0)->get();
        $categories = Category::where('cancelled', 0)->get();
        $subcategories = Subcategory::where('cancelled', 0)->get();

        return view('cms.products.create', compact('brands', 'categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'name' => 'required|string|max:255',
                'sku' => 'required|string|max:255|unique:products,sku', // Ensure SKU is unique
                'description' => 'nullable|string',
                'small_description' => 'nullable|string|max:255',
                'unit_price' => 'required|numeric|min:0',
                'shelf_price' => 'required|numeric|min:0',
                'threshold' => 'required|integer|min:0',
                'tax' => 'required|integer|min:0',
                'available_quantity' => 'required|integer|min:0',
                'hidden' => 'required|boolean',
                'automatic_hide' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
            ]);

            // Create the product with the validated data
            $product = Product::create([
                'name' => $request->name,
                'sku' => $request->sku,
                'description' => $request->description,
                'small_description' => $request->small_description,
                'unit_price' => $request->unit_price,
                'shelf_price' => $request->shelf_price,
                'threshold' => $request->threshold,
                'tax' => $request->tax,
                'available_quantity' => $request->available_quantity,
                'hidden' => $request->hidden,
                'automatic_hide' => $request->automatic_hide,
                'cancelled' => 0, // Default to not cancelled
                'extension' => null, // Initialize extension to null
                'subcategory_id' => null,
                'brand_id' => null,
            ]);

            // If an image is uploaded, handle it
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = $product->id . '.' . $extension;
                $image->storeAs('products', $imageName, 'public');
                // Update the product record with the image extension
                $product->update(['extension' => $extension]);
            }

            // Return success response
            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            // Handle exceptions and return an error message
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
                'unit_price' => 'required|numeric|min:0',
                'available_quantity' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'small_description' => 'nullable|string|max:255',
                'visible' => 'nullable|boolean', // visible is the checkbox name in the form
            ]);

            // Convert 'visible' checkbox to 'hidden' field (inverted logic)
            $data = $request->only([
                'name',
                'description',
                'unit_price',
                'available_quantity',
                'small_description',
            ]);

            $data['hidden'] = !$request->boolean('visible'); // <-- this flips visible to hidden

            $product->update($data);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = $product->id . '.' . $extension;
                $image->storeAs('products', $imageName, 'public');
                $product->update(['extension' => $extension]);
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
