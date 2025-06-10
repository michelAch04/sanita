@extends('sanita.layout')

@section('title', __('auth.passwords.email_title'))

@section('content')
@php
$isRtl = app()->getLocale() === 'ar';
@endphp
<div class="container mt-5" style="max-width:400px;">
    <h2 class="mb-4 text-center">{{ __('auth.passwords.email_title') }}</h2>

    @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email', ['locale' => app()->getLocale()]) }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label {{ $isRtl ? 'text-end w-100' : '' }}">{{ __('auth.passwords.email') }}</label>
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror"
                autofocus
                placeholder="{{ __('auth.passwords.email') }}"
                {{ $isRtl ? 'dir=rtl' : '' }}>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">{{ __('auth.passwords.send_link') }}</button>
    </form>
</div>
@endsection