<?php
namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $last7Days = Carbon::now()->subDays(7);

        $stats = [
            'customers' => Customer::where('created_at', '>=', $last7Days)->count(),
            'products' => Product::where('created_at', '>=', $last7Days)->count(),
            'brands' => Brand::where('created_at', '>=', $last7Days)->count(),
            'orders' => Order::where('created_at', '>=', $last7Days)->count(),
            'categories' => Category::where('created_at', '>=', $last7Days)->count(),
            'subcategories' => Subcategory::where('created_at', '>=', $last7Days)->count(),
            'admins' => User::get()->count(),
            'total_amount' => Order::where('created_at', '>=', $last7Days)->sum('total_amount'),
        ];

        return view('cms.dashboard', compact('stats'));
    }
}
