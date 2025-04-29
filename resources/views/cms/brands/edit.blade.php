@extends('cms.layout')

@section('title', 'Edit Brand')

@section('content')
    <div class="container mt-5">
        <h2>Edit Brand</h2>
        <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <!-- Name Field -->
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $brand->name) }}" required>

                <!-- Hidden Field -->
                <label for="hidden" class="mt-3">Hidden</label>
                <select id="hidden" name="hidden" class="form-control" required>
                    <option value="0" {{ old('hidden', $brand->hidden) == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('hidden', $brand->hidden) == 1 ? 'selected' : '' }}>Yes</option>
                </select>

                <!-- Image Upload Field -->
                <label for="image" class="mt-3">Upload Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                @if ($brand->extension)
                    <p class="mt-2">Current Image: 
                        <a href="{{ asset('storage/brands/' . $brand->id . '.' . $brand->extension) }}" target="_blank">View Image</a>
                    </p>
                @endif
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection