@extends('cms.layout')

@section('title', 'Add Category')

@section('content')
<div class="container mt-3">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Create Category</h2>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Name --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="name" name="name" required
                        style="width: 100%;" placeholder="">
                    <label for="name" class="label">Category Name</label>
                    <div class="underline"></div>
                </div>

                {{-- Visibility Toggle --}}
                <div class="checkbox-wrapper-8 mb-5">
                    <label for="visible" class="visible-label">Visible</label>
                    <input type="checkbox" id="visible" name="visible" class="tgl" value="1"
                        {{ old('visible', true) ? 'checked' : '' }}>
                    <label for="visible" class="tgl-btn" data-tg-on="Yes" data-tg-off="No"></label>
                </div>

                {{-- Upload Image --}}
                <div class="d-flex align-items-start gap-4 mb-4 flex-wrap upload-container">
                    <!-- Custom Upload Button -->
                    <div>
                        <label for="image" id="imageLabel" class="btn underline-btn">Upload Image</label>
                        <input type="file" id="image" name="image" accept="image/*" hidden>
                    </div>

                    <!-- Image Preview -->
                    <div id="previewContainer" style="display: none;">
                        <img id="imagePreview" src="#" alt="Selected Image" class="img-thumbnail" style="max-width: 150px;">
                        <div id="fileName" class="text-muted mt-2 small text-center text-decoration-underline mb-1"></div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('categories.index') }}" class="btn bubbles bubbles-grey me-2">
                        <span class="text">Cancel</span></a>
                    <button type="submit" class="btn bubbles"><span class="text">Create</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection