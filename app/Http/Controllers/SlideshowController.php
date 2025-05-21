<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slideshow;

class SlideshowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slideshows = Slideshow::where('cancelled', 0)->get();
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
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hidden' => 'required|boolean',
        ]);

        // Extract the file extension
        $extension = $request->image->extension();

        // Create the slideshow record
        $slideshow = Slideshow::create([
            'name' => $validatedData['name'],
            'extension' => $extension,
            'hidden' => $validatedData['hidden'],
            'cancelled' => 0,
        ]);

        // Save the image with the slideshow ID as the file name
        $imageName = $slideshow->id . '.' . $slideshow->extension;
        // dd($imageName);
        $request->image->move(public_path('storage/slideshow'), $imageName);

        // Redirect to the index page with a success message
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hidden' => 'required|boolean',
        ]);

        $slideshow->name = $validatedData['name'];
        $slideshow->hidden = $validatedData['hidden'];

        if ($request->hasFile('image')) {
            // Define old and new (archive) paths
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
}
