<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distributor;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = Distributor::with(['stocks', 'addresses'])->get();
        return view('cms.distributors.index', compact('distributors'));
    }

    public function create()
    {
        return view('cms.distributors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
        ]);

        Distributor::create($validated);

        return redirect()->route('distributor.index')->with('success', 'Distributor created successfully.');
    }

    public function edit(Distributor $distributor)
    {
        return view('cms.distributors.edit', compact('distributor'));
    }

    public function update(Request $request, Distributor $distributor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
        ]);

        $distributor->update($validated);

        return redirect()->route('distributor.index')->with('success', 'Distributor updated successfully.');
    }
}
