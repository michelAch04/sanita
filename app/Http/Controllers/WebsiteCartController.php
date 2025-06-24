<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Address;
use App\Models\Customer;

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
            $q->where('cancelled', 0)->with(['product' => function ($q) {
                $q->where('cancelled', 0);
            }]);
        }])
            ->where('customers_id', auth()->id())
            ->where('purchased', 0)
            ->where('cancelled', 0)
            ->first();

        return view('sanita.cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        try {
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be signed in to add to cart.'
                ], 401);
            }

            $request->validate([
                'product_id' => 'required|exists:products,id',
            ]);

            $product = Product::where('id', $request->product_id)
                ->where('available_quantity', '>', 0)
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found or out of stock.',
                ], 422);
            }

            $customerId = auth()->id();

            $cart = Cart::firstOrCreate(
                ['customers_id' => $customerId, 'purchased' => 0, 'cancelled' => 0],
                ['expires_at' => now()->addYear(1)]
            );

            $cartDetail = $cart->cartDetails()
                ->where('products_id', $request->product_id)
                ->where('cancelled', 0)
                ->first();

            $quantity = max(1, (int)$request->input('quantity', 1)); // Always at least 1

            if ($cartDetail) {
                $cartDetail->quantity += $quantity;
                $cartDetail->save();
            } else {
                $cart->cartDetails()->create([
                    'products_id' => $product->id,
                    'shelf_price' => $product->shelf_price,
                    'old_price' => $product->old_price,
                    'quantity' => $quantity, // <-- use requested quantity
                    'cancelled' => 0,
                ]);
            }

            return response()->json([
                'success' => true,
                'shelf_price' => $request->price,
                'old_price' => $product->old_price,
            ]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
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

        $itemTotal = $cart->shelf_price * $quantity;

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'quantity' => $quantity,
                'item_total' => round($itemTotal, 2)
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

        $customerId = auth()->id();
        $addresses = Address::where('customer_id', $customerId)->get();

        $subtotal = 0;
        $totalTax = 0;
        $total = 0;

        if ($cart && $cart->cartDetails) {
            foreach ($cart->cartDetails as $item) {
                $product = $item->product;

                // Only calculate tax if shelf_price > unit_price
                if ($product->shelf_price > $product->unit_price) {
                    $lineUnitPrice = $product->unit_price * $item->quantity;
                    $lineShelfPrice = $product->shelf_price * $item->quantity;

                    $lineTax = $lineShelfPrice - $lineUnitPrice;

                    $subtotal += $lineUnitPrice;
                    $total += $lineShelfPrice;
                    $totalTax += $lineTax;
                } else {
                    // No tax applied, treat shelf = unit
                    $linePrice = $product->unit_price * $item->quantity;

                    $subtotal += $linePrice;
                    $total += $linePrice;
                    // $totalTax += 0; // Not necessary to add zero
                }
            }
        }


        return view('sanita.cart.checkout', compact('cart', 'addresses', 'subtotal', 'totalTax', 'total'));
    }
}
