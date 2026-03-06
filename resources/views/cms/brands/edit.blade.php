@extends('cms.layout')

@section('title', 'Edit Brand')

@section('content')
<div class="ps-5 mt-3">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Edit Brand</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Brand Name En --}}
                <div class="input-container mb-5 mt-3">
                    <input type="text" id="name_en" name="name_en" value="{{ old('name_en', $brand->name_en) }}" required>
                    <label for="name_en" class="label">Brand Name (En)</label>
                    <div class="underline"></div>
                </div>

                {{-- Brand Name Ar --}}
                <div class="input-container mb-5 mt-3">
                    <input type="text" id="name_ar" name="name_ar" value="{{ old('name_ar', $brand->name_ar) }}" required>
                    <label for="name_ar" class="label">Brand Name (Ar)</label>
                    <div class="underline"></div>
                </div>

                {{-- Brand Name Ku --}}
                <div class="input-container mb-5 mt-3">
                    <input type="text" id="name_ku" name="name_ku" value="{{ old('name_ku', $brand->name_ku) }}" required>
                    <label for="name_ku" class="label">Brand Name (Ku)</label>
                    <div class="underline"></div>
                </div>

                {{-- Hidden --}}
                <div class="checkbox-wrapper-8 mb-5">
                    <label for="visible" class="visible-label">Visible</label>
                    <input type="checkbox" id="visible" name="visible" class="tgl" value="1"
                        {{ old('visible', !$brand->hidden) ? 'checked' : '' }}>
                    <label for="visible" class="tgl-btn" data-tg-on="Yes" data-tg-off="No"></label>
                </div>

                {{-- Linked Categories --}}
                @if($categories->isNotEmpty())
                <div class="mb-5">
                    <label class="form-label fw-semibold mb-3" style="color: var(--primary-color); font-size: 16px;">Linked Categories</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]"
                                id="cat_{{ $category->id }}" value="{{ $category->id }}"
                                {{ in_array($category->id, old('categories', $selectedCategories)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="cat_{{ $category->id }}">
                                {{ $category->name_en }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Upload Image --}}
                <div class="d-flex align-items-start gap-4 mb-4 flex-wrap upload-container">
                    <!-- Custom Upload Button -->
                    <div>
                        <label for="image" id="imageLabel" class="btn underline-btn">Upload Image</label>
                        <input type="file" id="image" name="image" accept="image/*" hidden>
                        <small class="text-muted d-block mt-1">Best ratio: 4:5 portrait (e.g. 560×700 px)</small>
                    </div>

                    <!-- Image preview -->
                    <div id="previewContainer" style="display: none;">
                        <img id="imagePreview" src="#" alt="Selected Image" class="img-thumbnail" style="max-width: 150px;">
                        <div id="fileName" class="text-muted mt-2 small text-center text-decoration-underline mb-1"></div>
                    </div>

                    <!-- Existing image -->
                    @if ($brand->extension)
                    <div class="d-flex flex-column">
                        <p class="mb-1 text-muted small">Current Image:</p>
                        <a href="{{ asset('storage/brands/' . $brand->id . '.' . $brand->extension) }}" target="_blank" class="btn btn-outline-secondary btn-sm">View Current</a>
                    </div>
                    @endif
                </div>


                <div class="d-flex justify-content-end">
                    <a href="{{ route('brands.index') }}" class="btn bubbles bubbles-grey me-2">
                        <span class="text">Cancel</span></a>
                    <button type="submit" class="btn bubbles"><span class="text">Update</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection