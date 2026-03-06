<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Category::query();

            if ($request->filled('query')) {
                $search = $request->query('query');

                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "{$search}%")
                        ->orWhere('name_en', 'like', "{$search}%");
                });
            }

            $categories = $query->where('cancelled', 0)->orderBy('position')->get();

            if ($request->ajax()) {
                return view('cms.categories.index', compact('categories'))->renderSections()['categories_list'];
            }

            return view('cms.categories.index', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Failed to fetch categories: ' . $e->getMessage());
        }
    }


    public function create()
    {
        $brands = Brand::where('cancelled', 0)->where('hidden', 0)->orderBy('name_en')->get();
        return view('cms.categories.create', compact('brands'));
    }

    public function store(Request $request)
    {
        try {
            $hidden = $request->has('visible') ? 0 : 1;

            $validate = $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'name_ku' => 'required|string|max:255',
                'image' => 'nullable|mimes:jpg,jpeg,png,gif,svg',
                'dominance' => 'required|in:height,width,none',
                'brands' => 'nullable|array',
                'brands.*' => 'exists:brands,id',
            ]);

            $extension = null;

            $category = Category::create([
                'name_en' => $validate['name_en'],
                'name_ar' => $validate['name_ar'],
                'name_ku' => $validate['name_ku'],
                'position' => 999,
                'extension' => null,
                'hidden' => $hidden,
                'cancelled' => 0,
                'dominance' => $validate['dominance'],
            ]);

            if ($request->hasFile('image')) {
                $extension = $request->file('image')->extension();
                $imageName = $category->id . '.' . $extension;
                $request->file('image')->move(public_path('storage/categories'), $imageName);

                $category->update(['extension' => $extension]);
            }

            $category->brands()->sync($request->input('brands', []));

            return redirect()->route('categories.index')->with('success', 'Category created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->route('categories.create')->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    public function edit(Category $category)
    {
        try {
            if ($category->cancelled == 1) {
                return redirect()->route('categories.index')->with('error', 'This category is cancelled and cannot be edited.');
            }

            $brands = Brand::where('cancelled', 0)->where('hidden', 0)->orderBy('name_en')->get();
            $selectedBrands = $category->brands->pluck('id')->toArray();

            return view('cms.categories.edit', compact('category', 'brands', 'selectedBrands'));
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Failed to fetch category: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_ku' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'visible' => 'required|boolean',
            'dominance' => 'required|in:height,width,none',
            'brands' => 'nullable|array',
            'brands.*' => 'exists:brands,id',
        ]);

        $category->name_en = $validatedData['name_en'];
        $category->name_ar = $validatedData['name_ar'];
        $category->name_ku = $validatedData['name_ku'];
        $category->hidden = !$validatedData['visible'];
        $category->dominance = $validatedData['dominance'];

        if ($request->hasFile('image')) {
            $oldPath = public_path('storage/categories/' . $category->id . '.' . $category->extension);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $extension = $request->image->extension();
            $imageName = $category->id . '.' . $extension;
            $request->image->move(public_path('storage/categories'), $imageName);

            $category->extension = $extension;
        }
        $category->save();

        $category->brands()->sync($request->input('brands', []));

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $oldPath = public_path('storage/categories/' . $category->id . '.' . $category->extension);
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }

        $category->update(['cancelled' => 1]);

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $item) {
            Category::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return response()->json(['success' => true]);
    }
}
