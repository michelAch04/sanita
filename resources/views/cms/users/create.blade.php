@extends('cms.layout')

@section('title', 'Create User')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
            <h4 class="mb-0">Create User</h4>
        </div>

        <div class="card-body">
            <!-- Success Message -->
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="form-group mb-4">
                    <label for="name" class="fw-medium">Name</label>
                    <input type="text" id="name" name="name" class="form-control border-0 rounded-pill shadow-soft mt-2" value="{{ old('name') }}" required>
                </div>

                <div class="form-group mb-4">
                    <label for="email" class="fw-medium">Email</label>
                    <input type="email" id="email" name="email" class="form-control border-0 rounded-pill shadow-soft mt-2" value="{{ old('email') }}" required>
                </div>

                <div class="form-group mb-4">
                    <label for="password" class="fw-medium">Password</label>
                    <input type="password" id="password" name="password" class="form-control border-0 rounded-pill shadow-soft mt-2" required>
                </div>

                <div class="form-group mb-4">
                    <label for="password_confirmation" class="fw-medium">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control border-0 rounded-pill shadow-soft mt-2" required>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-teal">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection