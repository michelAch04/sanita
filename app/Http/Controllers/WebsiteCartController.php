<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebsiteCartController extends Controller
{
    public function index()
    {
        $customerId = auth()->guard('customer')->id();

        // Get active cart
        $cart = Cart::where('customers_id', $customerId)
            ->where('purchased', 0)
            ->where('cancelled', 0)
            ->with(['cartDetails' => function ($query) {
                $query->where('cancelled', 0)->with('product');
            }])
            ->first();

        // If cart exists but expired
        if ($cart && $cart->expires_at && $cart->expires_at < now()) {
            foreach ($cart->cartDetails as $detail) {
                if (!$detail->cancelled && $detail->product) {
                    $detail->product->increment('available_quantity', $detail->quantity);
                    $detail->update(['cancelled' => 1]);
                }
            }

            $cart->update(['cancelled' => 1]);

            return view('sanita.cart.index', [
                'cart' => null,
                'items' => [],
                'subtotal' => 0,
                'grandTotal' => 0,
            ])->with('error', 'Your cart has expired.');
        }

        if (!$cart) {
            return view('sanita.cart.index', [
                'cart' => null,
                'items' => [],
                'subtotal' => 0,
                'grandTotal' => 0,
            ]);
        }

        $items = $cart->cartDetails;

        // ✅ Prevent repeated redirect for out-of-stock
        if (!session()->pull('out_of_stock_checked')) {
            foreach ($items as $item) {
                if ($item->product && $item->product->available_quantity < $item->quantity) {
                    // Set flag only for next request
                    session()->put('out_of_stock_checked', true);

                    return redirect()
                        ->route('cart.index', ['locale' => app()->getLocale()])
                        ->with('error', 'One or more items in your cart are out of stock.');
                }
            }
        }

        $subtotal = $items->sum(function ($item) {
            return $item->unit_price * $item->quantity;
        });

        $grandTotal = $subtotal + $cart->delivery_charge;

        return view('sanita.cart.index', [
            'cart' => $cart,
            'items' => $items,
            'subtotal' => $subtotal,
            'grandTotal' => $grandTotal,
        ]);
    }



    public function store(Request $request)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $customerId = auth()->guard('customer')->id();
        if (!$customerId) {
            return response()->json(['success' => false, 'message' => 'You must be logged in to add to cart.'], 403);
        }

        $product = Product::find($request->product_id);


        if ($product->available_quantity < $request->quantity) {
            return response()->json(['success' => false, 'message' => 'Product is out of stock.'], 400);
        }

        $cart = Cart::firstOrCreate(
            ['customers_id' => $customerId, 'purchased' => 0, 'cancelled' => 0],
            ['expires_at' => now()->addHours(2)]
        );

        // If already exists, update qty
        $existingDetail = $cart->cartDetails()->where('products_id', $product->id)->where('cancelled', 0)->first();
        if ($existingDetail) {
            $existingDetail->increment('quantity', $request->quantity);
        } else {
            $cart->cartDetails()->create([
                'products_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $request->price,
                'description' => $request->description,
            ]);
        }

        // Decrease stock
        $product->decrement('available_quantity', $request->quantity);

        // Update session cart count
        $cartCount = $cart->cartDetails()->where('cancelled', 0)->count('id');
        session(['cart_count' => $cartCount]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart_count' => $cartCount
        ]);
    }



    public function update(Request $request, $id)
    {
        $cartDetail = CartDetail::with('product')->findOrFail($id);

        if (!$cartDetail->product) {
            return redirect()->route('cart.index', ['locale' => app()->getLocale()])
                ->with('error', 'Product not found.');
        }

        $product = $cartDetail->product;

        if ($request->action === 'increase') {
            if ($product->available_quantity < 1) {
                return redirect()->route('cart.index', ['locale' => app()->getLocale()])
                    ->with('error', 'No more stock available.');
            }

            $cartDetail->increment('quantity');
            $product->decrement('available_quantity');
        } elseif ($request->action === 'decrease' && $cartDetail->quantity > 1) {
            $cartDetail->decrement('quantity');
            $product->increment('available_quantity');
        }

        return redirect()->route('cart.index', ['locale' => app()->getLocale()])
            ->with('success', 'Cart updated successfully!');
    }



    public function destroy(string $id)
    {
        $customerId = auth()->guard('customer')->id();

        $cart = Cart::where('customers_id', $customerId)
            ->where('purchased', false)
            ->where('cancelled', false)
            ->first();

        if ($cart) {
            $cartDetail = $cart->cartDetails()->where('id', $id)->where('cancelled', 0)->first();

            if ($cartDetail && $cartDetail->product) {
                // Restore quantity
                $cartDetail->product->increment('available_quantity', $cartDetail->quantity);

                // Cancel item
                $cartDetail->update(['cancelled' => 1]);
            }
        }

        return redirect()->route('cart.index', ['locale' => app()->getLocale()])
            ->with('success', 'Product removed from cart.');
    }
}
