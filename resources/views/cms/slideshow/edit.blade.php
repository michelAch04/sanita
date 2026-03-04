@extends('cms.layout')

@section('title', 'Edit Slide')

@section('content')
<div class="ps-5 mt-3">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Edit Slide</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('slideshow.update', $slideshow->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Slide Name --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="name" name="name" value="{{ old('name', $slideshow->name) }}" required style="width: 100%;">
                    <label for="name" class="label">Slide Name</label>
                    <div class="underline"></div>
                </div>

                {{-- Visibility Toggle --}}
                <div class="checkbox-wrapper-8 mb-5">
                    <label for="visible" class="visible-label">Visible</label>
                    <input type="checkbox" id="visible" name="visible" class="tgl" value="1"
                        {{ old('visible', !$slideshow->hidden) ? 'checked' : '' }}>
                    <label for="visible" class="tgl-btn" data-tg-on="Yes" data-tg-off="No"></label>
                </div>

                {{-- Upload Image --}}
                <div class="d-flex align-items-start gap-4 mb-4 flex-wrap upload-container">
                    <!-- Custom Upload Button -->
                    <div>
                        <label for="image" id="imageLabel" class="btn underline-btn">Upload Image</label>
                        <input type="file" id="image" name="image" accept="image/*" hidden>
                        <small class="text-muted d-block mt-1">Best: full-width landscape, max 400 px tall (e.g. 1280×400 px)</small>
                    </div>

                    <!-- Image Preview -->
                    <div id="previewContainer" style="display: none;">
                        <img id="imagePreview" src="#" alt="Selected Image" class="img-thumbnail" style="max-width: 150px;">
                        <div id="fileName" class="text-muted mt-2 small text-center text-decoration-underline mb-1"></div>
                    </div>

                    <!-- Existing Image -->
                    @if ($slideshow->extension)
                    <div class="d-flex flex-column mt-3">
                        <img src="{{ asset('storage/slideshow/' . $slideshow->id . '.' . $slideshow->extension) }}" 
                             alt="Current Image" 
                             class="img-thumbnail" 
                             style="max-width: 150px;">
                        <p class="mb-1 text-muted small text-center text-decoration-underline">Current Image</p>
                    </div>
                    @endif
                </div>

                {{-- Submit & Cancel --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('slideshow.index') }}" class="btn bubbles bubbles-grey me-2">
                        <span class="text">Cancel</span>
                    </a>
                    <button type="submit" class="btn bubbles">
                        <span class="text">Update</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
