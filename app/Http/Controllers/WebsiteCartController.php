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
        try {
            // Validate input
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            $newForeignQuantity = (int) $request->input('quantity');
            $unit = $cart->UOM;

            // Fetch product with related stocks and prices
            $product = Product::with(['distributorStocks', 'listPrices'])->find($cart->products_id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير موجود.',
                ]);
            }

            // Get related ListPrice for this type
            $listPrice = $product->listPrices->first();

            if (!$listPrice) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم العثور على التسعيرة المناسبة لهذا المنتج.',
                ]);
            }

            // Convert foreign quantity to EA
            $ea_ca = (int) $product->ea_ca ?: 1;
            $ea_pl = (int) $product->ea_pl ?: 1;
            $newPrimaryQuantity = $this->convertToEA($newForeignQuantity, $unit, $ea_ca, $ea_pl);

            // Check min/max quantity limits
            $minQty = (int) $listPrice->min_quantity_to_order;
            $maxQty = (int) $listPrice->max_quantity_to_order;
            if ($minQty > 0 && $newPrimaryQuantity < $minQty) {
                return response()->json([
                    'warning' => true,
                    'message' => "الكمية أدنى من الحد الأدنى المسموح به: {$minQty}",
                ]);
            }

            if ($maxQty > 0 && $newPrimaryQuantity > $maxQty) {
                return response()->json([
                    'warning' => true,
                    'message' => "الكمية تجاوزت الحد الأقصى المسموح به: {$maxQty}",
                ]);
            }

            // Get the parent cart
            $cartModel = $cart->cart;

            // Sum EA of all other items
            $otherItemsEA = $cartModel->cartDetails()
                ->where('id', '!=', $cart->id)
                ->sum('quantity_primary');

            $totalRequestedEA = $otherItemsEA + $newPrimaryQuantity;
            $totalStockEA = $product->distributorStocks->sum('stock');

            // Stock check
            if ($totalRequestedEA > $totalStockEA) {
                return response()->json([
                    'success' => true,
                    'message' => 'الكمية المطلوبة غير متوفرة في المخزون.',
                    'stock' => $totalStockEA,
                    'requested_quantity' => $totalRequestedEA,
                ]);
            }

            // Update cart detail
            $cart->quantity_foreign = $newForeignQuantity;
            $cart->quantity_primary = $newPrimaryQuantity;
            $cart->extended_price = $cart->shelf_price * $newForeignQuantity;
            $cart->save();

            // Recalculate totals
            $cartModel->subtotal_amount = $cartModel->cartDetails->sum(
                fn($item) => $item->unit_price * $item->quantity_foreign
            );

            $cartModel->tax_amount = $cartModel->cartDetails->sum(
                fn($item) => ($item->shelf_price - $item->unit_price) * $item->quantity_foreign
            );

            $cartModel->total_amount = $cartModel->subtotal_amount + $cartModel->tax_amount;
            $cartModel->save();

            // Return response
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'quantity' => $newForeignQuantity,
                    'item_total' => round($cart->extended_price, 2),
                    'cart_total' => round($cartModel->total_amount, 2),
                    'cart_subtotal' => round($cartModel->subtotal_amount, 2),
                    'cart_tax' => round($cartModel->tax_amount, 2),
                ]);
            }

            return redirect()->back()->with('success', __('cart.updated'));
        } catch (\Exception $e) {
            \Log::error('Cart update error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في الخادم: ' . $e->getMessage(),
            ], 500);
        }
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

        return view('sanita.cart.checkout', compact(
            'cart',
            'addresses',
            'subtotal',
            'totalTax',
            'total',
            'governorates',
            'districts',
            'cities'
        ));
    }

    public function getCartWithDetails()
    {
        $customerId = auth('customer')->id();
        return Cart::with('cartDetails')
            ->where('customers_id', $customerId)
            ->first();
    }

    /**
     * Convert requested quantity to EA based on unit.
     */
    protected function convertToEA($quantity, $unit, $ea_ca, $ea_pl)
    {
        if ($unit === 'CA') {
            return $quantity * $ea_ca;
        } elseif ($unit === 'PL') {
            return $quantity * $ea_pl;
        }
        return $quantity;
    }

    /**
     * Check if requested EA quantity is available in stock.
     */
    protected function hasEnoughStock(Product $product, int $requestedEA): bool
    {
        $totalStockEA = $product->distributorStocks->sum('stock');
        return $requestedEA <= $totalStockEA;
    }

    /**
     * Get or create the cart for the current customer.
     */
    protected function getOrCreateCart($customerId)
    {
        $cart = Cart::where('customers_id', $customerId)->first();
        if (!$cart) {
            $cart = Cart::create([
                'customers_id'   => $customerId,
                'total_amount'   => 0,
                'subtotal_amount' => 0,
                'tax_amount'     => 0,
            ]);
        }
        return $cart;
    }

    /**
     * Get cart detail for a given cart, product, and UOM.
     */
    protected function getCartDetail($cartId, $productId, $unit)
    {
        return CartDetail::where('carts_id', $cartId)
            ->where('products_id', $productId)
            ->where('UOM', $unit)
            ->first();
    }

    /**
     * Check if the price in the request matches the latest price in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param string $unit
     * @return array [bool $changed, float $latestUnitPrice, float $latestShelfPrice]
     */
    protected function isPriceChanged(Request $request, Product $product, $unit)
    {
        $latestPrice = $product->listPrices()
            ->where('UOM', $unit)
            ->where('type', $request->input('type'))
            ->orderByDesc('id')
            ->first();

        if ($latestPrice) {
            $unitPrice = $latestPrice->unit_price;
            $shelfPrice = $latestPrice->shelf_price;

            $changed = (
                $request->input('unit_price') != $unitPrice ||
                $request->input('shelf_price') != $shelfPrice
            );

            return [$changed, $unitPrice, $shelfPrice];
        }

        // If no price found, treat as not changed (or handle as needed)
        return [false, $request->input('unit_price'), $request->input('shelf_price')];
    }
}
