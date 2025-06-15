<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartDetail;


class WebsiteCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $expired = Cart::with('cartDetails')
    ->where('customers_id', auth()->id())
    ->where('purchased', 0)
    ->where('cancelled', 0)
    ->where('expires_at', '<', now())
    ->first();

    if ($expired) {
        // Cancel the cart
        $expired->update(['cancelled' => 1]);

        // Cancel each product in cartDetails
        $expired->cartDetails()->update(['cancelled' => 1]);
        
    }
    $cart = Cart::with(['cartDetails' => function ($q) {
            $q->where('cancelled', 0);
        }])
        ->where('customers_id', auth()->id())
        ->where('purchased', 0)
        ->where('cancelled', 0)
        ->first();
                                            
        $cartCount = $cart ? $cart->cartDetails->count() : 0;

        return view('sanita.cart.index', compact('cart','cartCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        $customerId = auth()->id();

        $cart = Cart::firstOrCreate(
            ['customers_id' => $customerId, 'purchased' => 0, 'cancelled' => 0],
            ['expires_at' => now()->addHours(2)]
        );

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
                'quantity' => 1,
                'cancelled' => 0,
            ]);
        }
        return response()->json([
            'success' => true,
        ]);
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $locale, CartDetail $cart)
{
    $quantity = max(1, (int)$request->input('quantity'));
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
    // dd($cart);
    $carts_id = $cart->carts_id ; 
    // Update the Cart
    Cart::where('id', $carts_id)->update(['cancelled' => 1]);

    // Update related CartDetails
    CartDetail::where('carts_id', $carts_id)->update(['cancelled' => 1]);    


    if ($request->ajax()) {
        return response()->json(['success' => true]);
    }

    return redirect()->back()->with('success', __('cart.removed'));
}
}
