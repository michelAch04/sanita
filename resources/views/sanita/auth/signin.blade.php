@extends('sanita.layout')
@php
$isRtl = app()->getLocale() === 'ar' || app()->getLocale() === 'ku';
@endphp
@section('title', 'Sign In')

@section('content')

<div class="container mb-4" style="max-width:400px;">
    <h2 class="display-5 login-title text-center mt-4">{{ __('auth.sign_in.title') }}</h2>

    <div class="{{ $isRtl ? 'rtl-container' : '' }}">
        <form method="POST" action="{{ route('customer.signin', ['locale' => app()->getLocale()]) }}" 
        onsubmit="console.log(phoneInputField.value, countryCodeInput.value)" class="login-form">
            @csrf

            <div class="login-flex-column">
                <label for="mobile" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.mobile') }}</label>
            </div>
            <div class="login-inputForm phone-group @error('mobile') is-invalid @enderror" style="position: relative;">
                <i class="fa fa-phone"></i>
                <input type="hidden" name="country_code" id="country_code">
                <input id="mobile" type="tel" name="mobile"
                    class="login-input"
                    value="{{ old('mobile') }}"
                    data-old="{{ old('country_code') ? '+' . old('country_code') . old('mobile') : '' }}"
                    placeholder="{{ __('auth.sign_up.mobile') }}" required> 
                <span id="phone-loading" class="phone-status-icon" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); display: none;">
                    <i class="fa fa-spinner fa-spin"></i>
                </span>
                <span id="phone-valid" class="phone-status-icon text-success" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); display: none;">
                    <i class="fa fa-check-circle"></i>
                </span>
                <span id="phone-invalid" class="phone-status-icon text-danger" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); display: none;">
                    <i class="fa fa-xmark-circle"></i>
                </span>
            </div>
            <div id="mobile-error" class="login-error-message" style="display:none;"></div>

            <div class="login-flex-column">
                <label for="password" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_in.password') }}</label>
            </div>
            <div class="login-inputForm">
                <i class="fa fa-lock"></i>
                <input type="password"
                    name="password"
                    id="password"
                    class="login-input"
                    placeholder="{{ __('auth.sign_in.password') }}">
                <i class="fa fa-eye toggle-password" style="cursor: pointer;"></i>
            </div>

            @if ($errors->has('login_error'))
            <div class="login-error-message">
                {{ $errors->first('login_error') }}
            </div>
            @endif

            <div class="login-flex-row">
                <label class="cl-checkbox" for="remember">
                    <input type="checkbox" id="remember" name="remember" style="cursor: pointer;" checked="">
                    <span>{{ __('auth.sign_in.remember_me') }}</span>
                </label>
                <a href="{{ route('password.request', ['locale' => app()->getLocale()]) }}" class="login-span">
                    {{ __('auth.sign_in.forgot_password') }}
                </a>
            </div>

            <button type="submit" class="login-button-submit bubbles">
                <span class="text">{{ __('auth.sign_in.login') }}</span>
            </button>

            <p class="login-p">
                <a href="{{ route('customer.signup', ['locale' => app()->getLocale()]) }}" class="login-span">
                    {{ __('auth.sign_in.no_account_signup') }}
                </a>
            </p>
        </form>
    </div>
</div>
<style>
    .error-toast {
        display: none !important;
    }

    .login-input {
        width: 85% !important;
    }
</style>
<script src="{{ asset('js/auth.js') }}"></script>
@endsection