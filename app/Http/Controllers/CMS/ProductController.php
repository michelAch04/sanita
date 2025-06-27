<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Tax;
use App\Models\ListPrice;
use Illuminate\Support\Facades\DB;


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
                        ->orWhere('small_description_en', 'like', "%$search%")
                        // Search subcategory name
                        ->orWhereHas('subcategories', function ($sub) use ($search) {
                            $sub->where('name_en', 'like', "%$search%");
                        })
                        // Search brand name
                        ->orWhereHas('brands', function ($brand) use ($search) {
                            $brand->where('name_en', 'like', "%$search%");
                        });
                });
            }

            $products = $query->where('cancelled', 0)->with(['subcategories', 'brands', 'tax', 'listPrices'])
                ->orderBy('position')
                ->get();
            // dd($products);
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
            // Validate the input
            $validated = $request->validate([
                'sku' => 'required|string|max:255|unique:products,sku',
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'name_ku' => 'required|string|max:255',
                'small_description_en' => 'nullable|string',
                'small_description_ar' => 'nullable|string',
                'small_description_ku' => 'nullable|string',
                'ea_ca' => 'required|numeric',
                'ea_pa' => 'required|numeric',
                'subcategories_id' => 'required|exists:subcategories,id',
                'brands_id' => 'required|exists:brands,id',
                'tax_id' => 'nullable|exists:taxes,id',
                'image' => 'nullable|image|max:2048',

                // B2B
                'b2b_unit_price' => 'required|numeric|min:0',
                'b2b_old_price' => 'nullable|numeric|min:0',
                'b2b_min_quantity_to_order' => 'nullable|integer|min:0',
                'b2b_max_quantity_to_order' => 'nullable|integer|min:0',
                'b2b_trade_loader' => 'nullable|numeric|min:0',
                'b2b_trade_loader_quantity' => 'nullable|integer|min:0',
                'b2b_UOM' => 'nullable|string|max:50',

                // B2C
                'b2c_unit_price' => 'required|numeric|min:0',
                'b2c_old_price' => 'nullable|numeric|min:0',
                'b2c_min_quantity_to_order' => 'nullable|integer|min:0',
                'b2c_max_quantity_to_order' => 'nullable|integer|min:0',
                'b2c_trade_loader' => 'nullable|numeric|min:0',
                'b2c_trade_loader_quantity' => 'nullable|integer|min:0',
                'b2c_UOM' => 'nullable|string|max:50',
            ]);

            DB::transaction(function () use ($request, $validated) {

                $extension = 'png';
                // Create product
                $product = Product::create([
                    'sku' => $validated['sku'],
                    'name_en' => $validated['name_en'],
                    'name_ar' => $validated['name_ar'],
                    'name_ku' => $validated['name_ku'],
                    'small_description_en' => $validated['small_description_en'],
                    'small_description_ar' => $validated['small_description_ar'],
                    'small_description_ku' => $validated['small_description_ku'],
                    'ea_ca' => $validated['ea_ca'],
                    'ea_pa' => $validated['ea_pa'],
                    'subcategories_id' => $validated['subcategories_id'],
                    'brands_id' => $validated['brands_id'],
                    'tax_id' => $validated['tax_id'] ?? null,
                    'extension' => $extension,
                    'cancelled' => 0,
                ]);

                $imagePath = null;
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $extension = $image->getClientOriginalExtension();

                    $tempPath = $image->store('products', 'public');
                    $newFileName = $product->id . '.' . $extension;
                    $newPath = 'products/' . $newFileName;

                    \Storage::disk('public')->move($tempPath, $newPath);

                    $product->update(['extension' => $extension]);
                }



                // Insert B2B price
                ListPrice::create([
                    'products_id' => $product->id,
                    'type' => 'b2b',
                    'unit_price' => $validated['b2b_unit_price'],
                    'shelf_price' => $this->calculateShelfPrice($validated['b2b_unit_price'], $product->tax?->rate),
                    'old_price' => $validated['b2b_old_price'],
                    'min_quantity_to_order' => 1,
                    'max_quantity_to_order' => $validated['b2b_max_quantity_to_order'],
                    'trade_loader' => $validated['b2b_trade_loader'],
                    'trade_loader_quantity' => $validated['b2b_trade_loader_quantity'],
                    'UOM' => $validated['b2b_UOM'],
                    'hidden' => $request->has('b2b_hidden'),
                    'automatic_hide' => $request->has('b2b_automatic_hide'),
                    'EA' => $request->has('b2b_EA'),
                    'CA'    => $request->has('b2b_CA'),
                    'PL' => $request->has('b2b_PL'),
                ]);

                // Insert B2C price
                ListPrice::create([
                    'products_id' => $product->id,
                    'type' => 'b2c',
                    'unit_price' => $validated['b2c_unit_price'],
                    'shelf_price' => $this->calculateShelfPrice($validated['b2c_unit_price'], $product->tax?->rate),
                    'old_price' => $validated['b2c_old_price'],
                    'min_quantity_to_order' => 1,
                    'max_quantity_to_order' => $validated['b2c_max_quantity_to_order'],
                    'trade_loader' => $validated['b2c_trade_loader'],
                    'trade_loader_quantity' => $validated['b2c_trade_loader_quantity'],
                    'UOM' => $validated['b2c_UOM'],
                    'hidden' => $request->has('b2c_hidden'),
                    'automatic_hide' => $request->has('b2c_automatic_hide'),
                    'EA' => $request->has('b2c_EA'),
                    'CA'    => $request->has('b2c_CA'),
                    'PL' => $request->has('b2c_PL'),
                ]);
            });

            return redirect()->route('products.index')->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }



    public function edit(Product $product)
    {
        $brands = Brand::where('cancelled', 0)->get();
        $subcategories = Subcategory::where('cancelled', 0)->get();
        $taxes = Tax::where('cancelled', 0)->get();

        // Load B2B and B2C price records
        $b2bPrice = $product->listPrices->where('type', 'b2b')->first();
        $b2cPrice = $product->listPrices->where('type', 'b2c')->first();

        return view('cms.products.edit', compact('product', 'brands', 'subcategories', 'taxes', 'b2bPrice', 'b2cPrice'));
    }


    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'name_ku' => 'required|string|max:255',
                'small_description_en' => 'nullable|string',
                'small_description_ar' => 'nullable|string',
                'small_description_ku' => 'nullable|string',
                'ea_ca' => 'required|numeric',
                'ea_pa' => 'required|numeric',
                'subcategories_id' => 'required|exists:subcategories,id',
                'brands_id' => 'required|exists:brands,id',
                'tax_id' => 'nullable|exists:taxes,id',
                'image' => 'nullable|image|max:2048',

                // B2B
                'b2b_unit_price' => 'required|numeric|min:0',
                'b2b_old_price' => 'nullable|numeric|min:0',
                'b2b_min_quantity_to_order' => 'nullable|integer|min:0',
                'b2b_max_quantity_to_order' => 'nullable|integer|min:0',
                'b2b_trade_loader' => 'nullable|numeric|min:0',
                'b2b_trade_loader_quantity' => 'nullable|integer|min:0',
                'b2b_UOM' => 'nullable|string|max:50',

                // B2C
                'b2c_unit_price' => 'required|numeric|min:0',
                'b2c_old_price' => 'nullable|numeric|min:0',
                'b2c_min_quantity_to_order' => 'nullable|integer|min:0',
                'b2c_max_quantity_to_order' => 'nullable|integer|min:0',
                'b2c_trade_loader' => 'nullable|numeric|min:0',
                'b2c_trade_loader_quantity' => 'nullable|integer|min:0',
                'b2c_UOM' => 'nullable|string|max:50',
            ]);

            DB::transaction(function () use ($request, $validated, $product) {
                // Update product core fields
                $product->update([
                    'sku' => $validated['sku'],
                    'name_en' => $validated['name_en'],
                    'name_ar' => $validated['name_ar'],
                    'name_ku' => $validated['name_ku'],
                    'small_description_en' => $validated['small_description_en'],
                    'small_description_ar' => $validated['small_description_ar'],
                    'small_description_ku' => $validated['small_description_ku'],
                    'ea_ca' => $validated['ea_ca'],
                    'ea_pa' => $validated['ea_pa'],
                    'subcategories_id' => $validated['subcategories_id'],
                    'brands_id' => $validated['brands_id'],
                    'tax_id' => $validated['tax_id'] ?? null,
                ]);

                // Handle image upload
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $extension = $image->getClientOriginalExtension();
                    $imageName = $product->id . '.' . $extension;
                    $image->storeAs('products', $imageName, 'public');
                    $product->update(['extension' => $extension]);
                }

                // Update B2B list price
                $product->listPrices()->updateOrCreate(
                    ['type' => 'b2b'],
                    [
                        'unit_price' => $validated['b2b_unit_price'],
                        'shelf_price' => $this->calculateShelfPrice($validated['b2b_unit_price'], $product->tax?->rate),
                        'old_price' => $validated['b2b_old_price'],
                        'min_quantity_to_order' => 1,
                        'max_quantity_to_order' => $validated['b2b_max_quantity_to_order'],
                        'trade_loader' => $validated['b2b_trade_loader'],
                        'trade_loader_quantity' => $validated['b2b_trade_loader_quantity'],
                        'UOM' => $validated['b2b_UOM'],
                        'hidden' => $request->has('b2b_hidden'),
                        'automatic_hide' => $request->has('b2b_automatic_hide'),
                        'EA' => $request->has('b2b_EA'),
                        'CA' => $request->has('b2b_CA'),
                        'PL' => $request->has('b2b_PL'),
                    ]
                );

                // Update B2C list price
                $product->listPrices()->updateOrCreate(
                    ['type' => 'b2c'],
                    [
                        'unit_price' => $validated['b2c_unit_price'],
                        'shelf_price' => $this->calculateShelfPrice($validated['b2c_unit_price'], $product->tax?->rate),
                        'old_price' => $validated['b2c_old_price'],
                        'min_quantity_to_order' => 1,
                        'max_quantity_to_order' => $validated['b2c_max_quantity_to_order'],
                        'trade_loader' => $validated['b2c_trade_loader'],
                        'trade_loader_quantity' => $validated['b2c_trade_loader_quantity'],
                        'UOM' => $validated['b2c_UOM'],
                        'hidden' => $request->has('b2c_hidden'),
                        'automatic_hide' => $request->has('b2c_automatic_hide'),
                        'EA' => $request->has('b2c_EA'),
                        'CA' => $request->has('b2c_CA'),
                        'PL' => $request->has('b2c_PL'),
                    ]
                );
            });

            return redirect()->route('products.index')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Failed to update product: ' . $e->getMessage());
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

    private function calculateShelfPrice($unitPrice, $taxRate)
    {
        if ($taxRate) {
            return round($unitPrice * (1 + $taxRate / 100), 2);
        }
        return $unitPrice;
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $item) {
            Product::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return response()->json(['success' => true]);
    }
}
