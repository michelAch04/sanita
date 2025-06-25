<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Tax;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::query();

            if ($request->filled('query')) {
                $search = $request->query('query');

                $query->where(function ($q) use ($search) {
                    $q->where('name_en', 'like', "%$search%")
                        ->orWhere('small_description_en', 'like', "$search%");
                });
            }

            $products = $query->with(['subcategories', 'brands', 'tax'])
                ->orderBy('position')
                ->get();

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
        $subcategories = Subcategory::where('cancelled', 0)->get();
        $taxes = Tax::where('cancelled', 0)->get();
        return view('cms.products.create', compact('brands', 'subcategories', 'taxes'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'name_ku' => 'required|string|max:255',
                'small_description_en' => 'nullable|string|max:255',
                'small_description_ar' => 'nullable|string|max:255',
                'small_description_ku' => 'nullable|string|max:255',
                'sku' => 'required|string|max:255|unique:products,sku',
                'barcode' => 'nullable|string|max:255|unique:products,barcode',
                'unit_price' => 'required|numeric|min:0',
                'shelf_price' => 'required|numeric|min:0',
                'old_price' => 'nullable|numeric|min:0',
                'threshold' => 'required|integer|min:0',
                'available_quantity' => 'required|integer|min:0',
                'subcategories_id' => 'required|exists:subcategories,id',
                'brands_id' => 'required|exists:brands,id',
                'hidden' => 'boolean',
                'automatic_hide' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'tax_id' => 'nullable|exists:taxes,id',
            ]);

            $product = Product::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'name_ku' => $request->name_ku,
                'small_description_en' => $request->small_description_en,
                'small_description_ar' => $request->small_description_ar,
                'small_description_ku' => $request->small_description_ku,
                'barcode' => $request->barcode,
                'sku' => $request->sku,
                'description' => $request->description,
                'small_description' => $request->small_description,
                'unit_price' => $request->unit_price,
                'shelf_price' => $request->shelf_price,
                'old_price' => $request->old_price,
                'threshold' => $request->threshold,
                'available_quantity' => $request->available_quantity,
                'subcategories_id' => $request->subcategories_id,
                'brands_id' => $request->brands_id,
                'hidden' => $request->has('hidden') ? 1 : 0,
                'automatic_hide' => $request->has('automatic_hide') ? 1 : 0,
                'cancelled' => 0,
                'extension' => null,
                'tax_id' => $request->tax_id,
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = $product->id . '.' . $extension;
                $image->storeAs('products', $imageName, 'public');
                $product->update(['extension' => $extension]);
            }

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('products.create')->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $brands = Brand::where('cancelled', 0)->get();
        $subcategories = Subcategory::where('cancelled', 0)->get();
        $taxes = Tax::where('cancelled', 0)->get();
        return view('cms.products.edit', compact('product', 'brands', 'subcategories', 'taxes'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            $data = $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'name_ku' => 'required|string|max:255',
                'small_description_en' => 'nullable|string|max:255',
                'small_description_ar' => 'nullable|string|max:255',
                'small_description_ku' => 'nullable|string|max:255',
                'unit_price' => 'required|numeric|min:0',
                'shelf_price' => 'required|numeric|min:0',
                'old_price' => 'nullable|numeric|min:0',
                'available_quantity' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'small_description' => 'nullable|string|max:255',
                'visible' => 'nullable|boolean',
                'automatic_hide' => 'nullable|boolean',
                'tax_id' => 'nullable|exists:taxes,id',
                'subcategories_id' => 'required|exists:subcategories,id',
            ]);

            $data['hidden'] = !$request->boolean('visible');

            $data['automatic_hide'] = $request->has('automatic_hide') ? 1 : 0;

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

    public function reorder(Request $request)
    {
        foreach ($request->order as $item) {
            Product::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return response()->json(['success' => true]);
    }
}
