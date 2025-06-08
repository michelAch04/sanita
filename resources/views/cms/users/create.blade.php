@extends('cms.layout')

@section('title', 'Create User')

@section('content')
<div class="container mt-3">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Create User</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                {{-- Name --}}
                <div class="input-container mb-5 mt-3">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="">
                    <label for="name" class="label">Name</label>
                    <div class="underline"></div>
                </div>

                {{-- Email --}}
                <div class="input-container mb-5">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="">
                    <label for="email" class="label">Email</label>
                    <div class="underline"></div>
                </div>

                {{-- Password --}}
                <div class="input-container mb-5">
                    <input type="text" id="password" name="password" required placeholder="">
                    <label for="password" class="label">Password</label>
                    <div class="underline"></div>
                </div>

                {{-- Confirm Password --}}
                <div class="input-container mb-3">
                    <input type="text" id="password_confirmation" name="password_confirmation" required placeholder="">
                    <label for="password_confirmation" class="label">Confirm Password</label>
                    <div class="underline"></div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('users.index') }}" class="btn bubbles bubbles-grey me-2">
                        <span class="text">Cancel</span>
                    </a>
                    <button type="submit" class="btn bubbles">
                        <span class="text">Create</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
