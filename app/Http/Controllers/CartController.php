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

        $carts = Cart::where('purchased', false)
            ->with('customers')
            ->first();


        return view('cms.cart.index', compact('carts'));
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = Cart::firstOrCreate(
            ['customer_id' => Auth::id(), 'purchased' => false],
            ['expires_at' => now()->addDay()]
        );

        $cartDetail = $cart->cartDetails()->where('product_id', $product->id)->first();

        if ($cartDetail) {
            $cartDetail->quantity++;
            $cartDetail->save();
        } else {
            $cart->cartDetails()->create([
                'product_id' => $product->id,
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
        $cart = Cart::where('customer_id', Auth::id())
            ->where('purchased', false)
            ->first();

        if ($cart) {
            $cart->cartDetails()->where('id', $id)->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }
}
