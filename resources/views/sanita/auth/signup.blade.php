@extends('sanita.layout')

@section('title', 'Sign Up')

@section('content')
@php
    $isRtl = app()->getLocale() === 'ar';
@endphp
<div class="container  mt-5" style="max-width: 500px;">
    <h2 class="mb-5 mt-5  text-center">{{ __('auth.sign_up.title') }}</h2>

    @if ($errors->has('general'))
    <div class="alert alert-danger">
        {{ $errors->first('general') }}
    </div>
    @endif

    <form method="POST" action="{{ route('customer.signup', ['locale' => app()->getLocale()]) }}">
        @csrf

        <div class="form-group mb-3">
            <label for="first_name" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.first_name') }}</label>
            <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" placeholder="{{ __('auth.sign_up.first_name') }}" {{ $isRtl ? 'dir=rtl' : '' }}>
            @error('first_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="last_name" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.last_name') }}</label>
            <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="{{ __('auth.sign_up.last_name') }}" {{ $isRtl ? 'dir=rtl' : '' }}>
            @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="DOB" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.dob') }}</label>
            <input type="date" name="DOB" id="DOB" class="form-control @error('DOB') is-invalid @enderror" value="{{ old('DOB') }}" max="{{ date('Y-m-d') }}" placeholder="{{ __('auth.sign_up.dob') }}" {{ $isRtl ? 'dir=rtl' : '' }}>
            @error('DOB')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="mobile" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.mobile') }}</label>
            <input type="text" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror"
                value="{{ old('mobile') }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                inputmode="numeric" placeholder="{{ __('auth.sign_up.mobile') }}" {{ $isRtl ? 'dir=rtl' : '' }}>
            @error('mobile')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="gender" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.gender') }}</label>
            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" {{ $isRtl ? 'dir=rtl' : '' }}>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('auth.sign_up.gender_male') }}</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('auth.sign_up.gender_female') }}</option>
            </select>
            @error('gender')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.email') }}</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="{{ __('auth.sign_up.email') }}" {{ $isRtl ? 'dir=rtl' : '' }}>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.password') }}</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('auth.sign_up.password') }}" {{ $isRtl ? 'dir=rtl' : '' }}>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.sign_up.password_confirmation') }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="{{ __('auth.sign_up.password_confirmation') }}" {{ $isRtl ? 'dir=rtl' : '' }}>
            @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">{{ __('auth.sign_up.submit') }}</button>
    </form>

    <div class="mt-3 text-center">
        <a href="{{ route('customer.signin', ['locale' => app()->getLocale()]) }}">{{ __('auth.sign_up.already_account_signin') }}</a>
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