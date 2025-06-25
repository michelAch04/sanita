@extends('cms.layout')

@section('title', 'Edit Distributor')

@section('content')
<div class="container py-4">

    <h2>Edit Distributor</h2>

    <form action="{{ route('distributor.update', $distributor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $distributor->name) }}">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $distributor->email) }}">
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Mobile</label>
            <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $distributor->mobile) }}">
            @error('mobile')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $distributor->location) }}">
            @error('location')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('distributor.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

</div>
@endsection