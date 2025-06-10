<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;

class AboutUsController extends Controller
{
    public function show()
    {
        $aboutUs = AboutUs::first(); // Or your actual logic to get the about content

        return view('sanita.aboutus', compact('aboutUs'));
    }
    public function edit()
    {
        // Fetch the current "About Us" content from the database
        $aboutUs = AboutUs::first();

        return view('cms.aboutus', compact('aboutUs'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'textarea_en' => 'nullable|string',
            'textarea_ar' => 'nullable|string',
            'textarea_ku' => 'nullable|string',
        ]);

        // Assuming you have only one about_us row (id = 1)
        $aboutUs = AboutUs::firstOrFail();

        $aboutUs->textarea_en = $request->input('textarea_en');
        $aboutUs->textarea_ar = $request->input('textarea_ar');
        $aboutUs->textarea_ku = $request->input('textarea_ku');
        $aboutUs->save();

        return redirect()->back()->with('success', 'About Us updated successfully!');
    }
}
