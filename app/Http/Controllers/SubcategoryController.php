<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->where('cancelled', 0)->get();
        return view('cms.subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('cms.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'hidden' => 'required|boolean',
        ]);

        $subcategory = Subcategory::create($request->only(['category_id', 'name', 'hidden']));

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = $subcategory->id . '.' . $extension;
            $image->storeAs('subcategories', $imageName, 'public');
            $subcategory->update(['image' => $imageName, 'extension' => $extension]);
        }

        return redirect()->route('subcategories.index')->with('success', 'Subcategory created successfully.');
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('cms.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
        ]);

        $subcategory->update($request->only(['category_id', 'name', 'description']));

        return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully.');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->update(['cancelled' => 1]);


        return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }
}
