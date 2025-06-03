<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::where('cancelled', 0)->get(); // Only fetch non-cancelled categories
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
            $validate = $request->validate([
                'name' => 'required|string|max:255',
                'hidden' => 'required|boolean',
                'image' => 'nullable|mimes:jpg,jpeg,png,gif,svg|max:2048' // Only allow safe image types
            ]);

            $extension = $request->image->extension();

            $category = Category::create([
                'name' => $validate['name'],
                'extension' => $extension,
                'hidden' => $validate['hidden'],
                'cancelled' => 0,
            ]);

            // Save the image with the slideshow ID as the file name
            $imageName = $category->id . '.' . $category->extension;
            // dd($imageName);
            $request->image->move(public_path('storage/categories'), $imageName);

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
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hidden' => 'required|boolean',
        ]);


        $category->name = $validatedData['name'];
        $category->hidden = $validatedData['hidden'];

        if ($request->hasFile('image')) {
            // Define old and new (archive) paths
            $oldPath = public_path('storage/slideshow/' . $category->id . '.' . $category->extension);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $extension = $request->image->extension();
            $imageName = $category->id . '.' . $extension;
            $request->image->move(public_path('storage/categories'), $imageName);

            $category->extension = $extension;
        }
        $category->save();

        return redirect()->route('categories.index')->with('success', 'categories updated successfully.');
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


        dd($category->update(['cancelled' => 1]));
        dd($category);

        return redirect()->route('categories.index')->with('success', 'categories deleted successfully.');
    }
}
