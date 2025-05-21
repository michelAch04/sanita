<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;

class AboutUsController extends Controller
{
    public function edit()
    {
        // Fetch the current "About Us" content from the database
        $aboutUs = AboutUs::first();

        return view('cms.aboutus', compact('aboutUs'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'about_us' => 'required|string|max:5000',
        ]);

        try {
            // Update or create the "About Us" content
            $aboutUs = AboutUs::updateOrCreate(
                ['id' => 1], // Assuming there's only one "About Us" record
                [
                    'textarea' => $request->about_us,
                    'updated_at' => now(), // Set the updated_at field to the current time
                ]
            );

            // Check if the update was successful
            if ($aboutUs) {
                return redirect()->route('aboutus.edit')->with('success', 'About Us content updated successfully.');
            } else {
                return redirect()->route('aboutus.edit')->with('error', 'Failed to update About Us content.');
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            return redirect()->route('aboutus.edit')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
