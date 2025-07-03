@extends('sanita.layout')

@section('title', __('auth.passwords.email_title'))

@section('content')

<div class="container login-container mb-4 mt-3 d-flex justify-content-center flex-column align-items-center">
    <h2 class="display-5 text-center mt-4 section-title">{{ __('auth.passwords.email_title') }}</h2>
    <div class="mt-5 mb-5 shadow login-form rounded-2 px-5 py-4 w-100 {{ $isRtl ? 'rtl-container' : '' }}">
        <form class="form" method="POST" action="{{ route('password.email', ['locale' => app()->getLocale()]) }}">
            @csrf
            <div class="login-flex-column">
                <label for="email" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.passwords.email') }}</label>
            </div>
            <div class="login-inputForm">
                <i class="fa fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="{{ __('auth.passwords.email') }}"
                    required autofocus class="login-input">
            </div>

            <button type="submit" class="login-button-submit bubbles">
                <span class="text">{{ __('auth.passwords.send_link') }}</span>
            </button>
        </form>

        <p class="login-p mt-3">
            <a href="{{ route('customer.signup', ['locale' => app()->getLocale()]) }}" class="login-span">
                {{ __('auth.sign_in.no_account_signup') }}
            </a>
        </p>
    </div>
</div>
@endsection
