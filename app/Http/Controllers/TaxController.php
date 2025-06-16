<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;

class TaxController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $taxes = Tax::where('cancelled', 0)
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->get();

        if ($request->ajax()) {
            return view('cms.tax.index', compact('taxes'))->renderSections()['tax_list'];
        }

        return view('cms.tax.index', compact('taxes'));
    }

    public function create()
    {
        return view('cms.tax.create');
    }

    public function edit($id)
    {
        // Example: fetch tax by ID
        $tax = Tax::findOrFail($id);
        return view('cms.tax.edit', compact('tax'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|between:0,100',
            'active' => 'nullable|boolean',
        ]);

        $validated['active'] = $request->has('active') ? 1 : 0;
        Tax::create($validated);

        return redirect()->route('tax.index')->with('success', 'Tax created successfully.');
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|between:0,100',
            'active' => 'nullable|boolean',
        ]);

        $tax = Tax::findOrFail($id);
        $validated['active'] = $request->has('active') ? 1 : 0;
        $tax->update($validated);
        return redirect()->route('tax.index')->with('success','Tax updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $tax = Tax::findOrFail($id);
            $tax->update(['cancelled' => 1]);
            return redirect()->route('tax.index')->with('success', 'تم حذف الضريبة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('tax.index')->with('error', 'الضريبة غير موجودة.');
        }
    }
}
