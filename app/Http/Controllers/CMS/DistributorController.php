<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distributor;
use App\Models\City;
use App\Models\DistributorAddress;
use App\Models\DistributorStock;
use App\Models\Product;

class DistributorController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Distributor::with(['stocks', 'addresses.city']);

            if ($request->filled('query')) {
                $search = $request->input('query');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "$search%")
                        ->orWhere('email', 'like', "$search%")
                        ->orWhere('mobile', 'like', "$search%")
                        ->orWhere('location', 'like', "$search%")
                        // Search related city name through addresses
                        ->orWhereHas('addresses.city', function ($city) use ($search) {
                            $city->where('name_en', 'like', "$search%");
                        });
                });
            }

            $distributors = $query->get();

            if ($request->ajax()) {
                // Make sure your Blade has a @section('distributors_list') for this to work
                return view('cms.distributors.index', compact('distributors'))->renderSections()['distributors_list'];
            }

            return view('cms.distributors.index', compact('distributors'));
        } catch (\Exception $e) {
            return redirect()->route('distributor.index')->with('error', 'Failed to fetch distributors: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('cms.distributors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
        ]);

        Distributor::create($validated);

        return redirect()->route('distributor.index')->with('success', 'Distributor created successfully.');
    }

    public function edit(Distributor $distributor)
    {
        return view('cms.distributors.edit', compact('distributor'));
    }

    public function update(Request $request, Distributor $distributor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
        ]);

        $distributor->update($validated);

        return redirect()->route('distributor.index')->with('success', 'Distributor updated successfully.');
    }

    public function addAddress($id)
    {
        $distributor = Distributor::with(['addresses.city.districts.governorate'])->findOrFail($id);

        // Get IDs of cities already assigned to any distributor
        $assignedCityIds = DistributorAddress::pluck('cities_id')->toArray();

        // Only get cities that are NOT assigned
        $cities = City::whereNotIn('id', $assignedCityIds)->get(['id', 'name_en']);

        return view('cms.distributors.add_address', compact('distributor', 'cities'));
    }

    public function storeAddress(Request $request, $id)
    {
        $request->validate([
            'cities_id' => 'required|exists:cities,id'
        ]);

        // Check if the city is already assigned to any distributor
        $exists = DistributorAddress::where('cities_id', $request->cities_id)->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This city is already assigned to another distributor.');
        }

        DistributorAddress::create([
            'distributors_id' => $id,
            'cities_id' => $request->cities_id
        ]);

        return redirect()->back()->with('success', 'City assigned to distributor!');
    }

    public function removeAddress($distributorId, $addressId)
    {
        try {
            $address = DistributorAddress::where('id', $addressId)
                ->where('distributors_id', $distributorId)
                ->firstOrFail();

            $address->delete();

            return redirect()->back()->with('success', 'City removed from distributor.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to remove city: ' . $e->getMessage());
        }
    }

    public function stocks($id)
    {
        $distributor = Distributor::with('stocks.product')->findOrFail($id);
        $products = Product::all();
        return view('cms.distributors.stocks', compact('distributor', 'products'));
    }

    public function storeStock(Request $request, $id)
    {
        $request->validate([
            'products_id' => 'required|exists:products,id',
            'stock' => 'required|integer|min:0',
        ]);

        DistributorStock::updateOrCreate(
            [
                'distributors_id' => $id,
                'products_id' => $request->products_id,
            ],
            [
                'stock' => $request->stock,
            ]
        );

        return redirect()->back()->with('success', 'Stock updated!');
    }

    public function removeStock($distributorId, $productId)
    {
        try {
            DistributorStock::where('distributors_id', $distributorId)
                ->where('products_id', $productId)
                ->delete();

            return redirect()->back()->with('success', 'Stock entry deleted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete stock: ' . $e->getMessage());
        }
    }
}
