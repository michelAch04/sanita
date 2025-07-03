<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Address;
use App\Models\Governorate;
use App\Models\City;
use App\Models\District;
use App\Models\Customer;

class WebsiteCartController extends Controller
{
    public function index()
    {
        $cart = $this->getCartWithDetails();
        return view('sanita.cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        try {
            // 1. Validate the request
            $request->validate([
                'product_id'   => 'required|exists:products,id',
                'quantity'     => 'required|integer|min:1',
                'type'         => 'required|string|max:50',
                'old_price'    => 'nullable|numeric|min:0',
                'unit_price'   => 'required|numeric|min:0',
                'shelf_price'  => 'required|numeric|min:0',
                'ea_ca'        => 'required|integer|min:0',
                'ea_pl'        => 'required|integer|min:0',
                'unit'         => 'required|string|in:EA,CA,PL',
            ]);

            // 2. Get product and customer
            $product_id = $request->input('product_id');
            $quantity   = max(1, (int)$request->input('quantity'));
            $unit       = $request->input('unit', 'EA');
            $ea_ca      = (int)$request->input('ea_ca');
            $ea_pl      = (int)$request->input('ea_pl');
            $customerId = auth('customer')->id();

            $product = Product::where('id', $product_id)
                ->with(['listPrices' => function ($q) use ($request) {
                    $q->where('type', $request->input('type'));
                }])
                ->with(['distributorStocks' => function ($q) {
                    $q->where('stock', '>', 0);
                }])
                ->firstOrFail();

            $latestPrice = $product->listPrices()
                ->where('UOM', $unit)
                ->where('type', $request->input('type'))
                ->orderByDesc('id')
                ->first();

            if ($latestPrice) {
                $unitPrice = $latestPrice->unit_price;
                $shelfPrice = $latestPrice->shelf_price;
                $oldPrice = $latestPrice->old_price;
            } else {
                $unitPrice = $request->input('unit_price');
                $shelfPrice = $request->input('shelf_price');
                $oldPrice = $request->input('old_price', 0);
            }

            $extendedPrice = $shelfPrice * $quantity;

            // 3. Convert requested quantity to EA
            $requestedQuantityEA = $this->convertToEA($quantity, $unit, $ea_ca, $ea_pl);

            // 4. Find or create the cart
            $cart = $this->getOrCreateCart($customerId);

            // 5. Check if this product+UOM already exists in the cart
            $cartDetail = $this->getCartDetail($cart->id, $product->id, $unit);

            $alreadyInCartEA = $cartDetail ? $cartDetail->quantity_primary : 0;
            $totalRequestedEA = $requestedQuantityEA + $alreadyInCartEA;

            // 6. Check stock (including what's already in the cart)
            if (!$this->hasEnoughStock($product, $totalRequestedEA)) {
                $totalStockEA = $product->distributorStocks->sum('stock');
                return response()->json([
                    'success'            => false,
                    'message'            => 'Not enough stock available.',
                    'stock'              => $totalStockEA,
                    'requested_quantity' => $totalRequestedEA,
                    'already_in_cart'    => $alreadyInCartEA,
                ], 422);
            }

            // 7. Update cart totals
            $cart->total_amount    += $extendedPrice;
            $cart->subtotal_amount += $unitPrice * $quantity;
            $cart->tax_amount      += ($shelfPrice - $unitPrice) * $quantity;
            $cart->save();

            // 8. Update or create cart detail
            if ($cartDetail) {
                // Update existing cart detail
                $cartDetail->quantity_primary   += $requestedQuantityEA;
                $cartDetail->quantity_foreign   += $quantity;
                $cartDetail->unit_price          = $unitPrice;
                $cartDetail->shelf_price         = $shelfPrice;
                $cartDetail->old_price           = $oldPrice;
                $cartDetail->extended_price     += $extendedPrice;
                $cartDetail->save();
            } else {
                // Create new cart detail
                CartDetail::create([
                    'carts_id'         => $cart->id,
                    'products_id'      => $product->id,
                    'quantity_primary' => $requestedQuantityEA,
                    'quantity_foreign' => $quantity,
                    'UOM'              => $unit,
                    'unit_price'       => $unitPrice,
                    'shelf_price'      => $shelfPrice,
                    'old_price'        => $oldPrice,
                    'extended_price'   => $extendedPrice,
                ]);
            }

            return response()->json([
                'success'      => true,
                'product'      => $product,
                'quantity_ea'  => $quantity,
                'unit'         => $unit,
                'ea_ca'        => $ea_ca,
                'ea_pl'        => $ea_pl,
                'item_total'   => round($extendedPrice, 2),
                'cart_total'   => round($cart->total_amount, 2),
                'cart_subtotal' => round($cart->subtotal_amount, 2),
                'cart_tax'     => round($cart->tax_amount, 2),
                'cart_id'      => $cart->id,
                ''
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

        // Get the cart header
        $cartHeader = Cart::find($carts_id);

        // Calculate the item's amounts
        $itemTotal = $cart->extended_price;
        $itemTax   = ($cart->shelf_price - $cart->unit_price) * $cart->quantity_foreign;
        $itemSubtotal = $cart->unit_price * $cart->quantity_foreign;

        // Remove the cart detail
        $cart->delete();

        // Check if there are remaining items
        $remainingItems = CartDetail::where('carts_id', $carts_id)->count();

        if ($cartHeader) {
            if ($remainingItems === 0) {
                // If last item, reset totals but keep the cart header
                $cartHeader->total_amount = 0;
                $cartHeader->subtotal_amount = 0;
                $cartHeader->tax_amount = 0;
                $cartHeader->save();
            } else {
                // Otherwise, subtract the removed item's amounts
                $cartHeader->total_amount    = max(0, $cartHeader->total_amount - $itemTotal);
                $cartHeader->subtotal_amount = max(0, $cartHeader->subtotal_amount - $itemSubtotal);
                $cartHeader->tax_amount      = max(0, $cartHeader->tax_amount - $itemTax);
                $cartHeader->save();
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()->back()->with('success', __('cart.removed'));
    }

    public function checkout()
    {
        $customerId = auth('customer')->id();

        $cart = Cart::where('customers_id', $customerId)
            ->with('cartDetails')
            ->first();

        $total = $cart->total_amount;
        $subtotal = $cart->subtotal_amount;
        $totalTax = $cart->tax_amount;
        $addresses = Address::where('customers_id', $customerId)->get();
        $governorates = Governorate::all();
        $districts = District::all();
        $cities = City::all();

        return view('sanita.cart.checkout', compact('cart', 'addresses', 
        'subtotal', 'totalTax', 'total', 'governorates', 'districts', 'cities'));
    }
}
