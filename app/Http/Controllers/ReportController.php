<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function show(Request $request)
    {
        $metric = $request->metric ?? 'customers';
        $interval = $request->interval ?? 'day';
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);

        $format = match ($interval) {
            'day' => 'F j, Y',
            'week' => '\W\e\e\k W, Y',
            'month' => 'F Y',
            'year' => 'Y',
        };

        switch ($metric) {
            case 'customers':
                $collection = Customer::whereBetween('created_at', [$start, $end])->get();
                break;
            case 'products':
                $collection = Product::whereBetween('created_at', [$start, $end])->get();
                break;
            case 'brands':
                $collection = Brand::whereBetween('created_at', [$start, $end])->get();
                break;
            case 'orders':
                $collection = Order::whereBetween('created_at', [$start, $end])->get();
                break;
            case 'categories':
                $collection = Category::whereBetween('created_at', [$start, $end])->get();
                break;
            case 'subcategories':
                $collection = Subcategory::whereBetween('created_at', [$start, $end])->get();
                break;
            case 'users':
                $collection = User::whereBetween('created_at', [$start, $end])->get();
                break;
            case 'revenue':
                $collection = Order::whereBetween('created_at', [$start, $end])->get();
                break;
            default:
                $collection = collect(); // fallback empty
        }

        $data = $collection->groupBy(function ($item) use ($interval, $format) {
            return $item->created_at->format($format);
        });

        return view('cms.report', compact('metric', 'interval', 'data'));
    }
}
