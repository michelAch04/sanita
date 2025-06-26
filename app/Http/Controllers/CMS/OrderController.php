<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Order::with('customer');

            if ($request->filled('query')) {
                $search = $request->query('query');

                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "{$search}%")
                        ->orWhereHas('customer', function ($q2) use ($search) {
                            $q2->where('first_name', 'like', "{$search}%")
                                ->orWhere('last_name', 'like', "{$search}%")
                                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["{$search}%"]);
                        });
                });
            }

            $orders = $query->where('cancelled', 0)->get();

            if ($request->ajax()) {
                return view('cms.orders.index', compact('orders'))->renderSections()['orders_list'];
            }

            return view('cms.orders.index', compact('orders'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error', 'Failed to fetch orders: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $customers = Customer::where('cancelled', 0)->get();
            $carts = Cart::all(); // ← add this line to fetch all carts
            return view('cms.orders.create', compact('customers', 'carts'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error', 'Failed to fetch customers: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'customers_id' => 'required|exists:customers,id',
                'carts_id' => 'required|exists:carts,id',        // <-- add cart validation
                'status' => 'required|string|max:255',
                'total_amount' => 'required|numeric|min:0',
            ]);

            Order::create($request->only(['customers_id', 'carts_id', 'status', 'total_amount'])); // <-- add carts_id here

            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('orders.create')->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Order $order)
    {
        try {
            if ($order->cancelled == 1) {
                return redirect()->route('orders.index')->with('error', 'This order is cancelled and cannot be edited.');
            }

            $customers = Customer::where('cancelled', 0)->get();
            return view('cms.orders.edit', compact('order', 'customers'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error', 'Failed to fetch order: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Order $order)
    {
        try {
            if ($order->cancelled == 1) {
                return redirect()->route('orders.index')->with('error', 'This order is cancelled and cannot be updated.');
            }

            $request->validate([
                'customers_id' => 'required|exists:customers,id',
                'total_amount' => 'required|numeric|min:0',
                'status' => 'required',
            ]);

            $order->update($request->only(['customers_id', 'total_amount', 'status']));

            return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('orders.edit', $order->id)->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }

    public function destroy(Order $order)
    {
        try {
            if ($order->cancelled == 1) {
                return redirect()->route('orders.index')->with('error', 'This order is already cancelled.');
            }

            $order->update(['cancelled' => 1]);

            return redirect()->route('orders.index')->with('success', 'Order cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }
}
