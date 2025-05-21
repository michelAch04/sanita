@extends('sanita.layout')

@section('title', 'Sign Up')

@section('content')
<div class="container mt-5" style="max-width: 500px;">
    <div class="text-center mb-4">
        <img src="{{ asset('images/signup.png') }}" alt="Sign Up" class="img-fluid" style="max-width: 120px;">
    </div>
    <h2 class="mb-4 text-center">Sign Up</h2>

    @if ($errors->has('general'))
    <div class="alert alert-danger">
        {{ $errors->first('general') }}
    </div>
    @endif

    <form method="POST" action="{{ route('customer.signup') }}">
        @csrf

        <div class="form-group mb-3">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}">
            @error('first_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}">
            @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="DOB">Date of Birth</label>
            <input type="date" name="DOB" id="DOB" class="form-control @error('DOB') is-invalid @enderror" value="{{ old('DOB') }}" max="{{ date('Y-m-d') }}">
            @error('DOB')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="mobile">Mobile</label>
            <input type="text" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror"
                value="{{ old('mobile') }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                inputmode="numeric">
            @error('mobile')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                <option value="">Select</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            @error('gender')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
            @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Sign Up</button>
    </form>

    <div class="mt-3 text-center">
        <a href="{{ route('customer.signin') }}">Already have an account? Sign In</a>
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