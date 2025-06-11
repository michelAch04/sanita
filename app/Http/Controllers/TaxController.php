<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;

class TaxController extends Controller
{
    public function index()
    {
        // Example: fetch all taxes
        $taxes = Tax::where('cancelled', 0)->get();
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
            'active' => 'required|boolean',
        ]);

        Tax::create($validated);

        return redirect()->route('tax.index')->with('success', 'تمت إضافة الضريبة بنجاح.');
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|between:0,100',
            'active' => 'required|boolean',
        ]);

        $tax = Tax::findOrFail($id);
        $tax->update($validated);

        return redirect()->route('tax.index')->with('success', 'تم تحديث الضريبة بنجاح.');
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
