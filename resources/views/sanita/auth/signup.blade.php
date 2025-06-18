@extends('sanita.layout')

@section('title', 'Sign Up')

@section('content')
@php $isRtl = app()->getLocale() === 'ar'; @endphp

<div class="container mb-4 mt-5" style="max-width: 500px;">
    <h2 class="display-5 login-title text-center mb-5">{{ __('auth.sign_up.title') }}</h2>

    @if ($errors->has('general'))
    <div id="toast-error" class="login-toast error-toast {{ $isRtl ? 'rtl-container' : '' }}">
        <i class="fa fa-times-circle"></i>
        <span>{{ $errors->first('general') }}</span>
    </div>
    @endif

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
                    class="login-input small-input">
                <span class="slash">/</span>
                <input type="text" name="dob_month" id="dob_month" maxlength="2" placeholder="MM"
                    class="login-input small-input">
                <span class="slash">/</span>
                <input type="text" name="dob_year" id="dob_year" maxlength="4" placeholder="YYYY"
                    class="login-input small-input small-input-year">
                {{-- Hidden final DOB input --}}
                <input type="hidden" name="DOB" id="DOB">
            </div>
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
            </div>
            @error('mobile')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Gender --}}
        <div class="mb-4">
            <label for="gender" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.gender') }}</label>
            <div class="login-inputForm" @error('gender') is-invalid @enderror>
                <i class="fa fa-venus-mars"></i>
                <select name="gender" id="gender" class="login-input custom-select">
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('auth.sign_up.gender_male') }}</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('auth.sign_up.gender_female') }}</option>
                </select>
                <i class="fa fa-chevron-down dropdown-icon"></i>
            </div>
            @error('gender')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="login-button-submit bubbles">
            <span class="text">{{ __('auth.sign_up.submit') }}</span>
        </button>

        <p class="login-p text-center mt-3 mb-5">
            <a href="{{ route('customer.signin', ['locale' => app()->getLocale()]) }}" class="login-span">
                {{ __('auth.sign_up.already_account_signin') }}
            </a>
        </p>
    </form>
</div>

<script>
    // Handle toast message for errors
    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('toast-error');
        if (toast) {
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.querySelector('#password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        const firstInvalid = document.querySelector('.is-invalid');
        if (firstInvalid) {
            firstInvalid.focus();
        }
    });

    // Handle date input validation
    // Convert DD / MM / YYYY to ISO format YYYY-MM-DD on form submission
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const dayInput = document.getElementById('dob_day');
        const monthInput = document.getElementById('dob_month');
        const yearInput = document.getElementById('dob_year');
        const hiddenDOB = document.getElementById('DOB');

        form.addEventListener('submit', function(e) {
            const day = dayInput.value.trim().padStart(2, '0');
            const month = monthInput.value.trim().padStart(2, '0');
            const year = yearInput.value.trim();

            const iso = `${year}-${month}-${day}`;
            const testDate = new Date(iso);

            // Validate date
            if (
                testDate &&
                testDate.getFullYear() == year &&
                testDate.getMonth() + 1 == parseInt(month) &&
                testDate.getDate() == parseInt(day)
            ) {
                hiddenDOB.value = iso;
            } else {
                e.preventDefault();
                alert('Please enter a valid date in DD / MM / YYYY format.');
            }
        });
    });

    // Handle phone number validation using intl-tel-input
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInputField = document.querySelector("#mobile");
        const phoneValidIcon = document.getElementById("phone-valid");
        const phoneLoadingIcon = document.getElementById("phone-loading");

        const iti = window.intlTelInput(phoneInputField, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            preferredCountries: ["iq", "lb", "eg", "jo", "sa", "ae", "om", "kw", "qa", "bh"],
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                fetch('https://ipapi.co/json')
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("us"));
            }
        });

        function validatePhoneNumber() {
            const number = phoneInputField.value.trim();
            if (number.length === 0) {
                phoneValidIcon.style.display = "none";
                phoneLoadingIcon.style.display = "none";
                return;
            }

            // Show loading
            phoneValidIcon.style.display = "none";
            phoneLoadingIcon.style.display = "inline";

            // Simulate "checking" delay
            setTimeout(() => {
                const isValid = iti.isValidNumber();
                phoneLoadingIcon.style.display = "none";
                phoneValidIcon.style.display = isValid ? "inline" : "none";
            }, 400);
        }

        // Trigger on keyup, change, blur
        phoneInputField.addEventListener('input', validatePhoneNumber);
        phoneInputField.addEventListener('blur', validatePhoneNumber);
    });
</script>
@endsection