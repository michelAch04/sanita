@extends('sanita.layout')

@section('title', __('auth.verify_otp.title'))

@section('content')
@php $isRtl = (app()->getLocale() === 'ar' || app()->getLocale() === 'ku'); @endphp

<div class="container mb-4 mt-5" style="max-width: 500px;">
    <h2 class="display-5 login-title text-center mb-5">{{ __('auth.verify_otp.title') }}</h2>

    <form method="POST" action="{{ route('customer.verifyOtp', ['locale' => app()->getLocale()]) }}" class="{{ $isRtl ? 'rtl-container' : '' }}">
        @csrf

        {{-- Hidden Mobile --}}
        <input type="hidden" name="mobile" value="{{ session('pending_mobile') ?? old('mobile') }}">

        {{-- Display Mobile (readonly view for user feedback) --}}
        <input type="text" class="login-input" value="{{ session('pending_mobile') ?? old('mobile') }}" hidden>

        {{-- OTP --}}
        <div class="mb-3">
            <label for="otp" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.verify_otp.otp') }}</label>
            <div class="login-inputForm @error('otp') is-invalid @enderror">
                <i class="fa fa-shield-alt"></i>
                <input type="text" name="otp" id="otp"
                    class="login-input"
                    maxlength="6"
                    value="{{ old('otp') }}"
                    placeholder="{{ __('auth.verify_otp.otp') }}">
            </div>
            @error('otp')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="login-button-submit bubbles">
            <span class="text">{{ __('auth.verify_otp.submit') }}</span>
        </button>

        {{-- Resend OTP --}}
        <div class="text-center mt-3">
            <a href="{{ route('customer.resendOtp', ['locale' => app()->getLocale()]) }}" class="login-span">
                {{ __('auth.verify_otp.resend_otp') ?? 'Resend OTP' }}
            </a>
        </div>

        <p class="login-p text-center mt-3 mb-4">
            <a href="{{ route('customer.signup', ['locale' => app()->getLocale()]) }}" class="login-span">
                {{ __('auth.verify_otp.no_account_register') }}
            </a>
        </p>
    </form>
</div>

<script src="{{ asset('js/auth.js') }}"></script>
@endsection