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
    private function cleanPhoneNumber($number)
    {
        $number = preg_replace('/\s+/', '', $number); // remove all spaces
        $number = ltrim($number, '0');               // remove leading zeros
        return $number;
    }

    // Show sign up page
    public function showSignUp()
    {
        return view('sanita.auth.signup');
    }

    // Handle customer sign up
    public function signUp(Request $request)
    {
        $request->merge([
            'mobile' => $this->cleanPhoneNumber($request->mobile),
        ]);
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'DOB' => 'required|date|before:today',
                'mobile' => ['required', 'string', 'max:20', 'regex:/^\+?[0-9\s\-\(\)]+$/', 'unique:customers'],
                'country_code' => 'required|string|max:10',
                'gender' => 'required|in:male,female',
                'email' => 'nullable|email|unique:customers',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $validated['password'] = Hash::make($validated['password']);
            $customer = Customer::create($validated);
            Auth::guard('customer')->login($customer);

            return redirect()->route('sanita.index', ['locale' => app()->getLocale()])
                ->with('success', 'Registration successful! You are now logged in.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => $e->getMessage()])
                ->withInput();
        }
    }

    // Show sign in page
    public function showSignIn(Request $request)
    {
        if ($request->has('showToast') && $request->has('toastMessage')) {
            return redirect()
                ->route('customer.signin', ['locale' => app()->getLocale()])
                ->with('info', $request->get('toastMessage'));
        }
        return view('sanita.auth.signin');
    }

    // Handle customer sign in
    public function signIn(Request $request)
    {
        $request->merge([
            'mobile' => $this->cleanPhoneNumber($request->mobile),
        ]);
        $request->validate([
            'mobile' => ['required', 'string', 'max:20', 'regex:/^\+?[0-9\s\-\(\)]+$/'],
            'country_code' => 'required|string|max:10',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('mobile', $request->mobile)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            // Return a single error keyed by 'login_error'
            return back()->withErrors(['login_error' => 'Invalid credentials.'])->withInput();
        }

        // Log in the customer
        Auth::guard('customer')->login($customer);

        return redirect()->route('sanita.index', ['locale' => app()->getLocale()])
            ->with('success', 'Signed in successfully!');
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
