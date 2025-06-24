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

        return view('sanita.index', compact('aboutus', 'slideshow', 'categories', 'products', 'offers'));
    }

    public function categories()
    {
        $categories = Category::where('hidden', 0)
            ->where('cancelled', 0)
            ->orderBy('position')
            ->get();

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

        // Fetch category by ID and eager load subcategories and their related products
        $category = Category::with(['subcategories.products'])  // Eager load subcategories and their products
            ->where('id', $category_id)
            ->first();

        if ($category) {
            // Pass the category with subcategories and their products to the view
            return view('sanita.category.index', compact('category'));
        } else {
            // Handle case where category is not found
            return redirect()->back()->with('error', 'Category not found');
        }
    }



    public function product(Request $request)
    {
        $product_id = $request->product;
        $product = Product::where('id', $product_id)->first();
        return view('sanita.product.index', compact('product'));
    }
}
