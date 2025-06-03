<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {

        return view('cms.auth.login');
    }

    // Handle the login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->cancelled == 1) {
            return back()->withErrors(['email' => 'Your account has been deactivated.']);
        }

        if ($user && $user->remember_token == null) {
            return back()->withErrors(['email' => 'Your account has not been activated.']);
        }

        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            // Redirect to the CMS dashboard or intended page
            return redirect()->intended('/cms/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        // Optionally, add a success message
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
