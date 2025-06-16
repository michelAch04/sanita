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
        $addresses = Address::where('customer_id', auth('customer')->id())->where('cancelled', 0)->get();
        return view('sanita.addresses.index', compact('addresses'));
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
        // dd($request->all());
        $request->validate([
            'title' => 'nullable|string|max:255',
            'governorate' => 'required|exists:governorates,id',
            'district' => 'required|exists:districts,id',
            'city' => 'required|exists:cities,id',
            'street' => 'required|string',
            'building' => 'required|string',
            'floor' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_default' => 'boolean',
        ]);

        if ($request->is_default) {
            Address::where('customer_id', auth('customer')->id())->update(['is_default' => false]);
        }

        Address::create([
            'customer_id' => auth('customer')->id(),
            'title' => $request->title,
            'governorate_id' => $request->governorate,
            'district_id' => $request->district,
            'city_id' => $request->city,
            'street' => $request->street,
            'building' => $request->building,
            'floor' => $request->floor,
            'notes' => $request->notes,
            'is_default' => $request->is_default ?? false,
        ]);

        return redirect()->route('addresses.index', app()->getLocale())->with('success', __('Address saved.'));
    }

    public function edit($locale, Address $address)
    {
        $governorates = Governorate::all();
        $districts = District::where('governorate_id', $address->governorate_id)->get();
        $cities = City::where('district_id', $address->district_id)->get();

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
            'is_default' => 'boolean',
        ]);

        if ($request->is_default) {
            Address::where('customer_id', auth('customer')->id())->update(['is_default' => false]);
        }

        $address->update([
            'title' => $request->title,
            'governorate_id' => $request->governorate,
            'district_id' => $request->district,
            'city_id' => $request->city,
            'street' => $request->street,
            'building' => $request->building,
            'floor' => $request->floor,
            'notes' => $request->notes,
            'is_default' => $request->is_default ?? false,
        ]);

        return redirect()->route('addresses.index', app()->getLocale())->with('success', __('Address updated.'));
    }

    public function destroy($locale, Address $address)
    {
        $address->where('id', $address->id)->update(['cancelled' => 1]);

        return redirect()->route('addresses.index', $locale)->with('success', __('Address deleted.'));
    }
}
