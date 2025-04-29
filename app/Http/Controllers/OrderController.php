<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::where('cancelled', 0)->with('customer')->get();
            return view('cms.orders.index', compact('orders'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error', 'Failed to fetch orders: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $customers = Customer::where('cancelled', 0)->get();
            return view('cms.orders.create', compact('customers'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error', 'Failed to fetch customers: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'status' => 'required|string|max:255',
                'total_price' => 'required|numeric|min:0',
            ]);

            Order::create($request->only(['customer_id', 'status', 'total_price']));

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
                'customer_id' => 'required|exists:customers,id',
                'status' => 'required|string|max:255',
                'total_price' => 'required|numeric|min:0',
            ]);

            $order->update($request->only(['customer_id', 'status', 'total_price']));

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
