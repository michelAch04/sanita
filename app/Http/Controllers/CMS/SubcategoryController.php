<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;
use Symfony\Component\Console\Logger\ConsoleLogger;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Subcategory::with('category');

            if ($request->filled('query')) {
                $search = $request->query('query');

                $query->where(function ($q) use ($search) {
                    $q->where('name_en', 'like', "{$search}%")
                        ->orWhereHas('category', fn($catQ) => $catQ->where('name_en', 'like', "{$search}%"));
                });
            }

            $subcategories = $query->where('cancelled', 0)->orderBy('position')->get();

            if ($request->ajax()) {
                return view('cms.subcategories.index', compact('subcategories'))->renderSections()['subcategories_list'];
            }

            return view('cms.subcategories.index', compact('subcategories'));
        } catch (\Exception $e) {
            return redirect()->route('subcategories.index')->with('error', 'Failed to fetch subcategories: ' . $e->getMessage());
        }
    }


    public function create()
    {
        $categories = Category::all();
        return view('cms.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categories_id' => 'required|exists:categories,id',
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_ku' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'visible' => 'nullable|boolean',
            'position' => 'nullable|integer|min:0',
        ]);

        // Determine hidden value (if checkbox checked, hidden = 0; else hidden = 1)
        $hidden = $request->has('visible') ? 0 : 1;

        // Create the subcategory
        $subcategory = Subcategory::create([
            'categories_id' => $request->categories_id,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'name_ku' => $request->name_ku,
            'hidden' => $hidden,
        ]);

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = $subcategory->id . '.' . $extension;

            $image->storeAs('subcategories', $imageName, 'public');

            $subcategory->update([
                'image' => $imageName,
                'extension' => $extension,
            ]);
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
            'categories_id' => 'required|exists:categories,id',
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_ku' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'visible' => 'nullable|boolean',
        ]);

        $hidden = $request->has('visible') ? 0 : 1;

        $subcategory->update([
            'name_en' => $request->name_en,
            'categories_id' => $request->categories_id,
            'hidden' => $hidden
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = $subcategory->id . '.' . $extension;

            $image->storeAs('subcategories', $imageName, 'public');

            $subcategory->update([
                'image' => $imageName,
                'extension' => $extension,
            ]);
        }

        return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully.');
    }


    public function destroy(Subcategory $subcategory)
    {
        $subcategory->update(['cancelled' => 1]);

        return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $item) {
            Subcategory::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return response()->json(['success' => true]);
    }
}
