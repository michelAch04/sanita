<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Brand::query();

            if ($request->filled('query')) {
                $search = $request->query('query');

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            }

            $brands = $query->get();

            if ($request->ajax()) {
                return view('cms.brands.index', compact('brands'))->renderSections()['brands_list'];
            }

            return view('cms.brands.index', compact('brands'));
        } catch (\Exception $e) {
            return redirect()->route('brands.index')->with('error', 'Failed to fetch brands: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('cms.brands.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'hidden' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        try {
            // Create the brand without the image first to get the ID
            $brand = Brand::create([
                'name' => $request->name,
                'hidden' => $request->hidden,
                'extension' => 'png',
                'cancelled' => 0,
            ]);

            // Handle the image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension(); // Get the file extension
                $imageName = $brand->id . '.' . $extension; // Rename the image to the ID of the record
                $image->storeAs('brands', $imageName, 'public'); // Save the image in 'storage/app/public/brands'

                // Update the brand with the image extension
                $brand->update([
                    'extension' => $extension,
                ]);
            }

            return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('brands.create')->with('error', 'Failed to create brand: ' . $e->getMessage());
        }
    }

    public function edit(Brand $brand)
    {
        return view('cms.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'visible' => 'nullable|boolean', // visible is the checkbox name in the form
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $brand = Brand::findOrFail($id);

            // Convert visible checkbox into hidden DB value (inverted logic)
            $hidden = $request->has('visible') ? 0 : 1;

            // Update name and hidden status
            $brand->update([
                'name' => $request->name,
                'hidden' => $hidden,
            ]);

            // Handle optional image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = $brand->id . '.' . $extension;
                $image->storeAs('brands', $imageName, 'public');

                $brand->update([
                    'extension' => $extension,
                ]);
            }

            return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('brands.edit', $id)->with('error', 'Failed to update brand: ' . $e->getMessage());
        }
    }


    public function destroy(Brand $brand)
    {
        try {
            $brand->update(['cancelled' => 1]);

            return redirect()->route('brands.index')->with('success', 'brand deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('brands.index')->with('error', 'Failed to delete brand: ' . $e->getMessage());
        }
    }
}
