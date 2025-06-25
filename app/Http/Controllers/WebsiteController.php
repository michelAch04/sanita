<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;
use App\Models\Slideshow;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartDetail;

class WebsiteController extends Controller
{
    public function index()
    {
        $aboutus = AboutUs::first();
        $governorates = \App\Models\Governorate::all();
        $slideshow = Slideshow::where('hidden', 0)->where('cancelled', 0)->get()->sortBy('position');
        $categories = Category::where('hidden', 0)->where('cancelled', 0)->get()->sortBy('position');

        // $products = Product::where('hidden', 0)
        //     ->where('cancelled', 0)
        //     ->where(function ($query) {
        //         $query->where('automatic_hide', 0)
        //             ->orWhere('available_quantity', '>', 0);
        //     })
        //     ->get()
        //     ->sortBy('position');
        $products = [];
        $offers = [];
        // $offers = Product::where('hidden', 0)
        //     ->where('cancelled', 0)
        //     ->where('old_price', '>', 0)
        //     ->where(function ($query) {
        //         $query->where('automatic_hide', 0)
        //             ->orWhere('available_quantity', '>', 0);
        //     })
        //     ->get()
        //     ->sortBy('position');

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
        $products = Product::where('hidden', 0)
            ->where('cancelled', 0)
            ->where(function ($query) {
                $query->where('automatic_hide', 0)
                    ->orWhere('available_quantity', '>', 0);
            })
            ->orderBy('position')
            ->get();

        return view('sanita.products.index', compact('products'));
    }

    public function offers()
    {
        $offers = Product::where('hidden', 0)
            ->where('cancelled', 0)
            ->where('old_price', '>', 0)
            ->where(function ($query) {
                $query->where('automatic_hide', 0)
                    ->orWhere('available_quantity', '>', 0);
            })
            ->orderBy('position')
            ->paginate(20);

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
        $products = null;

        if ($validSubcategories->count() > 1) {
            // Multiple subcategories: get products paginated per subcategory
            foreach ($validSubcategories as $subcategory) {
                $productsBySubcategory[$subcategory->id] = Product::where('subcategories_id', $subcategory->id)
                    ->where('hidden', 0)
                    ->where('cancelled', 0)
                    ->orderBy('position')
                    ->paginate(20, ['*'], 'page_sub_' . $subcategory->id);
            }
        } elseif ($validSubcategories->count() === 1) {
            // Exactly one subcategory: show products of that subcategory without tabs
            $subcategory = $validSubcategories->first();
            $products = Product::where('subcategories_id', $subcategory->id)
                ->where('hidden', 0)
                ->where('cancelled', 0)
                ->orderBy('position')
                ->paginate(20);
        } else {
            // No subcategories = no products
            $products = collect(); // empty collection, or you could keep null
        }

        return view('sanita.category.index', [
            'category' => $category,
            'productsBySubcategory' => $productsBySubcategory ?: null,
            'products' => $products,
        ]);
    }

    public function product(Request $request)
    {
        $product_id = $request->product;
        $product = Product::where('id', $product_id)->first();
        return view('sanita.product.index', compact('product'));
    }
}
