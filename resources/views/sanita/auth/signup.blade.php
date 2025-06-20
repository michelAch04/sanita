@extends('sanita.layout')

@section('title', 'Sign Up')

@section('content')
@php $isRtl = (app()->getLocale() === 'ar' || app()->getLocale() === 'ku'); @endphp

<div class="container mb-4 mt-5" style="max-width: 500px;">
    <h2 class="display-5 login-title text-center mb-5">{{ __('auth.sign_up.title') }}</h2>

    <form method="POST" action="{{ route('customer.signup', ['locale' => app()->getLocale()]) }}" class="{{ $isRtl ? 'rtl-container' : '' }}">
        @csrf

        {{-- First and Last Name --}}
        <div class="d-flex gap-2 mb-3">
            <div class="w-50">
                <label for="first_name" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.first_name') }}</label>
                <div class="login-inputForm @error('first_name') is-invalid @enderror">
                    <i class="fa fa-user"></i>
                    <input type="text" name="first_name" id="first_name"
                        class="login-input"
                        value="{{ old('first_name') }}" placeholder="{{ __('auth.sign_up.first_name') }}">
                </div>
                @error('first_name')
                <div class="login-error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-50">
                <label for="last_name" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.last_name') }}</label>
                <div class="login-inputForm @error('last_name') is-invalid @enderror">
                    <i class="fa fa-user"></i>
                    <input type="text" name="last_name" id="last_name"
                        class="login-input"
                        value="{{ old('last_name') }}" placeholder="{{ __('auth.sign_up.last_name') }}">
                </div>
                @error('last_name')
                <div class="login-error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.email') }}</label>
            <div class="login-inputForm @error('email') is-invalid @enderror">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" id="email"
                    class="login-input"
                    value="{{ old('email') }}" placeholder="{{ __('auth.sign_up.email') }}">
            </div>
            @error('email')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.password') }}</label>
            <div class="login-inputForm @error('password') is-invalid @enderror">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" id="password"
                    class="login-input"
                    placeholder="{{ __('auth.sign_up.password') }}">
                <i class="fa fa-eye toggle-password" style="cursor: pointer;"></i>
            </div>
            @error('password')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mb-3">
            <label for="password_confirmation" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.password_confirmation') }}</label>
            <div class="login-inputForm">
                <i class="fa fa-check"></i>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="login-input" placeholder="{{ __('auth.sign_up.password_confirmation') }}">
                <i class="fa fa-eye toggle-confirm" style="cursor: pointer;"></i>
            </div>
        </div>

        {{-- DOB --}}
        <div class="mb-3">
            <label for="dob_day" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.dob') }}</label>
            <div class="login-inputForm dob-group @error('DOB') is-invalid @enderror">
                <i class="fa fa-calendar"></i>
                <input type="text" name="dob_day" id="dob_day" maxlength="2" placeholder="DD"
                    class="login-input small-input" value="{{ old('dob_day') }}">
                <span class="slash">/</span>
                <input type="text" name="dob_month" id="dob_month" maxlength="2" placeholder="MM"
                    class="login-input small-input" value="{{ old('dob_month') }}">
                <span class="slash">/</span>
                <input type="text" name="dob_year" id="dob_year" maxlength="4" placeholder="YYYY"
                    class="login-input small-input small-input-year" value="{{ old('dob_year') }}">
                {{-- Hidden final DOB input --}}
                <input type="hidden" name="DOB" id="DOB">
            </div>
            <div id="dob-error" class="login-error-message" style="display:none;"></div>
            @error('DOB')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Mobile --}}
        <div class="mb-3">
            <label for="mobile" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.mobile') }}</label>
            <div class="login-inputForm phone-group @error('mobile') is-invalid @enderror" style="position: relative;">
                <i class="fa fa-phone"></i>
                <input id="mobile" type="tel" name="mobile"
                    class="login-input"
                    value="{{ old('mobile') }}" placeholder="{{ __('auth.sign_up.mobile') }}">
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
            @error('mobile')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Gender --}}
        <div class="mb-4">
            <label class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.gender') }}</label>
            <div class="d-flex align-items-center gap-2 flex-direction-row login-inputForm">
                <i class="fa fa-venus-mars"></i>
                <div class="glass-radio-group @error('gender') is-invalid @enderror">
                    <input type="radio" name="gender" id="glass-male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} />
                    <label for="glass-male" id="glass-male">{{ __('auth.sign_up.gender_male') }}</label>

                    <input type="radio" name="gender" id="glass-female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} />
                    <label for="glass-female" id="glass-female">{{ __('auth.sign_up.gender_female') }}</label>

                    <div class="glass-glider"></div>
                </div>
            </div>
            @error('gender')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="login-button-submit bubbles">
            <span class="text">{{ __('auth.sign_up.submit') }}</span>
        </button>

        <p class="login-p text-center mt-3 mb-4">
            <a href="{{ route('customer.signin', ['locale' => app()->getLocale()]) }}" class="login-span">
                {{ __('auth.sign_up.already_account_signin') }}
            </a>
        </p>
    </form>
</div>
<style>
    .error-toast {
        display: none !important;
    }
</style>
<script src="{{ asset('js/auth.js') }}"></script>
@endsection