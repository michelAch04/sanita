@extends('cms.layout')

@section('title', 'Create Distributor')

@section('content')
<div class="container py-4">

    <h2>Create Distributor</h2>

    <form action="{{ route('distributor.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Mobile</label>
            <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
            @error('mobile')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location') }}">
            @error('location')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('distributor.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

</div>
@endsection