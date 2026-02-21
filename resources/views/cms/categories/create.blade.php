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
                <div class="select-container mb-5 mt-3" style="position: relative;">
                    <label class="label" style="top: -20px; color: var(--primary-color); font-size: 16px;">Image Dominance</label>
                    <div class="mt-2">
                        <label class="select-label">
                            <input type="radio" name="dominance" value="height"
                                {{ old('dominance', 'height') == 'height' ? 'checked' : '' }}>
                            <span><i class="bi bi-phone-fill me-1"></i> Portrait</span>
                        </label>
                        <label class="select-label">
                            <input type="radio" name="dominance" value="width"
                                {{ old('dominance', 'height') == 'width' ? 'checked' : '' }}>
                            <span><i class="bi bi-display me-1"></i> Landscape</span>
                        </label>
                        <label class="select-label">
                            <input type="radio" name="dominance" value="none"
                                {{ old('dominance', 'height') == 'none' ? 'checked' : '' }}>
                            <span><i class="bi bi-square me-1"></i> Square</span>
                        </label>
                    </div>
                    <small class="text-muted d-block mt-2">
                        <strong>Portrait</strong> — tall images (4:5). &nbsp; <strong>Landscape</strong> — wide images (5:3). &nbsp; <strong>Square</strong> — any image, no cropping (1:1).
                    </small>
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