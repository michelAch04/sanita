@extends('cms.layout')

@section('title', 'Edit Subcategory')

@section('content')
<div class="container mt-3">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Edit Subcategory</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('subcategories.update', $subcategory->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Category Select --}}
                <div class="input-container mb-5 mt-3" style="width: 30%; position: relative; padding-top: 5px;">
                    <label for="categories_id" class="label">Category</label>
                    <select id="categories_id" name="categories_id" class="styled-select" required>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('categories_id', $subcategory->categories_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <div class="underline"></div>
                </div>

                {{-- Subcategory Name --}}
                <div class="input-container mb-3 mt-3" style="width: 30%;">
                    <input type="text" id="name" name="name" value="{{ old('name', $subcategory->name) }}" required style="width: 100%;">
                    <label for="name" class="label">Subcategory Name</label>
                    <div class="underline"></div>
                </div>

                {{-- Visibility Toggle --}}
                <div class="checkbox-wrapper-8 mb-5">
                    <label for="visible" class="visible-label">Visible</label>
                    <input type="checkbox" id="visible" name="visible" class="tgl" value="1"
                        {{ old('visible', !$subcategory->hidden) ? 'checked' : '' }}>
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

                    <!-- Existing Image -->
                    @if ($subcategory->extension)
                    <div class="d-flex flex-column mt-3">
                        <img src="{{ asset('storage/subcategories/' . $subcategory->id . '.' . $subcategory->extension) }}"
                            alt="Current Image"
                            class="img-thumbnail"
                            style="max-width: 150px;">
                        <p class="mb-1 text-muted small text-center text-decoration-underline">Current Image</p>
                    </div>
                    @endif
                </div>

                {{-- Submit & Cancel --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('subcategories.index') }}" class="btn bubbles bubbles-grey me-2">
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