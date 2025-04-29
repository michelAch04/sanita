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
            $request->validate([
                'name' => 'required|string|max:255',
                'hidden' => 'required|boolean',
            ]);

            $category = Category::create($request->only(['name', 'hidden']));

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = $category->id . '.' . $extension;
                $image->storeAs('categories', $imageName, 'public');
                $category->update(['image' => $imageName, 'extension' => $extension]);
            }

            return redirect()->route('categories.index')->with('success', 'Category created successfully.');
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

    public function update(Request $request, Category $category)
    {
        try {
            if ($category->cancelled == 1) {
                return redirect()->route('categories.index')->with('error', 'This category is cancelled and cannot be updated.');
            }

            $request->validate([
                'name' => 'required|string|max:255',
                'hidden' => 'required|boolean',
            ]);

            $category->update($request->only(['name', 'hidden']));

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = $category->id . '.' . $extension;
                $image->storeAs('categories', $imageName, 'public');
                $category->update(['image' => $imageName, 'extension' => $extension]);
            }

            return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('categories.edit', $category->id)->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    public function destroy(Category $category)
    {
        try {
            if ($category->cancelled == 1) {
                return redirect()->route('categories.index')->with('error', 'This category is already cancelled.');
            }

            $category->update(['cancelled' => 1]);

            return redirect()->route('categories.index')->with('success', 'Category cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Failed to cancel category: ' . $e->getMessage());
        }
    }
}
