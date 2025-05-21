@extends('cms.layout')

@section('title', 'Slideshow')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Edit Slide</h1>

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
            <img src="{{ asset('storage/slideshow/' . $slideshow->id . '.' . $slideshow->extension) }}" alt="{{ $slideshow->name }}" width="100" class="mt-3">
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
        <button type="submit" class="btn btn-primary">Update Slide</button>
    </form>
</div>
@endsection