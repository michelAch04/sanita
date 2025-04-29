@extends('cms.layout')

@section('title', 'Create User')

@section('content')
    <div class="container mt-5">
        <h2>Create User</h2>

        <!-- Display Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display Error Message -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>

                <label for="email" class="mt-3">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>

                <label for="password" class="mt-3">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>

                <label for="password_confirmation" class="mt-3">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Create User</button>
        </form>
    </div>
@endsection
