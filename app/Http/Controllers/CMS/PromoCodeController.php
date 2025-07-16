<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromoCode;
use App\Models\Customer;
use Carbon\Carbon;


class PromoCodeController extends Controller
{
    public function index()
    {
        $promoCodes = PromoCode::All();
        return view('cms.promocodes.index', compact('promoCodes'));
    }

    public function create()
    {
        return view('cms.promocodes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:promo_codes',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'max_uses_per_user' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        PromoCode::create($validated);

        return redirect()->route('cms.promocodes.index')->with('success', 'Promo code created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $promocode = PromoCode::findOrFail($id);
        // In your controller (before passing to view)
        $promocode->start_date = Carbon::parse($promocode->start_date);
        $promocode->end_date = Carbon::parse($promocode->end_date);
        return view('cms.promocodes.edit', compact('promocode'));
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
