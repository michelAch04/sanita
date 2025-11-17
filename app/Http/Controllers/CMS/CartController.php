<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // cart in cms
    public function index(Request $request)
    {
        $query = $request->input('query');

        $carts = Cart::where('cancelled', 0)
            ->when($query, function ($q) use ($query) {
                $q->where('id', $query) // Match cart ID exactly
                    ->orWhere('promocode', 'like', "{$query}%") // Search promo code
                    ->orWhereHas('customer', function ($q2) use ($query) {
                        $q2->where('first_name', 'like', "{$query}%")
                            ->orWhere('last_name', 'like', "{$query}%")
                            ->orWhere('id', $query);
                    });
            })
            ->with(['customer', 'cartDetails'])
            ->get();

        if ($request->ajax()) {
            return view('cms.cart.index', compact('carts'))->renderSections()['carts_list'];
        }
        return view('cms.cart.index', compact('carts'));
    }
}
