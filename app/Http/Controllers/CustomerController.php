<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Customer::query();

            if ($request->filled('query')) {
                $search = $request->query('query');

                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "{$search}%")
                        ->orWhere('first_name', 'like', "{$search}%")
                        ->orWhere('last_name', 'like', "{$search}%")
                        ->orWhere('email', 'like', "{$search}%")
                        ->orWhere('mobile', 'like', "{$search}%");
                });
            }

            $customers = $query->where('cancelled', 0)->get();

            if ($request->ajax()) {
                return view('cms.customers.index', compact('customers'))->renderSections()['customers_list'];
            }

            return view('cms.customers.index', compact('customers'));
        } catch (\Exception $e) {
            return redirect()->route('customers.index')->with('error', 'Failed to fetch customers: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('cms.customers.create');
        } catch (\Exception $e) {
            return redirect()->route('customers.index')->with('error', 'Failed to load create customer page: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'dob' => 'required|date',
                'gender' => 'required|string|max:10',
                'password' => 'required|string|min:8',
                'mobile' => 'required|string|max:15',
                'email' => 'required|email|unique:customers,email',
            ]);

            Customer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'password' => bcrypt($request->password),
                'mobile' => $request->mobile,
                'email' => $request->email,
            ]);

            return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('customers.create')->with('error', 'Failed to create customer: ' . $e->getMessage());
        }
    }

    public function edit(Customer $customer)
    {
        try {
            return view('cms.customers.edit', compact('customer'));
        } catch (\Exception $e) {
            return redirect()->route('customers.index')->with('error', 'Failed to load edit customer page: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Customer $customer)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'dob' => 'required|date',
                'password' => 'nullable|string|min:8',
                'mobile' => 'required|string|max:15',
                'email' => 'required|email|unique:customers,email,' . $customer->id,
            ]);

            $data = $request->only(['first_name', 'last_name', 'dob', 'mobile', 'email']);
            $data['DOB'] = $data['dob']; // Map it to match DB column
            unset($data['dob']);

            // Gender toggle logic
            $data['gender'] = $request->has('gender') ? 'male' : 'female';


            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $customer->update($data);

            return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('customers.edit', $customer->id)->with('error', 'Failed to update customer: ' . $e->getMessage());
        }
    }


    public function destroy(Customer $customer)
    {
        try {
            $customer->update(['cancelled' => 1]);
            return redirect()->route('customers.index')->with('success', 'Customer cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()->route('customers.index')->with('error', 'Failed to cancel customer: ' . $e->getMessage());
        }
    }
}
