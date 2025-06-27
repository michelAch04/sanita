@extends('cms.layout')

@section('title', 'Create Distributor')

@section('content')
<div class="ps-5 mt-3">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Create Distributor</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('distributor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Name --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="name" name="name" class="styled-input" required 
                    style="width: 100%;" value="{{ old('name') }}" placeholder="">
                    <label for="name" class="label">Name</label>
                    <div class="underline"></div>
                    @error('name')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="email" id="email" name="email" class="styled-input" 
                    style="width: 100%;" value="{{ old('email') }}" placeholder="">
                    <label for="email" class="label">Email</label>
                    <div class="underline"></div>
                    @error('email')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mobile --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="mobile" name="mobile" class="styled-input" 
                    style="width: 100%;" value="{{ old('mobile') }}" placeholder="">
                    <label for="mobile" class="label">Mobile</label>
                    <div class="underline"></div>
                    @error('mobile')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Location --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="location" name="location" class="styled-input" 
                    style="width: 100%;" value="{{ old('location') }}" placeholder="">
                    <label for="location" class="label">Location</label>
                    <div class="underline"></div>
                    @error('location')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit & Cancel --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('distributor.index') }}" class="btn bubbles bubbles-grey me-2">
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
