@extends('cms.layout')

@section('title', 'Edit Customer')

@section('content')
    <div class="container mt-5">
        <h2>Edit Customer</h2>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name', $customer->first_name) }}" required>

                <label for="last_name" class="mt-3">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name', $customer->last_name) }}" required>

                <label for="dob" class="mt-3">Date of Birth</label>
                <input type="date" id="dob" name="dob" class="form-control" value="{{ old('dob', $customer->dob) }}">

                <label for="gender" class="mt-3">Gender</label>
                <select id="gender" name="gender" class="form-control">
                    <option value="male" {{ old('gender', $customer->gender) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $customer->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('gender', $customer->gender) == 'other' ? 'selected' : '' }}>Other</option>
                </select>

                <label for="mobile" class="mt-3">Mobile</label>
                <input type="text" id="mobile" name="mobile" class="form-control" value="{{ old('mobile', $customer->mobile) }}">

                <label for="email" class="mt-3">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}" required>

                <label for="password" class="mt-3">Password</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Update Customer</button>
        </form>
    </div>
@endsection