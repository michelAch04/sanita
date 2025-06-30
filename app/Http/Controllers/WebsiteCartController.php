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
        $cart = Cart::with(['cartDetails' => function ($q) {
            $q->with(['product']);
        }])
            ->where('customers_id', auth()->id())
            ->first();

        return view('sanita.cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        try {
            //validate the request 
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'description' => 'nullable|string|max:255',
                'quantity' => 'required|integer|min:1',
                'type' => 'required|string|max:50',
                'old_price' => 'nullable|numeric|min:0',
                'unit_price' => 'required|numeric|min:0',
                'shelf_price' => 'required|numeric|min:0',
                'ea_ca' => 'required|integer|min:0',
                'ea_pl' => 'required|integer|min:0',
                'unit' => 'required|string|in:EA,CA,PL',
            ]);
            $product_id = $request->input('product_id');
            $quantity = max(1, (int)$request->input('quantity'));
            $product = Product::where('id', $product_id)
                ->with(['listPrices' => function ($q) use ($request) {
                    $q->where('type', $request->input('type'));
                }])
                ->with(['distributorStocks' => function ($q) {
                    $q->where('stock', '>', 0);
                }])
                ->first();

            $unit = $request->input('unit', 'EA');
            $ea_ca = (int)$request->input('ea_ca');
            $ea_pl = (int)$request->input('ea_pl');

            // Convert requested quantity to EA
            $requestedQuantityEA = $quantity;
            if ($unit === 'CA') {
                $requestedQuantityEA = $quantity * $ea_ca;
            } elseif ($unit === 'PL') {
                $requestedQuantityEA = $quantity * $ea_pl;
            }

            // Calculate total available stock in EA
            $totalStockEA = $product->distributorStocks->sum('stock');

            // Check stock
            if ($requestedQuantityEA > $totalStockEA) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available.',
                    'stock' => $totalStockEA,
                ], 422);
            }

            // 1. Get customer ID
            $customerId = auth('customer')->id();

            // 2. Create cart header if not exists
            $cart = Cart::firstOrCreate(
                [
                    'customers_id' => $customerId,
                    'total_amount' => 0,
                    'subtotal_amount' => 0,
                    'tax_amount' => 0
                ]
            );

            $unitPrice = $request->input('unit_price');
            $shelfPrice = $request->input('shelf_price');
            $oldPrice = $request->input('old_price', 0);

          
            CartDetail::create([
                'carts_id' => $cart->id,
                'products_id' => $product->id,
                'quantity_ea' => $quantity,
                'UOM' => $unit,
                'unit_price' => $unitPrice,
                'shelf_price' => $shelfPrice,
                'old_price' => $oldPrice,
                'description' => $request->input('description'),
            ]);

            return response()->json([
                'success' => true,
                'product' => $product,
                'quantity_ea' => $quantity,
                'unit' => $unit,
                'ea_ca' => $ea_ca,
                'ea_pl' => $ea_pl,

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
        $customerId = auth('customer')->id();

        $cart = Cart::firstOrCreate(
            ['customers_id' => $customerId, 'purchased' => 0, 'cancelled' => 0],
            ['customers_id' => $customerId, 'total_amount' => 0]
        );

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
