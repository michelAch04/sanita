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
        $cart = Cart::with(['cartDetails' => function ($query) {
                            $query->where('cancelled', 0);
                        }])
                        ->where('customers_id', auth()->id())
                        ->where('purchased', 0)
                        ->where('cancelled', 0)
                        ->first();

        $cartCount = $cart ? $cart->cartDetails->count() : 0;
// dd( $cartCount);
        $aboutus = AboutUs::first();
        $slideshow = Slideshow::where('hidden', 0)->where('cancelled', 0)->get()->sortBy('position');
        $categories = Category::where('hidden', 0)->where('cancelled', 0)->get()->sortBy('position');

        $products = Product::where('hidden', 0)
            ->where('cancelled', 0)
            ->where(function ($query) {
                $query->where('automatic_hide', 0)
                    ->orWhere('available_quantity', '>', 0);
            })
            ->get()
            ->sortBy('position');

        $offers = Product::where('hidden', 0)
            ->where('cancelled', 0)
            ->where('old_price', '>', 0)
            ->where(function ($query) {
                $query->where('automatic_hide', 0)
                    ->orWhere('available_quantity', '>', 0);
            })
            ->get()
            ->sortBy('position');

        return view('sanita.index', compact('aboutus', 'slideshow', 'categories', 'products', 'offers', 'cartCount'));
    }
}
