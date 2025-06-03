@extends('cms.layout')

@section('title', 'Edit Slide')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
            <h4 class="mb-0">Edit Slide</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('slideshow.update', $slideshow->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $slideshow->name) }}" required>
                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    <div class="mt-2">
                        <img src="{{ asset('storage/slideshow/' . $slideshow->id . '.' . $slideshow->extension) }}" alt="{{ $slideshow->name }}" class="img-thumbnail" style="width: 120px;">
                    </div>
                    @error('image')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="hidden" class="form-label">Hidden</label>
                    <select name="hidden" id="hidden" class="form-select">
                        <option value="0" {{ old('hidden', $slideshow->hidden) == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('hidden', $slideshow->hidden) == '1' ? 'selected' : '' }}>Yes</option>
                    </select>
                    @error('hidden')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('slideshow.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection