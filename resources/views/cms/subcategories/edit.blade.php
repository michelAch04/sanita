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

<style>
    /* Match your input field */
    .select2-container--default .select2-selection--single {
        background: transparent;
        border: none;
        border-bottom: 2px solid #ccc;
        border-radius: 0;
        height: 36px;
        padding-left: 0;
        transition: all 0.3s ease;
    }

    .select2-container--default .select2-selection--single:hover,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: teal;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #333;
        padding-left: 0;
        font-size: 16px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 5px;
    }

    /* Style the search input box inside Select2 dropdown */
    .select2-container .select2-search--dropdown .select2-search__field {
        border: none;
        outline: none;
        padding: 6px 10px;
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.4);
        /* subtle shadow */
        transition: all 0.3s ease;
        border-radius: 4px;
    }

    /* On focus: teal glow */
    .select2-container .select2-search--dropdown .select2-search__field:focus {
        box-shadow: 0 0 6px #38B2AC;
    }


    /* Always-active label above the field */
    .input-container .label {
        top: -20px;
        font-size: 16px;
        color: #38B2AC;
    }

    /* Select styling to match custom inputs */
    .styled-select {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 2px solid teal;
        font-size: 16px;
        color: #333;
        padding: 0;
        outline: none;
        transition: all 0.3s ease;
        appearance: none;
        /* Removes default arrow on some browsers */
    }

    /* Arrow fix for consistent look */
    .styled-select::-ms-expand {
        display: none;
    }

    /* Underline always visible and teal */
    .underline {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 2px;
        width: 100%;
        background-color: teal;
        transition: all 0.3s ease;
    }

    .select2-container--open~.underline,
    .select2-container--default.select2-container--focus~.underline {
        transform: scaleX(1);
    }

    /* Dropdown highlight */
    .select2-results__option--highlighted {
        background-color: #38B2AC !important;
        color: white;
        transition: all 0.2s ease;
    }
</style>

@endsection