@extends('sanita.layout')

@section('title', 'Sign In')

@section('content')
<div class="container mt-5" style="max-width:400px;">
    <div class="text-center mb-4">
        <img src="{{ asset('images/login.png') }}" alt="Sign In" class="img-fluid" style="max-width:120px;">
    </div>
    <h2 class="mb-4 text-center">Sign In</h2>

    <form method="POST" action="{{ route('customer.signin') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email"
                name="email"
                id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password"
                name="password"
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                required>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Sign In</button>
    </form>
    <div class="mt-3 text-center">
        <a href="{{ route('customer.signup') }}">Don't have an account? Sign Up</a>
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