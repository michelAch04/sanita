<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Cart, CartDetail, Product, Tax, Address, Governorate, City, District, Customer};

class WebsiteCartController extends Controller
{
    public function index()
    {
        $cart = $this->getCartWithDetails();

        // Check and update any outdated prices
        if ($cart && $cart->cartDetails) {
            foreach ($cart->cartDetails as $detail) {
                $this->updateCartDetailPrice($detail);
            }

            $this->recalculateCartTotals($cart);
        }

        return view('sanita.cart.index', compact('cart'));
    }


    public function store(Request $request)
    {
        try {
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

            $product_id = $request->input('product_id');
            $quantity   = max(1, (int)$request->input('quantity'));
            $unit       = $request->input('unit', 'EA');
            $ea_ca      = (int) $request->input('ea_ca', 1);
            $ea_pl      = (int) $request->input('ea_pl', 1);
            $customerId = auth('customer')->id();

            $product = Product::with(['listPrices' => function ($q) use ($request) {
                $q->where('type', $request->input('type'));
            }, 'distributorStocks' => function ($q) {
                $q->where('stock', '>', 0);
            }])->findOrFail($product_id);

            $latestPrice = $product->listPrices()->where('UOM', $unit)->where('type', $request->input('type'))->orderByDesc('id')->first();

            $unitPrice = $latestPrice->unit_price ?? $request->input('unit_price');
            $shelfPrice = $latestPrice->shelf_price ?? $request->input('shelf_price');
            $oldPrice = $latestPrice->old_price ?? $request->input('old_price', 0);

            // Always update the shelf price in the request context to reflect the current value
            $request->merge(['shelf_price' => $shelfPrice]);

            $extendedPrice = $shelfPrice * $quantity;
            $requestedQuantityEA = $this->convertToEA($quantity, $unit, $ea_ca, $ea_pl);

            $cart = $this->getOrCreateCart($customerId);
            $cartDetail = $this->getCartDetail($cart->id, $product->id, $unit);

            $alreadyInCartEA = $cartDetail->quantity_primary ?? 0;
            $totalRequestedEA = $requestedQuantityEA + $alreadyInCartEA;

            if (!$this->hasEnoughStock($product, $totalRequestedEA)) {
                return response()->json([
                    'success' => false,
                    'message' => 'الكمية المطلوبة غير متوفرة في المخزون.',
                    'stock' => $product->distributorStocks->sum('stock'),
                    'requested_quantity' => $totalRequestedEA,
                ], 422);
            }

            $cart->increment('total_amount', $extendedPrice);
            $cart->increment('subtotal_amount', $unitPrice * $quantity);
            $cart->increment('tax_amount', ($shelfPrice - $unitPrice) * $quantity);

            if ($cartDetail) {
                $cartDetail->increment('quantity_primary', $requestedQuantityEA);
                $cartDetail->increment('quantity_foreign', $quantity);
                $cartDetail->increment('extended_price', $extendedPrice);
                $cartDetail->unit_price = $unitPrice;
                $cartDetail->shelf_price = $shelfPrice;
                $cartDetail->old_price = $oldPrice;
                $cartDetail->save();
            } else {
                CartDetail::create([
                    'carts_id' => $cart->id,
                    'products_id' => $product->id,
                    'quantity_primary' => $requestedQuantityEA,
                    'quantity_foreign' => $quantity,
                    'UOM' => $unit,
                    'unit_price' => $unitPrice,
                    'shelf_price' => $shelfPrice,
                    'old_price' => $oldPrice,
                    'extended_price' => $extendedPrice,
                ]);
            }

            return response()->json([
                'success' => true,
                'cart_id' => $cart->id,
                'product' => $product,
                'quantity_ea' => $quantity,
                'unit' => $unit,
                'item_total' => round($extendedPrice, 2),
                'cart_total' => round($cart->total_amount, 2),
                'cart_subtotal' => round($cart->subtotal_amount, 2),
                'cart_tax' => round($cart->tax_amount, 2),
            ]);
        } catch (\Exception $e) {
            \Log::error('Cart store error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $locale, CartDetail $cartDetail)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            $newForeignQuantity = (int) $request->input('quantity');
            $unit = $cartDetail->UOM;

            $product = Product::with(['distributorStocks', 'listPrices'])->find($cartDetail->products_id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير موجود.',
                ]);
            }

            $type = auth('customer')->user()->type;
            $latestPrice = $product->listPrices()->where('UOM', $unit)->where('type', $type)->orderByDesc('id')->first();

            if (!$latestPrice) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم العثور على التسعيرة المناسبة لهذا المنتج.',
                ]);
            }

            $ea_ca = (int) $product->ea_ca ?: 1;
            $ea_pl = (int) $product->ea_pl ?: 1;
            $newPrimaryQuantity = $this->convertToEA($newForeignQuantity, $unit, $ea_ca, $ea_pl);

            $minQty = (int) $latestPrice->min_quantity_to_order;
            $maxQty = (int) $latestPrice->max_quantity_to_order;
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

            $cartModel = $cartDetail->cart;

            $otherItemsEA = $cartModel->cartDetails()
                ->where('id', '!=', $cartDetail->id)
                ->sum('quantity_primary');

            $totalRequestedEA = $otherItemsEA + $newPrimaryQuantity;
            $totalStockEA = $product->distributorStocks->sum('stock');

            if ($totalRequestedEA > $totalStockEA) {
                return response()->json([
                    'success' => true,
                    'message' => 'الكمية المطلوبة غير متوفرة في المخزون.',
                    'stock' => $totalStockEA,
                    'requested_quantity' => $totalRequestedEA,
                ]);
            }

            $cartDetail->quantity_foreign = $newForeignQuantity;
            $cartDetail->quantity_primary = $newPrimaryQuantity;
            $cartDetail->unit_price = $latestPrice->unit_price;
            $cartDetail->shelf_price = $latestPrice->shelf_price;
            $cartDetail->old_price = $latestPrice->old_price;
            $cartDetail->extended_price = $latestPrice->shelf_price * $newForeignQuantity;
            $cartDetail->save();

            $this->recalculateCartTotals($cartModel);

            return response()->json([
                'success' => true,
                'quantity' => $newForeignQuantity,
                'item_total' => round($cartDetail->extended_price, 2),
                'cart_total' => round($cartModel->total_amount, 2),
                'cart_subtotal' => round($cartModel->subtotal_amount, 2),
                'cart_tax' => round($cartModel->tax_amount, 2),
            ]);
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
        $cartHeader = $cart->cart;
        $itemTotal = $cart->extended_price;
        $itemTax = ($cart->shelf_price - $cart->unit_price) * $cart->quantity_foreign;
        $itemSubtotal = $cart->unit_price * $cart->quantity_foreign;

        $cart->delete();

        if ($cartHeader->cartDetails()->count() === 0) {
            $cartHeader->update(['total_amount' => 0, 'subtotal_amount' => 0, 'tax_amount' => 0]);
        } else {
            $cartHeader->decrement('total_amount', $itemTotal);
            $cartHeader->decrement('subtotal_amount', $itemSubtotal);
            $cartHeader->decrement('tax_amount', $itemTax);
        }

        return $request->ajax() ? response()->json(['success' => true]) : redirect()->back()->with('success', __('cart.removed'));
    }

    public function checkout()
    {
        $customerId = auth('customer')->id();
        $cart = Cart::with('cartDetails')->where('customers_id', $customerId)->first();
        $addresses = Address::where('customers_id', $customerId)->get();

        return view('sanita.cart.checkout', [
            'cart' => $cart,
            'addresses' => $addresses,
            'subtotal' => $cart->subtotal_amount,
            'totalTax' => $cart->tax_amount,
            'total' => $cart->total_amount,
            'governorates' => Governorate::all(),
            'districts' => District::all(),
            'cities' => City::all(),
        ]);
    }

    protected function updateCartDetailPrice($detail)
    {
        $product = Product::with('listPrices')->find($detail->products_id);
        if (!$product) return;

        $type = auth('customer')->user()->type;
        $latestPrice = $product->listPrices()
            ->where('UOM', $detail->UOM)
            ->where('type', $type)
            ->orderByDesc('id')
            ->first();

        if ($latestPrice && $detail->shelf_price != $latestPrice->shelf_price) {
            $detail->shelf_price = $latestPrice->shelf_price;
            $detail->unit_price = $latestPrice->unit_price;
            $detail->old_price = $latestPrice->old_price;
            $detail->extended_price = $latestPrice->shelf_price * $detail->quantity_foreign;
            $detail->save();
        }
    }

    protected function recalculateCartTotals($cart)
    {
        $cart->subtotal_amount = $cart->cartDetails->sum(
            fn($item) => $item->unit_price * $item->quantity_foreign
        );

        $cart->tax_amount = $cart->cartDetails->sum(
            fn($item) => ($item->shelf_price - $item->unit_price) * $item->quantity_foreign
        );

        $cart->total_amount = $cart->subtotal_amount + $cart->tax_amount;
        $cart->save();
    }


    protected function getCartWithDetails()
    {
        $customerId = auth('customer')->id();
        return Cart::with('cartDetails')->where('customers_id', $customerId)->first();
    }

    protected function convertToEA($quantity, $unit, $ea_ca, $ea_pl)
    {
        return match ($unit) {
            'CA' => $quantity * $ea_ca,
            'PL' => $quantity * $ea_pl,
            default => $quantity,
        };
    }

    protected function hasEnoughStock(Product $product, int $requestedEA): bool
    {
        return $requestedEA <= $product->distributorStocks->sum('stock');
    }

    protected function getOrCreateCart($customerId)
    {
        return Cart::firstOrCreate(
            ['customers_id' => $customerId],
            ['total_amount' => 0, 'subtotal_amount' => 0, 'tax_amount' => 0]
        );
    }

    protected function getCartDetail($cartId, $productId, $unit)
    {
        return CartDetail::where(compact('cartId', 'productId'))->where('UOM', $unit)->first();
    }

    protected function isPriceChanged($shelf_price, Product $product, $unit)
    {
        $type = auth('customer')->user()->type;
        $latestPrice = $product->listPrices()->where('UOM', $unit)->where('type', $type)->orderByDesc('id')->first();

        if ($latestPrice) {
            return [$shelf_price != $latestPrice->shelf_price, $latestPrice->shelf_price];
        }

        return [false, $shelf_price];
    }
}
