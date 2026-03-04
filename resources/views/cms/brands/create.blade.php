@extends('cms.layout')

@section('title', 'Create Brand')

@section('content')
<div class="ps-5 mt-3">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Create Brand</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Brand Name --}}
                <div class="input-container mb-5 mt-3">
                    <input type="text" id="name_en" name="name_en" value="{{ old('name_en') }}" required placeholder="">
                    <label for="name_en" class="label">Brand Name (En)</label>
                    <div class="underline"></div>
                </div>

                {{-- Brand Name --}}
                <div class="input-container mb-5 mt-3">
                    <input type="text" id="name_ar" name="name_ar" value="{{ old('name_ar') }}" required placeholder="">
                    <label for="name_ar" class="label">Brand Name (Ar)</label>
                    <div class="underline"></div>
                </div>

                {{-- Brand Name --}}
                <div class="input-container mb-5 mt-3">
                    <input type="text" id="name_ku" name="name_ku" value="{{ old('name_ku') }}" required placeholder="">
                    <label for="name_ku" class="label">Brand Name (Ku)</label>
                    <div class="underline"></div>
                </div>

                {{-- Visible --}}
                <div class="checkbox-wrapper-8 mb-5">
                    <label for="visible" class="visible-label">Visible</label>
                    <input type="checkbox" id="visible" name="visible" class="tgl" value="1" checked>
                    <label for="visible" class="tgl-btn" data-tg-on="Yes" data-tg-off="No"></label>
                </div>

                {{-- Upload Image --}}
                <div class="d-flex align-items-start gap-4 mb-4 flex-wrap upload-container">
                    <!-- Custom Upload Button -->
                    <div>
                        <label for="image" id="imageLabel" class="btn underline-btn">Upload Image</label>
                        <input type="file" id="image" name="image" accept="image/*" hidden required>
                        <small class="text-muted d-block mt-1">Best ratio: 4:5 portrait (e.g. 560×700 px)</small>
                    </div>

                    <!-- Image Preview -->
                    <div id="previewContainer" style="display: none;">
                        <img id="imagePreview" src="#" alt="Selected Image" class="img-thumbnail" style="max-width: 150px;">
                        <div id="fileName" class="text-muted mt-2 small text-center text-decoration-underline mb-1"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('brands.index') }}" class="btn bubbles bubbles-grey me-2">
                        <span class="text">Cancel</span></a>
                    <button type="submit" class="btn bubbles"><span class="text">Create</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection