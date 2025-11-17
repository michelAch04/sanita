@extends('cms.layout')

@section('title', 'Add Slide')

@section('content')
<div class="ps-5 mt-3">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Add Slide</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('slideshow.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Slide Name --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="" required style="width: 100%;">
                    <label for="name" class="label">Slide Name</label>
                    <div class="underline"></div>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Visibility Toggle --}}
                <div class="checkbox-wrapper-8 mb-5">
                    <label for="visible" class="visible-label">Visible</label>
                    <input type="hidden" name="hidden" value="1"> {{-- Default to hidden --}}
                    <input type="checkbox" id="visible" name="hidden" class="tgl" value="0" {{ old('hidden', '0') == '0' ? 'checked' : '' }}>
                    <label for="visible" class="tgl-btn" data-tg-on="Yes" data-tg-off="No"></label>
                    @error('hidden')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload Image --}}
                <div class="d-flex align-items-start gap-4 mb-4 flex-wrap upload-container">
                    <div>
                        <label for="image" id="imageLabel" class="btn underline-btn">Upload Image</label>
                        <input type="file" id="image" name="image" accept="image/*" hidden required>
                        @error('image')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Image Preview (Optional: You can enable preview with JS later) --}}
                    <div id="previewContainer" style="display: none;">
                        <img id="imagePreview" src="#" alt="Selected Image" class="img-thumbnail" style="max-width: 150px;">
                        <div id="fileName" class="text-muted mt-2 small text-center text-decoration-underline mb-1"></div>
                    </div>
                </div>

                {{-- Submit & Cancel --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('slideshow.index') }}" class="btn bubbles bubbles-grey me-2">
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
