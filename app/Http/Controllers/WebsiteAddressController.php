<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Governorate;
use App\Models\City;
use App\Models\District;
use App\Models\Address;
use App\Models\Cart;

class WebsiteAddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('customers_id', auth('customer')->id())->where('cancelled', 0)->get();
        $governorates = Governorate::all();
        $districts = District::all();
        $cities = City::all();
        return view('sanita.addresses.index', compact('addresses', 'governorates', 'districts', 'cities'));
    }

    public function create()
    {
        $governorates = Governorate::all();
        $districts = District::all();
        $cities = City::all();
        return view('sanita.addresses.create', compact('governorates', 'districts', 'cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'governorate' => 'required|exists:governorates,id',
            'district' => 'required|exists:districts,id',
            'city' => 'required|exists:cities,id',
            'street' => 'required|string',
            'building' => 'required|string',
            'floor' => 'nullable|string',
            'notes' => 'nullable|string',
            // 'is_default' => 'boolean', // REMOVE THIS LINE
        ]);

        $customerId = auth('customer')->id();

        // Check if this is the user's first address
        $isFirst = !Address::where('customers_id', $customerId)->where('cancelled', 0)->exists();

        $address = Address::create([
            'customers_id' => $customerId,
            'title' => $request->title,
            'governorates_id' => $request->governorate,
            'districts_id' => $request->district,
            'cities_id' => $request->city,
            'street' => $request->street,
            'building' => $request->building,
            'floor' => $request->floor,
            'notes' => $request->notes,
            'is_default' => $isFirst, // Set to true if first address, otherwise false
        ]);

        return redirect()->route('addresses.index', app()->getLocale())->with('success', __('Address saved.'));
    }

    public function edit($locale, Address $address)
    {
        $governorates = Governorate::all();
        $districts = District::where('governorates_id', $address->governorates_id)->get();
        $cities = City::where('districts_id', $address->districts_id)->get();

        return view('sanita.addresses.edit', compact('address', 'governorates', 'districts', 'cities'));
    }

    public function update(Request $request, $locale, Address $address)
    {

        $request->validate([
            'title' => 'nullable|string|max:255',
            'governorate' => 'required|exists:governorates,id',
            'district' => 'required|exists:districts,id',
            'city' => 'required|exists:cities,id',
            'street' => 'required|string',
            'building' => 'required|string',
            'floor' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($request->is_default) {
            Address::where('customers_id', auth('customer')->id())->update(['is_default' => false]);
        }

        $address->update([
            'title' => $request->title,
            'governorates_id' => $request->governorate,
            'districts_id' => $request->district,
            'cities_id' => $request->city,
            'street' => $request->street,
            'building' => $request->building,
            'floor' => $request->floor,
            'notes' => $request->notes,
        ]);

        return redirect()->route('addresses.index', app()->getLocale())->with('success', __('Address updated.'));
    }

    public function setDefault($locale, Address $address)
    {
        $user = auth()->user();

        // Reset all to non-default
        $user->addresses()->update(['is_default' => 0]);

        // Set current one to default
        $address->update(['is_default' => 1]);

        return back()->with('success', __('Default address updated.'));
    }


    public function destroy($locale, Address $address)
    {
        $address->where('id', $address->id)->update(['cancelled' => 1]);

        return redirect()->route('addresses.index', $locale)->with('success', __('Address deleted.'));
    }

    public function getDistricts(Request $request)
    {
        return District::where('governorates_id', $request->governorate_id)->get();
    }

    public function getCities(Request $request)
    {
        return City::where('districts_id', $request->district_id)->get();
    }
}
