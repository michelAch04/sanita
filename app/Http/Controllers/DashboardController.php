<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index()
    {
        // $totalCustomers = Customer::count();
        // $totalOrders = Order::count();
        // $totalOrderValue = Order::sum('amount');
        // $orders = Order::latest()->take(10)->get(); // Fetch the latest 10 orders
        // compact('totalCustomers', 'totalOrders', 'totalOrderValue',  'orders');
        return view('cms.dashboard');
    }
}
