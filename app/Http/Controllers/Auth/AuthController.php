<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Show sign up page
    public function showSignUp()
    {
        return view('sanita.auth.signup');
    }

    // Handle customer sign up
    public function signUp(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'DOB' => 'required|date|before:today',
                'mobile' => ['required', 'string', 'max:20', 'regex:/^\+?[0-9\s\-\(\)]+$/', 'unique:customers'],
                'gender' => 'required|in:male,female',
                'email' => 'required|email|unique:customers',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $validated['password'] = Hash::make($validated['password']);
            $customer = Customer::create($validated);
            Auth::guard('customer')->login($customer);

            return redirect('/')->with('success', 'Registration successful! You are now logged in.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Something went wrong. Please try again.'])
                ->withInput();
        }
    }

    // Show sign in page
    public function showSignIn()
    {
        return view('sanita.auth.signin');
    }

    // Handle customer sign in
    public function signIn(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            // Return a single error keyed by 'login_error'
            return back()->withErrors(['login_error' => 'Invalid credentials.'])->withInput();
        }

        // Log in the customer
        Auth::guard('customer')->login($customer);

        return redirect('/')->with('success', 'Signed in successfully!');
    }

    // Handle customer logout
    public function signOut(Request $request)
    {
        // Log out from session
        Auth::guard('customer')->logout();

        // Clear session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Signed out successfully!');
    }
}
