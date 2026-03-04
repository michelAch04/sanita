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
                        ->orWhere('sku', 'like', "%$search%")
                        ->orWhere('barcode', 'like', "%$search%")
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
            // Validation rules for each UOM per type
            $rules = [
                'sku' => 'required|string|max:255|unique:products,sku',
                'barcode' => 'required|string|max:255|unique:products,sku',
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'name_ku' => 'required|string|max:255',
                'small_description_en' => 'nullable|string',
                'small_description_ar' => 'nullable|string',
                'small_description_ku' => 'nullable|string',
                'ea_ca' => 'required|numeric',
                'ea_pl' => 'required|numeric',
                'subcategories_id' => 'required|exists:subcategories,id',
                'brands_id' => 'required|exists:brands,id',
                'tax_id' => 'nullable|exists:taxes,id',
                'image' => 'nullable|image',
            ];

            foreach (['b2b', 'b2c'] as $prefix) {
                foreach (['ea', 'ca', 'pl'] as $uom) {
                    $rules["{$prefix}_{$uom}_unit_price"] = 'nullable|numeric|min:0';
                    $rules["{$prefix}_{$uom}_old_price"] = 'nullable|numeric|min:0';
                    $rules["{$prefix}_{$uom}_min_quantity_to_order"] = 'nullable|integer|min:0';
                    $rules["{$prefix}_{$uom}_max_quantity_to_order"] = 'nullable|integer|min:0';
                    $rules["{$prefix}_{$uom}_trade_loader"] = 'nullable|numeric|min:0';
                    $rules["{$prefix}_{$uom}_trade_loader_quantity"] = 'nullable|integer|min:0';
                    $rules["{$prefix}_{$uom}_UOM"] = 'required|in:EA,CA,PL';
                }
            }

            $validated = $request->validate($rules);

            DB::transaction(function () use ($request, $validated) {
                $extension = 'png';

                $product = Product::create([
                    'sku' => $validated['sku'],
                    'barcode' => $validated['barcode'],
                    'name_en' => $validated['name_en'],
                    'name_ar' => $validated['name_ar'],
                    'name_ku' => $validated['name_ku'],
                    'small_description_en' => $validated['small_description_en'],
                    'small_description_ar' => $validated['small_description_ar'],
                    'small_description_ku' => $validated['small_description_ku'],
                    'ea_ca' => $validated['ea_ca'],
                    'ea_pl' => $validated['ea_pl'],
                    'subcategories_id' => $validated['subcategories_id'],
                    'brands_id' => $validated['brands_id'],
                    'tax_id' => $validated['tax_id'] ?? null,
                    'extension' => $extension,
                    'cancelled' => 0,
                ]);

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $extension = $image->getClientOriginalExtension();

                    $tempPath = $image->store('products', 'public');
                    $newFileName = $product->id . '.' . $extension;
                    $newPath = 'products/' . $newFileName;

                    \Storage::disk('public')->move($tempPath, $newPath);
                    $product->update(['extension' => $extension]);
                }

                foreach (['b2b', 'b2c'] as $prefix) {
                    foreach (['ea', 'ca', 'pl'] as $uom) {
                        $unitPrice = $validated["{$prefix}_{$uom}_unit_price"] ?? null;

                        if (!$unitPrice || $unitPrice <= 0) {
                            continue;
                        }
                        ListPrice::create([
                            'products_id' => $product->id,
                            'type' => $prefix,
                            'UOM' => strtoupper($uom),
                            'unit_price' => $validated["{$prefix}_{$uom}_unit_price"],
                            'shelf_price' => $this->calculateShelfPrice($validated["{$prefix}_{$uom}_unit_price"], $product->tax?->rate),
                            'old_price' => $validated["{$prefix}_{$uom}_old_price"] ?? null,
                            'min_quantity_to_order' => $validated["{$prefix}_{$uom}_min_quantity_to_order"] ?? 1,
                            'max_quantity_to_order' => $validated["{$prefix}_{$uom}_max_quantity_to_order"] ?? null,
                            'trade_loader' => $validated["{$prefix}_{$uom}_trade_loader"] ?? null,
                            'trade_loader_quantity' => $validated["{$prefix}_{$uom}_trade_loader_quantity"] ?? null,
                            'hidden' => $request->has("{$prefix}_hidden"),
                            'automatic_hide' => $request->has("{$prefix}_automatic_hide"),
                        ]);
                    }
                }
            });

            return redirect()->route('products.index')->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }



    public function edit(Product $product)
    {
        $brands = Brand::where('cancelled', 0)->get();
        $subcategories = Subcategory::where('cancelled', 0)->get();
        $taxes = Tax::where('cancelled', 0)->get();

        // Prepare price data for b2b and b2c, indexed by UOM
        $priceData = [];

        foreach ($product->listPrices as $price) {
            $type = $price->type;          // b2b or b2c
            $uom = strtolower($price->UOM); // ea, ca, pl

            foreach (
                [
                    'unit_price',
                    'old_price',
                    'min_quantity_to_order',
                    'max_quantity_to_order',
                    'trade_loader',
                    'trade_loader_quantity',
                    'hidden',
                    'automatic_hide',
                ] as $field
            ) {
                $key = "{$type}_{$uom}_{$field}";
                $priceData[$key] = $price->$field;
            }
        }

        return view('cms.products.edit', [
            'product' => $product,
            'brands' => $brands,
            'subcategories' => $subcategories,
            'taxes' => $taxes,
            'data' => (object) $priceData,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        try {
            $rules = [
                'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
                'barcode' => 'required|string|max:255|unique:products,sku,' . $product->id,
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'name_ku' => 'required|string|max:255',
                'small_description_en' => 'nullable|string',
                'small_description_ar' => 'nullable|string',
                'small_description_ku' => 'nullable|string',
                'ea_ca' => 'required|numeric',
                'ea_pl' => 'required|numeric',
                'subcategories_id' => 'required|exists:subcategories,id',
                'brands_id' => 'required|exists:brands,id',
                'tax_id' => 'nullable|exists:taxes,id',
                'image' => 'nullable|image',
            ];

            foreach (['b2b', 'b2c'] as $prefix) {
                foreach (['ea', 'ca', 'pl'] as $uom) {
                    $rules["{$prefix}_{$uom}_unit_price"] = 'nullable|numeric|min:0';
                    $rules["{$prefix}_{$uom}_old_price"] = 'nullable|numeric|min:0';
                    $rules["{$prefix}_{$uom}_min_quantity_to_order"] = 'nullable|integer|min:0';
                    $rules["{$prefix}_{$uom}_max_quantity_to_order"] = 'nullable|integer|min:0';
                    $rules["{$prefix}_{$uom}_trade_loader"] = 'nullable|numeric|min:0';
                    $rules["{$prefix}_{$uom}_trade_loader_quantity"] = 'nullable|integer|min:0';
                    $rules["{$prefix}_{$uom}_UOM"] = 'required|in:EA,CA,PL';
                }
            }

            $validated = $request->validate($rules);

            DB::transaction(function () use ($request, $validated, $product) {
                $product->update([
                    'sku' => $validated['sku'],
                    'barcode' => $validated['barcode'],
                    'name_en' => $validated['name_en'],
                    'name_ar' => $validated['name_ar'],
                    'name_ku' => $validated['name_ku'],
                    'small_description_en' => $validated['small_description_en'],
                    'small_description_ar' => $validated['small_description_ar'],
                    'small_description_ku' => $validated['small_description_ku'],
                    'ea_ca' => $validated['ea_ca'],
                    'ea_pl' => $validated['ea_pl'],
                    'subcategories_id' => $validated['subcategories_id'],
                    'brands_id' => $validated['brands_id'],
                    'tax_id' => $validated['tax_id'] ?? null,
                ]);

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $extension = $image->getClientOriginalExtension();
                    $tempPath = $image->store('products', 'public');
                    $newFileName = $product->id . '.' . $extension;
                    $newPath = 'products/' . $newFileName;

                    \Storage::disk('public')->move($tempPath, $newPath);
                    $product->update(['extension' => $extension]);
                }

                foreach (['b2b', 'b2c'] as $prefix) {
                    foreach (['ea', 'ca', 'pl'] as $uom) {
                        $unitPrice = $validated["{$prefix}_{$uom}_unit_price"] ?? null;

                        $existing = $product->listPrices()->where('type', $prefix)->where('UOM', strtoupper($uom));

                        // Delete if empty or 0
                        if (!$unitPrice || $unitPrice <= 0) {
                            $existing->delete();
                            continue;
                        }

                        $product->listPrices()->updateOrCreate(
                            ['type' => $prefix, 'UOM' => strtoupper($uom)],
                            [
                                'unit_price' => $validated["{$prefix}_{$uom}_unit_price"],
                                'shelf_price' => $this->calculateShelfPrice($validated["{$prefix}_{$uom}_unit_price"], $product->tax?->rate),
                                'old_price' => $validated["{$prefix}_{$uom}_old_price"] ?? null,
                                'min_quantity_to_order' => $validated["{$prefix}_{$uom}_min_quantity_to_order"] ?? 1,
                                'max_quantity_to_order' => $validated["{$prefix}_{$uom}_max_quantity_to_order"] ?? null,
                                'trade_loader' => $validated["{$prefix}_{$uom}_trade_loader"] ?? null,
                                'trade_loader_quantity' => $validated["{$prefix}_{$uom}_trade_loader_quantity"] ?? null,
                                'hidden' => $request->has("{$prefix}_hidden"),
                                'automatic_hide' => $request->has("{$prefix}_automatic_hide"),
                            ]
                        );
                    }
                }
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
