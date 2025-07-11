<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slideshow;

class SlideshowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Slideshow::query();

        if ($request->filled('query')) {
            $search = $request->query('query');

            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "{$search}%")
                    ->orWhere('name', 'like', "{$search}%");
            });
        }

        $slideshows = $query->where('cancelled', 0)->orderBy('position')->get(); // ← Use the filtered query

        if ($request->ajax()) {
            $view = view('cms.slideshow.index', compact('slideshows'))->renderSections();
            return $view['slideshows_list'];
        }

        return view('cms.slideshow.index', compact('slideshows'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cms.slideshow.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ensure 'hidden' is either '0' or '1'
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:max_height=400', 
            'hidden' => 'nullable|in:0,1',
        ]);

        // If not provided, fallback to hidden = 1 (not visible)
        $hidden = $request->input('hidden', 1);

        // Extract the file extension
        $extension = $request->image->extension();

        // Create the slideshow record
        $slideshow = Slideshow::create([
            'name' => $validatedData['name'],
            'extension' => $extension,
            'hidden' => $hidden,
            'cancelled' => 0,
        ]);

        // Save the image with the slideshow ID as the file name
        $imageName = $slideshow->id . '.' . $slideshow->extension;
        $request->image->move(public_path('storage/slideshow'), $imageName);

        return redirect()->route('slideshow.index')->with('success', 'Slide added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slideshow $slideshow)
    {
        return view('cms.slideshow.edit', compact('slideshow'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slideshow $slideshow)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:max_height=400',
            'visible' => 'nullable|boolean',
        ]);

        $slideshow->name = $validatedData['name'];
        $slideshow->hidden = $request->has('visible') ? 0 : 1;

        if ($request->hasFile('image')) {
            $oldPath = public_path('storage/slideshow/' . $slideshow->id . '.' . $slideshow->extension);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $extension = $request->image->extension();
            $imageName = $slideshow->id . '.' . $extension;
            $request->image->move(public_path('storage/slideshow'), $imageName);

            $slideshow->extension = $extension;
        }

        $slideshow->save();

        return redirect()->route('slideshow.index')->with('success', 'Slide updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slideshow $slideshow)
    {
        $oldPath = public_path('storage/slideshow/' . $slideshow->id . '.' . $slideshow->extension);
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }

        // Mark the slideshow as cancelled (soft delete)
        $slideshow->update(['cancelled' => 1]);

        return redirect()->route('slideshow.index')->with('success', 'Slide deleted successfully.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $item) {
            Slideshow::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return response()->json(['success' => true]);
    }
}
