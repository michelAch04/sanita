<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;
use App\Models\Slideshow;
use App\Models\Category;
use App\Models\Product;

class WebsiteController extends Controller
{
    public function index()
    {
        $aboutus = AboutUs::first();
        $slideshow = Slideshow::where('hidden', 0)->where('cancelled', 0)->get();
        $categories = Category::where('hidden', 0)->where('cancelled', 0)->get();

        $products = Product::where('hidden', 0)
            ->where('cancelled', 0)
            ->where(function ($query) {
                $query->where('automatic_hide', 0)
                    ->orWhere('available_quantity', '>', 0);
            })
            ->get();

        $offers = Product::where('hidden', 0)
            ->where('cancelled', 0)
            ->where('old_price', '>', 0)
            ->where(function ($query) {
                $query->where('automatic_hide', 0)
                    ->orWhere('available_quantity', '>', 0);
            })
            ->get()
            ->sortBy('position');

        return view('sanita.index', compact('aboutus', 'slideshow', 'categories', 'products', 'offers'));
    }
}
