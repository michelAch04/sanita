<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\CartDetail;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\PromoCode;
use App\Models\PromoCodeUsage;

class WebsiteOrderController extends Controller
{


    public function placeOrder(Request $request)
    {
        $customerId = auth('customer')->id();

        $cart = Cart::with('cartDetails.product.distributorStocks')->where('customers_id', $customerId)->first();

        if (!$cart || $cart->cartDetails->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        foreach ($cart->cartDetails as $item) {
            $stock = $item->product->distributorStocks()->first();
            if ($stock) {
                $stock->stock = max(0, $stock->stock - $item->quantity_primary);
                $stock->save();
            }
        }

        $firstItem = $cart->cartDetails->first();
        $distributorStock = $firstItem->product->distributorStocks()->first();
        $distributorId = $distributorStock ? $distributorStock->distributors_id : null;

        $totalAmount = $cart->total_amount;
        $totalAmountAfterDiscount = $cart->total_amount_after_discount ?: $totalAmount;
        $discountAmount = $cart->discount_amount ?? ($totalAmount - $totalAmountAfterDiscount);
        $discountPercentage = $cart->discount_percentage ?? null;
        $promoCodeInput = $request->promo_code;

        // Optional: fetch the promo code instance
        $promo = null;
        if ($promoCodeInput) {
            $promo = PromoCode::where('code', $promoCodeInput)->first();
        }

        // Create order
        $order = Order::create([
            'customers_id' => $customerId,
            'distributors_id' => $distributorId,
            'addresses_id' => $request->address_id,
            'statuses_id' => 1,
            'payment_method' => $request->payment_method,
            'promocode' => $promoCodeInput,

            'subtotal_amount' => $cart->subtotal_amount,
            'tax_amount' => $cart->tax_amount,
            'total_amount' => $totalAmount,
            'total_amount_after_discount' => $totalAmountAfterDiscount,
            'discount_amount' => $discountAmount,
            'discount_percentage' => $discountPercentage,
        ]);

        foreach ($cart->cartDetails as $item) {
            OrderDetail::create([
                'orders_id' => $order->id,
                'products_id' => $item->products_id,
                'unit_price' => $item->unit_price,
                'shelf_price' => $item->shelf_price,
                'old_price' => $item->old_price,
                'extended_price' => $item->extended_price,
                'quantity_primary' => $item->quantity_primary,
                'quantity_foreign' => $item->quantity_foreign,
                'UOM' => $item->UOM,
            ]);
        }

        // Track promo usage
        if ($promo) {
            $usage = PromoCodeUsage::firstOrNew([
                'promo_codes_id' => $promo->id,
                'customers_id' => $customerId,
            ]);

            $usage->count = ($usage->count ?? 0) + 1;
            $usage->save();

            $promo->increment('used_count');
        }

        // Clear cart
        $cart->cartDetails()->delete();
        $cart->update([
            'total_amount' => 0,
            'subtotal_amount' => 0,
            'tax_amount' => 0,
            'total_amount_after_discount' => 0,
            'discount_amount' => 0,
            'discount_percentage' => null,
        ]);

        return redirect()->route('website.orders.index', ['locale' => app()->getLocale()])
            ->with('success', 'Order placed successfully!');
    }


    public function index()
    {
        $orders = Order::with('orderDetails.product')
            ->with('customer.addresses')
            ->where('cancelled', 0)
            ->where('customers_id', auth('customer')->id())
            ->orderByDesc('created_at')
            ->get();

        return view('sanita.orders.index', compact('orders'));
    }

    public function show($locale, $id)
    {
        $order = Order::with([
            'orderDetails.product',
            'customer.addresses.governorate',
            'customer.addresses.city',
            'customer.addresses.district'
        ])
            ->where('id', $id)
            ->where('customers_id', auth('customer')->id())
            ->firstOrFail();

        return view('sanita.orders.show', compact('order'));
    }



    public function reorder($locale, $id)
    {
        $order = Order::with(['orderDetails.product.listPrices'])->where('id', $id)
            ->where('customers_id', auth('customer')->id())
            ->firstOrFail();

        $customerId = $order->customers_id;


        DB::transaction(function () use ($order, $customerId) {
            $cart = Cart::firstOrCreate(
                ['customers_id' => $customerId],
                ['created_at' => now(), 'updated_at' => now()]
            );

            // Clear existing cart items if any
            $hasItems = CartDetail::where('carts_id', $cart->id)->exists();
            if ($hasItems) {
                CartDetail::where('carts_id', $cart->id)->delete();

                $cart->update([
                    'subtotal_amount' => 0,
                    'tax_amount' => 0,
                    'total_amount' => 0,
                ]);
            }

            // Re-add order items to the cart
            foreach ($order->orderDetails as $item) {
                $product = $item->product;
                $customertype = $order->customer->type;

                $listPrice = $product->listPrices
                    ->where('UOM', $item->UOM)
                    ->where('type', $customertype)
                    ->first();

                if (!$listPrice) {
                    continue;
                }

                $extendedPrice = $listPrice->shelf_price * $item->quantity_foreign;

                CartDetail::create([
                    'carts_id' => $cart->id,
                    'products_id' => $item->products_id,
                    'quantity_primary' => $item->quantity_primary,
                    'quantity_foreign' => $item->quantity_foreign,
                    'UOM' => $item->UOM,
                    'unit_price' => $listPrice->unit_price,
                    'shelf_price' => $listPrice->shelf_price,
                    'old_price' => $item->old_price,
                    'extended_price' => $extendedPrice,
                ]);
            }

            // Now calculate totals after all items are added
            $cartDetails = CartDetail::where('carts_id', $cart->id)->get();

            $subtotal = $cartDetails->sum(function ($detail) {
                return $detail->unit_price * $detail->quantity_foreign;
            });

            $totalAmount = $cartDetails->sum(function ($detail) {
                return $detail->shelf_price * $detail->quantity_foreign;
            });

            $taxAmount = $totalAmount - $subtotal;

            $cart->update([
                'subtotal_amount' => round($subtotal, 2),
                'tax_amount' => round($taxAmount, 2),
                'total_amount' => round($totalAmount, 2),
            ]);
        });
        return redirect()->route('website.cart.index', ['locale' => $locale])->with('success', 'Order items have been added to your cart.');
    }
}
