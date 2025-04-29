<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::where('cancelled', 0)->get(); // Fetch all brands
        return view('cms.brands.index', compact('brands'));
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        try {
            // Create the brand without the image first to get the ID
            $brand = Brand::create([
                'name' => $request->name,
                'hidden' => $request->hidden,
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
            'hidden' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image (optional)
        ]);

        try {
            $brand = Brand::findOrFail($id);

            // Update the brand's name and hidden status
            $brand->update([
                'name' => $request->name,
                'hidden' => $request->hidden,
            ]);

            // Handle the image upload if a new image is provided
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension(); // Get the file extension
                $imageName = $brand->id . '.' . $extension; // Rename the image to the ID of the record
                $image->storeAs('brands', $imageName, 'public'); // Save the image in 'storage/app/public/brands'

                // Update the brand with the new image extension
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
