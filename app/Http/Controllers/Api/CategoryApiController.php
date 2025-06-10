<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('cancelled', 0)
            ->orderBy('name')
            ->get(['id', 'name', 'hidden']);
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categoriesData = $request->input('message');
        $createdCategories = [];

        foreach ($categoriesData as $data) {
            $validated = validator($data, [
                'name' => 'required|string|max:255|unique:categories,name',
                'extension' => 'nullable|string|max:10',
            ])->validate();

            $category = Category::create([
                'name' => $validated['name'],
                'hidden' => $data['hidden'] ?? 0,
                'extension' => $validated['extension'] ?? 'png',
                'cancelled' => 0,
            ]);

            $createdCategories[] = $category;
        }

        return response()->json($createdCategories, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
