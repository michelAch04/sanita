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

        // Assuming you have only one about_us row (id = 1)
        AboutUs::updateOrCreate(
            ['id' => 1], // or [] if you don't have an id column
            [
                'textarea_en' => $request->input('textarea_en'),
                'textarea_ar' => $request->input('textarea_ar'),
                'textarea_ku' => $request->input('textarea_ku'),
            ]
        );

        return redirect()->back()->with('success', 'About Us updated successfully!');
    }
}
