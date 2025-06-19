<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\Tax;

class WebsiteCartController extends Controller
{
    public function index()
    {
        $expired = Cart::with('cartDetails')
            ->where('customers_id', auth()->id())
            ->where('purchased', 0)
            ->where('cancelled', 0)
            ->where('expires_at', '<', now())
            ->first();

        if ($expired) {
            $expired->update(['cancelled' => 1]);
            $expired->cartDetails()->update(['cancelled' => 1]);
        }

        $cart = Cart::with(['cartDetails' => function ($q) {
            $q->where('cancelled', 0)->with('product');
        }])
            ->where('customers_id', auth()->id())
            ->where('purchased', 0)
            ->where('cancelled', 0)
            ->first();

        return view('sanita.cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        $product = Product::where('id', $request->product_id)
            ->where('available_quantity', '>', 0)
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product is out of stock.',
            ], 422);
        }

        $customerId = auth()->id();

        $cart = Cart::firstOrCreate(
            ['customers_id' => $customerId, 'purchased' => 0, 'cancelled' => 0],
            ['expires_at' => now()->addYear(1)]
        );

        if (!$cart->wasRecentlyCreated) {
            $cart->update(['expires_at' => now()->addHours(2)]);
        }

        $cartDetail = $cart->cartDetails()
            ->where('products_id', $request->product_id)
            ->where('cancelled', 0)
            ->first();

        if ($cartDetail) {
            $cartDetail->quantity += 1;
            $cartDetail->save();
        } else {
            $cart->cartDetails()->create([
                'products_id' => $request->product_id,
                'unit_price' => $request->price,
                'old_price' => $product->old_price,
                'quantity' => 1,
                'cancelled' => 0,
            ]);
        }

        return response()->json([
            'success' => true,
            'unit_price' => $request->price,
            'old_price' => $product->old_price,
        ]);
    }

    public function update(Request $request, $locale, CartDetail $cart)
    {
        $product = Product::where('id', $cart->products_id)
            ->where('available_quantity', '>', 0)
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product is out of stock.',
            ], 422);
        }

        $quantity = max(1, (int)$request->input('quantity'));

        if ($quantity > $product->available_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available.',
            ], 422);
        }

        $cart->quantity = $quantity;
        $cart->save();

        $itemTotal = $cart->unit_price * $quantity;

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'quantity' => $quantity,
                'item_total' => number_format($itemTotal, 2)
            ]);
        }

        return redirect()->back()->with('success', __('cart.updated'));
    }

    public function destroy(Request $request, $locale, CartDetail $cart)
    {
        $carts_id = $cart->carts_id;
        $products_id = $cart->products_id;

        $remainingItems = CartDetail::where('carts_id', $carts_id)
            ->where('cancelled', 0)
            ->where('id', '!=', $cart->id)
            ->count();

        CartDetail::where('carts_id', $carts_id)
            ->where('products_id', $products_id)
            ->update(['cancelled' => 1]);

        Product::where('id', $products_id)
            ->increment('available_quantity', $cart->quantity);

        if ($remainingItems === 0) {
            Cart::where('id', $carts_id)->update(['cancelled' => 1]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'carts_id' => $cart->carts_id,
                    'products_id' => $cart->products_id,
                ]
            ]);
        }

        return redirect()->back()->with('success', __('cart.removed'));
    }

    public function checkout()
    {
        $cart = Cart::with(['cartDetails.product'])
            ->where('customers_id', auth()->id())
            ->where('purchased', 0)
            ->where('cancelled', 0)
            ->first();

        $addresses = auth()->user()->addresses()->get();

        $subtotal = 0;
        $totalTax = 0;
        $total = 0;

        $taxRates = Tax::all()->keyBy('id');

        if ($cart && $cart->cartDetails) {
            foreach ($cart->cartDetails as $item) {
                $product = $item->product;

                if (!$product) continue;
                //check if itemtaxable or not 
                if ($product->tax_id != null) {
                    $lineSubtotal = $product->unit_price * $item->quantity;
                    $lineTotal = $product->shelf_price * $item->quantity;

                    $subtotal += $lineSubtotal;
                    $total += $lineTotal;

                    $totalTax = $total - $subtotal;
                }
            }
        }

        return view('sanita.cart.checkout', compact('cart', 'addresses', 'subtotal', 'totalTax', 'total'));
    }
}
