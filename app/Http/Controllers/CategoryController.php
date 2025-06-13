<?php

namespace App\Http\Controllers;

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

            $categories = $query->where('cancelled', 0)->get();

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
        return view('cms.categories.create');
    }

    public function store(Request $request)
    {
        try {
            // Checkbox value: visible = 1 (checked), not present if unchecked
            // So we invert it to store 'hidden' in DB
            $hidden = $request->has('visible') ? 0 : 1;

            $validate = $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'name_ku' => 'required|string|max:255',
                'position' => 'nullable|integer|min:0',
                'image' => 'nullable|mimes:jpg,jpeg,png,gif,svg|max:2048',
            ]);

            $extension = null;

            $category = Category::create([
                'name_en' => $validate['name_en'],
                'name_ar' => $validate['name_ar'],
                'name_ku' => $validate['name_ku'],
                'position' => $validate['position'],
                'extension' => null,
                'hidden' => $hidden,
                'cancelled' => 0,
            ]);

            if ($request->hasFile('image')) {
                $extension = $request->file('image')->extension();
                $imageName = $category->id . '.' . $extension;
                $request->file('image')->move(public_path('storage/categories'), $imageName);

                // Update category with extension
                $category->update(['extension' => $extension]);
            }

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

            return view('cms.categories.edit', compact('category'));
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Failed to fetch category: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_ku' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'visible' => 'required|boolean',
        ]);

        $category->name_en = $validatedData['name_en'];
        $category->name_ar = $validatedData['name_ar'];
        $category->name_ku = $validatedData['name_ku'];
        $category->hidden = !$validatedData['visible']; // invert visible to store hidden

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
        dd($category);
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $oldPath = public_path('storage/categories/' . $category->id . '.' . $category->extension);
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }


        $category->update(['cancelled' => 1]);

        return redirect()->route('categories.index')->with('success', 'categories deleted successfully.');
    }
}
