@extends('cms.layout')

@section('title', 'Add Category')

@section('content')
<div class="ps-5 mt-3">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Create Category</h2>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Name --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="name_en" name="name_en" required
                        style="width: 100%;" placeholder="">
                    <label for="name_en" class="label">Category Name (English)</label>
                    <div class="underline"></div>
                </div>

                {{-- Name --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="name_ar" name="name_ar" required
                        style="width: 100%;" placeholder="">
                    <label for="name_ar" class="label">Category Name (Arabic)</label>
                    <div class="underline"></div>
                </div>

                {{-- Name --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="name_ku" name="name_ku" required
                        style="width: 100%;" placeholder="">
                    <label for="name_ku" class="label">Category Name (Kurdish)</label>
                    <div class="underline"></div>
                </div>

                {{-- Visibility Toggle --}}
                <div class="checkbox-wrapper-8 mb-5">
                    <label for="visible" class="visible-label">Visible</label>
                    <input type="checkbox" id="visible" name="visible" class="tgl" value="1"
                        {{ old('visible', true) ? 'checked' : '' }}>
                    <label for="visible" class="tgl-btn" data-tg-on="Yes" data-tg-off="No"></label>
                </div>

                {{-- Image Dominance --}}
                <div class="mb-5">
                    <label class="form-label fw-semibold d-block mb-1">Image Dominance</label>
                    <p class="text-muted small mb-2">Controls how product images in this category are displayed.</p>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dominance" id="dominance_height" value="height"
                                {{ old('dominance', 'height') == 'height' ? 'checked' : '' }}>
                            <label class="form-check-label" for="dominance_height">
                                <i class="bi bi-phone me-1"></i> Height Dominant (Portrait — tall images)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dominance" id="dominance_width" value="width"
                                {{ old('dominance') == 'width' ? 'checked' : '' }}>
                            <label class="form-check-label" for="dominance_width">
                                <i class="bi bi-tv me-1"></i> Width Dominant (Landscape — wide images)
                            </label>
                        </div>
                    </div>
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