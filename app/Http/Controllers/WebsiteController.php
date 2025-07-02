<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;
use App\Models\Slideshow;
use App\Models\Category;
use App\Models\Product;
use App\Models\DistributorStock;
use App\Models\DistributorAddress;
use App\Models\Address;
use App\Models\Governorate;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class WebsiteController extends Controller
{
    public function index()
    {
        $aboutus = AboutUs::first();
        $governorates = Governorate::all();
        $slideshow = Slideshow::where('hidden', 0)->where('cancelled', 0)->get()->sortBy('position');
        $categories = Category::where('hidden', 0)->where('cancelled', 0)->get()->sortBy('position');

        $products = $this->getAvailableProducts();
        $offers = $this->getOffers($products);

        return view('sanita.index', compact(
            'aboutus',
            'slideshow',
            'categories',
            'products',
            'offers',
            'governorates'
        ));
    }
    public function categories()
    {
        $categories = Category::where('hidden', 0)
            ->where('cancelled', 0)
            ->orderBy('position')
            ->paginate(20);

        return view('sanita.categories.index', compact('categories'));
    }

    public function products()
    {
        $products = $this->getAvailableProducts();
        $products = $this->paginateCollection($products, 20, 'products_page');
        return view('sanita.products.index', compact('products'));
    }

    public function offers()
    {
        $products = $this->getAvailableProducts();
        $offers = $this->getOffers($products);
        $offers = $this->paginateCollection($offers, 20, 'offers_page');

        return view('sanita.offers.index', compact('offers'));
    }

    public function category(Request $request)
    {
        $category_id = $request->category;
        $category = Category::with('subcategories')->find($category_id);

        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        // Only include visible subcategories (not hidden or cancelled)
        $validSubcategories = $category->subcategories->filter(function ($sub) {
            return !$sub->hidden && !$sub->cancelled;
        });

        $productsBySubcategory = [];
        $products = collect();

        if ($validSubcategories->count() > 1) {
            // Multiple subcategories: get products paginated per subcategory
            $products = $this->getAvailableProducts();
            foreach ($validSubcategories as $subcategory) {
                $filtered = $products->filter(function ($product) use ($subcategory) {
                    return $product->subcategories_id == $subcategory->id
                        && $product->listPrices->where('hidden', 0)->count() > 0;
                })->values();
                $productsBySubcategory[$subcategory->id] = $this->paginateCollection($filtered, 20, 'page_sub_' . $subcategory->id);
            }
        } elseif ($validSubcategories->count() === 1) {
            // Exactly one subcategory: show products of that subcategory without tabs
            $subcategory = $validSubcategories->first();
            $products = $this->getAvailableProducts();
            $filtered = $products->filter(function ($product) use ($subcategory) {
                return $product->subcategories_id == $subcategory->id
                    && $product->listPrices->where('hidden', 0)->count() > 0;
            })->values();
            $productsBySubcategory[$subcategory->id] = $this->paginateCollection($filtered, 20, 'page_sub_' . $subcategory->id);
        } else {
            // No subcategories = no products
            $products = collect();
            $productsBySubcategory = [];
        }

        return view('sanita.category.index', [
            'category' => $category,
            'productsBySubcategory' => $productsBySubcategory,
            'products' => $products,
        ]);
    }

    public function product(Request $request)
    {
        $product_id = $request->product;
        $product = Product::where('id', $product_id)->first();
        return view('sanita.product.index', compact('product'));
    }

    public function productsForCustomer($customerId, $type)
    {
        // Get all city IDs for the customer's addresses
        $cityIds = Address::where('customers_id', $customerId)->where('is_default', 1)->pluck('cities_id');

        // Get all distributor IDs serving those cities
        $distributorIds = DistributorAddress::whereIn('cities_id', $cityIds)->pluck('distributors_id');

        // Get products with their list prices and distributor stocks for those distributors
        $products = Product::with([
            'listPrices' => function ($q) use ($type) {
                $q->where('type', $type)->where('hidden', 0);
            },
            'distributorStocks' => function ($q) use ($distributorIds) {
                $q->whereIn('distributors_id', $distributorIds);
            }
        ])
            ->where('cancelled', 0)
            ->whereHas('distributorStocks', function ($q) use ($distributorIds) {
                $q->whereIn('distributors_id', $distributorIds);
            })
            ->get();

        return $products;
    }

    public function allProducts()
    {
        //automatic hide
        $products = Product::with([
            'listPrices' => function ($q) {
                $q->select()->where('type', 'b2c')->where('hidden', 0);
            },
            'distributorStocks'
        ])
            ->where('cancelled', 0)
            ->get();

        return $products;
    }

    protected function getOffers($products)
    {
        $offers = [];
        foreach ($products as $product) {
            $prices = $product->listPrices ? $product->listPrices->first() : null;
            if ($prices && $prices->old_price > 0 && $prices->old_price > $prices->shelf_price) {
                $offers[] = $product;
            }
        }
        return $offers;
    }

    protected function paginateCollection($items, $perPage = 20, $pageName = 'page')
    {
        $page = LengthAwarePaginator::resolveCurrentPage($pageName);
        $items = $items instanceof Collection ? $items : collect($items);
        $currentItems = $items->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $currentItems,
            $items->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
                'pageName' => $pageName,
            ]
        );
    }

    public function getAvailableProducts()
    {
        if (auth('customer')->check()) {
            $customer = auth('customer')->user();
            $customerid = $customer->id;
            $type = $customer->type;

            if ($type == 'b2c') {
                // return $this->productsForCustomer($customerid, 'b2c');
                return $this->allProducts($type);
            } elseif ($type == 'b2b') {
                // return $this->productsForCustomer($customerid, 'b2b');  
                return $this->allProducts($type);
            }
        }
        return $this->allProducts('b2b');
    }
}
