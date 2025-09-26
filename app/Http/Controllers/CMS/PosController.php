<?php

namespace App\Http\Controllers\CMS;

use App\Models\PosLocation;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $query = PosLocation::with('city');

        if ($request->filled('query')) {
            $search = $request->query('query');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
        }

        $posLocations = $query->orderBy('created_at', 'desc')->get();

        if ($request->ajax()) {
                return view('cms.pos_locations.index', compact('posLocations'))->renderSections()['pos_locations_list'];
        }

        return view('cms.pos_locations.index', compact('posLocations'));
    }

    public function create()
    {
        $cities = City::orderBy('name_en')->get();
        return view('cms.pos_locations.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'cities_id' => 'required|exists:cities,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        PosLocation::create($validated);

        return redirect()->route('pos_locations.index')->with('success', 'POS Location created successfully.');
    }

    public function edit(PosLocation $pos_location)
    {
        $cities = City::orderBy('name_en')->get();
        return view('cms.pos_locations.edit', ['pos' => $pos_location, 'cities' => $cities]);
    }

    public function update(Request $request, PosLocation $pos_location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'cities_id' => 'required|exists:cities,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $pos_location->update($validated);

        return redirect()->route('pos_locations.index')->with('success', 'POS Location updated successfully.');
    }

    public function destroy(PosLocation $pos_location)
    {
        $pos_location->delete();
        return redirect()->route('pos_locations.index')->with('success', 'POS Location deleted successfully.');
    }
}
