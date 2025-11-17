@extends('cms.layout')

@section('title', 'Add Customer')

@section('content')
<div class="ps-5 mt-3">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Create Customer</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            {{-- Tabs --}}
            <ul class="nav nav-tabs mb-4" id="customerTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="b2b-tab" data-bs-toggle="tab" data-bs-target="#b2b" type="button" role="tab" aria-controls="b2b" aria-selected="true">B2B</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="b2c-tab" data-bs-toggle="tab" data-bs-target="#b2c" type="button" role="tab" aria-controls="b2c" aria-selected="false">B2C</button>
                </li>
            </ul>

            <form action="{{ route('customers.store') }}" method="POST">
                @csrf

                {{-- Tabs Content --}}
                <div class="tab-content" id="customerTabsContent">
                    {{-- B2B TAB --}}
                    <div class="tab-pane fade show active" id="b2b" role="tabpanel" aria-labelledby="b2b-tab">
                        {{-- First Name --}}
                        <div class="input-container mb-5 mt-3">
                            <input type="text" name="first_name" placeholder="">
                            <label class="label">First Name</label>
                            <div class="underline"></div>
                        </div>

                        {{-- Last Name --}}
                        <div class="input-container mb-5">
                            <input type="text" name="last_name" placeholder="">
                            <label class="label">Last Name</label>
                            <div class="underline"></div>
                        </div>

                        {{-- Date of Birth --}}
                        <div class="input-container mb-4">
                            <input type="date" name="dob" placeholder="">
                            <label class="label">Date of Birth</label>
                            <div class="underline"></div>
                        </div>

                        {{-- Gender --}}
                        <div class="checkbox-wrapper-8 mb-5">
                            <label for="gender" class="visible-label">Gender</label>
                            <input type="hidden" name="gender" value="female"> {{-- default value --}}
                            <input type="checkbox" id="gender" name="gender" class="tgl" value="male">
                            <label for="gender" class="tgl-btn" data-tg-on="Male" data-tg-off="Female"></label>
                        </div>
                    </div>

                    {{-- B2C TAB --}}
                    <div class="tab-pane fade" id="b2c" role="tabpanel" aria-labelledby="b2c-tab">
                        {{-- No personal details shown here --}}
                    </div>
                </div>

                {{-- Shared Fields --}}
                <div class="input-container mb-5 mt-3">
                    <input type="text" name="mobile" placeholder="">
                    <label class="label">Mobile</label>
                    <div class="underline"></div>
                </div>

                <div class="input-container mb-5">
                    <input type="email" name="email" placeholder="" required>
                    <label class="label">Email</label>
                    <div class="underline"></div>
                </div>

                <div class="input-container mb-3">
                    <input type="text" name="password" placeholder="" required>
                    <label class="label">Password</label>
                    <div class="underline"></div>
                </div>

                {{-- Submit --}}
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

{{-- Styles --}}
<style>
    .checkbox-wrapper-8 .tgl+.tgl-btn {
        background: rgb(232, 123, 190) !important;
        width: 3.5em;
    }

    .checkbox-wrapper-8 .tgl:checked+.tgl-btn {
        background: rgb(125, 128, 221) !important;
    }

    .input-container input:focus+.label,
    .input-container input:valid+.label {
        top: -20px;
        font-size: 12px;
        color: #555;
    }
</style>
@endsection