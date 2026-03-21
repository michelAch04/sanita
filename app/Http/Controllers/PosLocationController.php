<?php

namespace App\Http\Controllers;

use App\Models\PosLocation;
use App\Models\Address;

class PosLocationController extends Controller
{
    public function index()
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
                ->with('city') // load city relation if needed
                ->first();

            if ($defaultAddress && $defaultAddress->city) {
                $defaultLat = $defaultAddress->city->lat ?? $defaultLat;
                $defaultLng = $defaultAddress->city->long ?? $defaultLng;
                $zoom = 12; // closer zoom for city
            }
        }

        // Get all POS locations
        $locations = PosLocation::all();

        // Show list view if no location has coordinates yet; switch to map when they do
        $hasCoords = $locations->contains(fn($l) => $l->latitude != null && $l->longitude != null);
        $view = $hasCoords ? 'sanita.pos.index' : 'sanita.pos.list';

        return view($view, compact('locations', 'defaultLat', 'defaultLng', 'zoom'));
    }
}
