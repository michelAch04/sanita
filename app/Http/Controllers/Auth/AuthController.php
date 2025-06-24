<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private function cleanPhoneNumber($number)
    {
        $number = preg_replace('/\s+/', '', $number);
        $number = ltrim($number, '0');
        return $number;
    }

    public function showSignUp()
    {
        return view('sanita.auth.signup');
    }

    public function signUp(Request $request)
    {
        try {
            $request->merge([
                'mobile' => $this->cleanPhoneNumber($request->mobile),
            ]);

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
            $validated['otp'] = rand(100000, 999999);
            $validated['otp_expires_at'] = now()->addMinutes(5);
            $validated['verified'] = 0;
            $validated['type'] = 'b2c';
            $validated['token'] = Str::random(60);

            session(['pending_mobile' => $validated['mobile']]);

            $customer = Customer::create($validated);

            \Log::info("Signup OTP for {$customer->mobile}: {$validated['otp']}");

            return redirect()->route('customer.verifyotp', ['locale' => app()->getLocale()])
                ->with('success', 'An OTP has been sent to your mobile. Please verify to complete registration.');
        } catch (ValidationException $e) {
            \Log::error('Validation error during sign up', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Unexpected error during sign up', ['message' => $e->getMessage()]);
            return back()->withErrors(['general' => 'An error occurred during sign up.'])->withInput();
        }
    }

    public function showVerifyOtp()
    {
        return view('sanita.auth.verifyotp');
    }

    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'mobile' => 'required|string',
                'otp' => 'required|string',
            ]);

            $mobile = $this->cleanPhoneNumber($request->mobile);
            $customer = Customer::where('mobile', $mobile)->first();

            if (!$customer) {
                \Log::error("OTP verification failed: mobile not found ({$mobile})");
                return back()->withErrors(['otp' => 'Mobile number not found.']);
            }

            if ($customer->otp != $request->otp) {
                \Log::error("OTP verification failed: invalid OTP for mobile {$customer->mobile}");
                return back()->withErrors(['otp' => 'Invalid OTP.']);
            }

            if (now()->greaterThan($customer->otp_expires_at)) {
                \Log::error("OTP verification failed: expired OTP for mobile {$customer->mobile}");
                return back()->withErrors(['otp' => 'OTP has expired. Please register again or request a new OTP.']);
            }

            $customer->update([
                'verified_at' => now(),
                'verified' => 1,
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            session()->forget('pending_mobile');

            Auth::guard('customer')->login($customer);

            return redirect()->route('sanita.index', ['locale' => app()->getLocale()])
                ->with('success', 'Your mobile number has been verified and you are now logged in.');
        } catch (\Exception $e) {
            \Log::error('Unexpected error during OTP verification', ['message' => $e->getMessage()]);
            return back()->withErrors(['general' => 'An error occurred during OTP verification.'])->withInput();
        }
    }

    public function resendOtp()
    {
        try {
            $mobile = session('pending_mobile');

            if (!$mobile) {
                \Log::error('Resend OTP failed: no pending mobile in session');
                return redirect()->route('customer.signup', ['locale' => app()->getLocale()])
                    ->withErrors(['general' => 'No pending verification found.']);
            }

            $customer = Customer::where('mobile', $mobile)->first();

            if (!$customer) {
                \Log::error("Resend OTP failed: mobile not found ({$mobile})");
                return redirect()->route('customer.signup', ['locale' => app()->getLocale()])
                    ->withErrors(['general' => 'Mobile number not found.']);
            }

            $otp = rand(100000, 999999);
            $customer->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(5),
            ]);

            \Log::info("Resent OTP for {$customer->mobile}: {$otp}");

            return back()->with('success', 'A new OTP has been sent to your mobile.');
        } catch (\Exception $e) {
            \Log::error('Unexpected error during OTP resend', ['message' => $e->getMessage()]);
            return back()->withErrors(['general' => 'An error occurred while resending OTP.']);
        }
    }

    public function showSignIn(Request $request)
    {
        return view('sanita.auth.signin');
    }

    public function signIn(Request $request)
    {
        try {
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
                \Log::error("Login failed: invalid credentials for mobile {$request->mobile}");
                return back()->withErrors(['login_error' => 'Invalid credentials.'])->withInput();
            }

            if ($customer->verified != 1) {
                \Log::error("Login failed: mobile not verified ({$customer->mobile})");
                return back()->withErrors(['login_error' => 'Your mobile number is not verified.'])->withInput();
            }

            if (empty($customer->token)) {
                \Log::error("Login failed: customer token missing ({$customer->mobile})");
                return back()->withErrors(['login_error' => 'Login failed due to account issue. Please contact support.']);
            }

            Auth::guard('customer')->login($customer);

            return redirect()->route('sanita.index', ['locale' => app()->getLocale()])
                ->with('success', 'Signed in successfully!');
        } catch (\Exception $e) {
            \Log::error('Unexpected error during sign in', ['message' => $e->getMessage()]);
            return back()->withErrors(['general' => 'An error occurred during sign in.'])->withInput();
        }
    }


    public function signOut(Request $request)
    {
        try {
            $customer = Auth::guard('customer')->user();

            if ($customer) {
                $customer->update([
                    'token' => Str::random(60),
                ]);
            }

            Auth::guard('customer')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Signed out successfully!');
        } catch (\Exception $e) {
            \Log::error('Unexpected error during sign out', ['message' => $e->getMessage()]);
            return redirect('/')->withErrors(['general' => 'An error occurred during sign out.']);
        }
    }
}
