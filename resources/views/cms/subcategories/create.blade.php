@extends('cms.layout')

@section('title', 'Add Subcategory')

@section('content')
<div class="container mt-3">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Create Subcategory</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Category Select --}}
                <div class="input-container mb-5 mt-3" style="width: 30%; position: relative; padding-top: 5px;">
                    <label for="categories_id" class="label">Category</label>
                    <select id="categories_id" name="categories_id" class="styled-select" required>
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <div class="underline"></div>
                </div>

                {{-- Subcategory Name --}}
                <div class="input-container mb-3 mt-3" style="width: 30%;">
                    <input type="text" id="name" name="name" required style="width: 100%;">
                    <label for="name" class="label">Subcategory Name</label>
                    <div class="underline"></div>
                </div>

                {{-- Visible Toggle Switch --}}
                <div class="checkbox-wrapper-8 mb-5">
                    <label for="visible" class="visible-label">Visible</label>
                    <input type="checkbox" id="visible" name="hidden" class="tgl" value="0" {{ old('hidden') == '0' ? 'checked' : '' }}>
                    <label for="visible" class="tgl-btn" data-tg-on="Yes" data-tg-off="No"></label>
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
                    <a href="{{ route('subcategories.index') }}" class="btn bubbles bubbles-grey me-2">
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

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#categories_id').select2({
            placeholder: 'Select a category',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush

@endsection