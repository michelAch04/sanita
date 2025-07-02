<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;

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
        $validate = $request->validate([
            'textarea_en' => 'nullable|string',
            'textarea_ar' => 'nullable|string',
            'textarea_ku' => 'nullable|string',
        ]);

        $aboutUs = AboutUs::first();

        if ($aboutUs) {
            // Update existing record
            $aboutUs->textarea_en = $request->input('textarea_en');
            $aboutUs->textarea_ar = $request->input('textarea_ar');
            $aboutUs->textarea_ku = $request->input('textarea_ku');
            $aboutUs->save();
        } else {
            // Create new record
            AboutUs::create($validate);
        }

        return redirect()->back()->with('success', 'About Us updated successfully!');
    }
}
