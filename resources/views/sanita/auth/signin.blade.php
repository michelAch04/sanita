@extends('sanita.layout')

@section('title', 'Sign In')

@section('content')
@php
$isRtl = app()->getLocale() === 'ar';
@endphp
<div class="container mt-5 " style="max-width:400px;">
    <h2 class="mb-5 mt-5 text-center">{{ __('auth.sign_in.title') }}</h2>

    @if(session('error'))
    <div class="alert alert-danger">
        {{ __('auth.failed') }}
    </div>
    @endif

    <form method="POST" action="{{ route('customer.signin', ['locale' => app()->getLocale()]) }}">
        @csrf
        <div class="form-group">
            <label for="email" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_in.email') }}</label>
            <input type="email"
                name="email"
                id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                placeholder="{{ __('auth.sign_in.email') }}"
                {{ $isRtl ? 'dir=rtl' : '' }}>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_in.password') }}</label>
            <input type="password"
                name="password"
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ __('auth.sign_in.password') }}"
                {{ $isRtl ? 'dir=rtl' : '' }}>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 text-end">
            <a href="{{ route('password.request', ['locale' => app()->getLocale()]) }}">
                {{ __('auth.sign_in.forgot_password') }}
            </a>
        </div>

        <button type="submit" class="btn btn-primary mt-3 w-100">{{ __('auth.sign_in.login') }}</button>
    </form>
    <div class="mt-3 text-center">
        <a href="{{ route('customer.signup', ['locale' => app()->getLocale()]) }}">{{ __('auth.sign_in.no_account_signup') }}</a>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const firstInvalid = document.querySelector('.is-invalid');
        if (firstInvalid) {
            firstInvalid.focus();
        }
    });
</script>
@endsection