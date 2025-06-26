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
    public function index()
    {
        $distributors = Distributor::with(['stocks', 'addresses'])->get();
        return view('cms.distributors.index', compact('distributors'));
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
        $distributor = Distributor::with(['addresses.city'])->findOrFail($id);

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
}
