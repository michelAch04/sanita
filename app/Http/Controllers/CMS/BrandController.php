<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\Category;
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
                    $q->where('name_en', 'like', "%$search%");
                });
            }

            $brands = $query->where('cancelled', 0)->get();

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
        $categories = Category::where('cancelled', 0)->where('hidden', 0)->orderBy('name_en')->get();
        return view('cms.brands.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255|unique:brands,name_en',
            'name_ar' => 'required|string|max:255|unique:brands,name_ar',
            'name_ku' => 'required|string|max:255|unique:brands,name_ku',
            'visible' => 'nullable|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        try {
            $isHidden = $request->has('visible') ? 0 : 1;

            $brand = Brand::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'name_ku' => $request->name_ku,
                'hidden' => $isHidden,
                'extension' => 'png',
                'cancelled' => 0,
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = $brand->id . '.' . $extension;
                $image->storeAs('brands', $imageName, 'public');

                $brand->update(['extension' => $extension]);
            }

            $brand->categories()->sync($request->input('categories', []));

            return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('brands.create')->with('error', 'Failed to create brand: ' . $e->getMessage());
        }
    }


    public function edit(Brand $brand)
    {
        $categories = Category::where('cancelled', 0)->where('hidden', 0)->orderBy('name_en')->get();
        $selectedCategories = $brand->categories->pluck('id')->toArray();
        return view('cms.brands.edit', compact('brand', 'categories', 'selectedCategories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_ku' => 'required|string|max:255',
            'visible' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        try {
            $brand = Brand::findOrFail($id);

            $hidden = $request->has('visible') ? 0 : 1;

            $brand->update([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'name_ku' => $request->name_ku,
                'hidden' => $hidden,
            ]);

            if ($request->hasFile('image')) {
                $oldPath = public_path('storage/brands/' . $brand->id . '.' . $brand->extension);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = $brand->id . '.' . $extension;
                $image->move(public_path('storage/brands'), $imageName);

                $brand->update(['extension' => $extension]);
            }

            $brand->categories()->sync($request->input('categories', []));

            return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('brands.edit', $id)->with('error', 'Failed to update brand: ' . $e->getMessage());
        }
    }


    public function destroy(Brand $brand)
    {
        try {
            $oldPath = public_path('storage/brands/' . $brand->id . '.' . $brand->extension);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $brand->update(['cancelled' => 1]);

            return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('brands.index')->with('error', 'Failed to delete brand: ' . $e->getMessage());
        }
    }
}
