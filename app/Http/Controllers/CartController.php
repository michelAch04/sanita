<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('purchased', 0)
            ->with('customer')
            ->with(['cartDetails' => function ($query) {
                $query->where('cancelled', 0)->with('product');
            }])
            ->where('customers_id', Auth::id())
            ->first();

        // Fix: Check if $cart is not null before accessing its properties
        if ($cart && $cart->cancelled != 1 && $cart->expires_at && now()->greaterThan($cart->expires_at)) {
            $cart->cartDetails()->update(['cancelled' => 1]);
            $cart->update(['cancelled' => 1]);
        }

        return view('sanita.cart.index', compact('cart'));
    }

    public function cmsindex()
    {
        $carts = Cart::where('cancelled', 0)
            ->with('customer')
            ->with('cartDetails')
            ->get();
        return view('cms.cart.index', compact('carts'));
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Step 1: Create or fetch cart (header)
        $cart = Cart::firstOrCreate(
            ['customers_id' => Auth::id(), 'purchased' => false],
            ['expires_at' => now()->addDay()]
        );

        // Step 2: Check if product already exists in cart details
        $cartDetail = CartDetail::where('carts_id', $cart->id)
            ->where('products_id', $product->id)
            ->first();

        // step 3 check if the product is deleted or cancelled 
        if ($cartDetail) {
            $cartDetail->quantity += 1;
            $cartDetail->save();
        } else {
            CartDetail::create([
                'carts_id' => $cart->id,
                'products_id' => $product->id,
                'desc' => $product->small_description ?? $product->description,
                'unit_price' => $product->unit_price,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }


    public function update(Request $request, $id)
    {
        $cartDetail = CartDetail::findOrFail($id);

        if ($request->action === 'increase') {
            $cartDetail->quantity += 1;
        } elseif ($request->action === 'decrease' && $cartDetail->quantity > 1) {
            $cartDetail->quantity -= 1;
        }

        $cartDetail->save();

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function destroy(string $id)
    {
        $cart = Cart::where('customers_id', Auth::id())
            ->where('purchased', false)
            ->first();

        if ($cart) {
            $cart->cartDetails()->where('id', $id)->update(['cancelled' => 1]);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }
}
