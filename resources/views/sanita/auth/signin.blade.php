@extends('sanita.layout')

@section('title', 'Sign In')

@section('content')
@php $isRtl = app()->getLocale() === 'ar'; @endphp

<div class="container mb-4" style="max-width:400px;">
    <h2 class="display-5 login-title text-center mt-4">{{ __('auth.sign_in.title') }}</h2>

    @if(session('error'))
    <div id="toast-error" class="login-toast error-toast {{ $isRtl ? 'rtl-container' : '' }}">
        <i class="fa fa-times-circle"></i>
        <span>{{ __('auth.failed') }}</span>
    </div>
    @endif

    <div class="{{ $isRtl ? 'rtl-container' : '' }}">
        <form method="POST" action="{{ route('customer.signin', ['locale' => app()->getLocale()]) }}" class="login-form">
            @csrf

            <div class="login-flex-column">
                <label for="email" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_in.email') }}</label>
            </div>
            <div class="login-inputForm">
                <i class="fa fa-envelope"></i>
                <input type="email"
                    name="email"
                    id="email"
                    class="login-input"
                    value="{{ old('email') }}"
                    placeholder="{{ __('auth.sign_in.email') }}">
            </div>

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
<script>
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
</script>
@endsection