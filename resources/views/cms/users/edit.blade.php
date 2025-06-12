@extends('cms.layout')

@section('title', 'Edit User')

@section('content')
<div class="ps-5 mt-3">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Edit User</h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="input-container mb-5 mt-3">
                    <input type="text" id="name" name="name" value="{{ $user->name }}" required>
                    <label for="name" class="label">Name</label>
                    <div class="underline"></div>
                </div>

                {{-- Email (disabled) --}}
                <div class="input-container mb-5 disabled-container">
                    <input type="email" id="email" name="email" value="{{ $user->email }}" readonly>
                    <label for="email" class="label">Email</label>
                    <div class="underline"></div>
                </div>

                {{-- Password --}}
                <div class="input-container mb-5">
                    <input type="text" id="password" name="password" placeholder="">
                    <label for="password" class="label">Password (optional)</label>
                    <div class="underline"></div>
                </div>

                {{-- Confirm Password --}}
                <div class="input-container mb-3">
                    <input type="text" id="password_confirmation" name="password_confirmation"  placeholder="">
                    <label for="password_confirmation" class="label">Confirm Password</label>
                    <div class="underline"></div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('users.index') }}" class="btn bubbles bubbles-grey me-2">
                        <span class="text">Cancel</span></a>
                    <button type="submit" class="btn bubbles"><span class="text">Update</span></button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection