@extends('cms.layout')

@section('title', 'Add Customer')

@section('content')
<div class="ps-5 mt-3">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Create Customer</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf

                {{-- First Name --}}
                <div class="input-container mb-5 mt-3">
                    <input type="text" name="first_name" placeholder="" required>
                    <label class="label">First Name</label>
                    <div class="underline"></div>
                </div>

                {{-- Last Name --}}
                <div class="input-container mb-5">
                    <input type="text" name="last_name" placeholder="" required>
                    <label class="label">Last Name</label>
                    <div class="underline"></div>
                </div>

                {{-- Date of Birth --}}
                <div class="input-container mb-4">
                    <input type="date" name="dob" placeholder="">
                    <label class="label">Date of Birth</label>
                    <div class="underline"></div>
                </div>

                {{-- Gender Toggle --}}
                <div class="checkbox-wrapper-8 mb-5">
                    <label for="gender" class="visible-label">Gender</label>
                    <input type="hidden" name="gender" value="female"> {{-- default value --}}
                    <input type="checkbox" id="gender" name="gender" class="tgl" value="male">
                    <label for="gender" class="tgl-btn" data-tg-on="Male" data-tg-off="Female"></label>
                </div>

                {{-- Mobile --}}
                <div class="input-container mb-5">
                    <input type="text" name="mobile" placeholder="">
                    <label class="label">Mobile</label>
                    <div class="underline"></div>
                </div>

                {{-- Email --}}
                <div class="input-container mb-5">
                    <input type="email" name="email" placeholder="" required>
                    <label class="label">Email</label>
                    <div class="underline"></div>
                </div>

                {{-- Password --}}
                <div class="input-container mb-3">
                    <input type="text" name="password" placeholder="" required>
                    <label class="label">Password</label>
                    <div class="underline"></div>
                </div>

                {{-- Submit & Cancel --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('customers.index') }}" class="btn bubbles bubbles-grey me-2">
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

<style>
    .checkbox-wrapper-8 .tgl+.tgl-btn {
        background: rgb(232, 123, 190) !important;
    }

    .checkbox-wrapper-8 .tgl:checked+.tgl-btn {
        background: rgb(125, 128, 221) !important;
    }

    .checkbox-wrapper-8 .tgl+.tgl-btn {
        width: 3.5em;
    }
</style>
@endsection