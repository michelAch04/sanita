<?php

namespace App\Http\Controllers;

use App\Models\PosLocation;
use App\Models\Address;
use Illuminate\Http\Request;

class PosLocationController extends Controller
{
    public function index(Request $request)
    {
        // Get signed-in customer
        $customer = auth('customer')->user();

        // Default map center coordinates (fallback)
        $defaultLat = 33.3128; // Baghdad center
        $defaultLng = 44.3615;
        $zoom = 6;

        // Try to get the customer's default city address
        if ($customer) {
            $defaultAddress = Address::where('customers_id', $customer->id)
                ->where('is_default', 1)
                ->with('city')
                ->first();

            if ($defaultAddress && $defaultAddress->city) {
                $defaultLat = $defaultAddress->city->lat ?? $defaultLat;
                $defaultLng = $defaultAddress->city->long ?? $defaultLng;
                $zoom = 12;
            }
        }

        // Show map view if any location has coordinates
        $hasCoords = PosLocation::whereNotNull('latitude')->whereNotNull('longitude')->exists();

        if ($hasCoords) {
            $locations = PosLocation::all();
            return view('sanita.pos.index', compact('locations', 'defaultLat', 'defaultLng', 'zoom'));
        }

        // Build list query with optional city filter
        $query = PosLocation::with('city');
        $cityFilter = $request->get('city');
        if ($cityFilter) {
            $query->where('cities_id', $cityFilter);
        }
        $locations = $query->paginate(30)->withQueryString();

        // City chips — only if at least one location has a city assigned
        $cityCounts = PosLocation::with('city')
            ->whereNotNull('cities_id')
            ->selectRaw('cities_id, count(*) as total')
            ->groupBy('cities_id')
            ->get();

        return view('sanita.pos.list', compact('locations', 'defaultLat', 'defaultLng', 'zoom', 'cityCounts', 'cityFilter'));
    }
}
