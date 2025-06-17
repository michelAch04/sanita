@extends('cms.layout')

@section('title', 'Edit Product')

@section('content')
<div class="ps-5 mt-3">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Edit Product</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Product Name_En --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="name_en" name="name_en" value="{{ old('name_en', $product->name_en) }}" required
                        style="width: 100%;" placeholder="">
                    <label for="name_en" class="label">Product Name (English)</label>
                    <div class="underline"></div>
                </div>

                {{-- Product Name_Ar --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="name_ar" name="name_ar" value="{{ old('name_ar', $product->name_ar) }}" required
                        style="width: 100%;" placeholder="">
                    <label for="name_ar" class="label">Product Name (Arabic)</label>
                    <div class="underline"></div>
                </div>

                {{-- Product Name_Ku --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="name_ku" name="name_ku" value="{{ old('name_ku', $product->name_ku) }}" required
                        style="width: 100%;" placeholder="">
                    <label for="name_ku" class="label">Product Name (Kurdish)</label>
                    <div class="underline"></div>
                </div>

                {{-- Small Description_En --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <textarea id="small_description_en" name="small_description_en" class="mt-2" placeholder="">{{ old('small_description_en', $product->small_description_en) }}</textarea>
                    <label for="small_description_en" class="label">Small Description (English)</label>
                    <div class="underline"></div>
                </div>

                {{-- Small Description_Ar --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <textarea id="small_description_ar" name="small_description_ar" class="mt-2" placeholder="">{{ old('small_description_ar', $product->small_description_ar) }}</textarea>
                    <label for="small_description_ar" class="label">Small Description (Arabic)</label>
                    <div class="underline"></div>
                </div>

                {{-- Small Description_Ku --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <textarea id="small_description_ku" name="small_description_ku" class="mt-2" placeholder="">{{ old('small_description_ku', $product->small_description_ku) }}</textarea>
                    <label for="small_description_ku" class="label">Small Description (kurdish)</label>
                    <div class="underline"></div>
                </div>

                {{-- Unit Price --}}
                <div class="input-container mb-5">
                    <input type="number" id="unit_price" name="unit_price" step="0.01" value="{{ old('unit_price', $product->unit_price) }}" required>
                    <label for="unit_price" class="label">Price</label>
                    <div class="underline"></div>
                </div>

                {{-- Tax Toggle --}}
                <div class="input-container mb-5 mt-3" style="width: 30%; position: relative; padding-top: 5px;">
                    <label for="tax_id" class="visible-label">Tax</label>
                    <select name="tax_id" id="tax_id" class="form-select">
                        <option value="">No VAT</option>
                        @foreach($taxes as $tax)
                        <option value="{{ $tax->id }}"
                            data-rate="{{ $tax->rate }}"
                            {{ old('tax_id', $product->tax_id ?? '') == $tax->id ? 'selected' : '' }}>
                            {{ $tax->name }} ({{ $tax->rate }}%)
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Shelf Price --}}
                <div class="input-container mb-5">
                    <input type="number" id="shelf_price" name="shelf_price" step="0.01" value="{{ old('shelf_price', $product->shelf_price) }}" readonly placeholder="">
                    <label for="shelf_price" class="label">Shelf Price</label>
                </div>

                {{-- Old Price --}}
                <div class="input-container mb-5">
                    <input type="number" id="old_price" name="old_price" step="0.01" value="{{ old('old_price', $product->old_price) }}" placeholder="">
                    <label for="old_price" class="label">Old Price</label>
                    <div class="underline"></div>
                </div>

                {{-- Available Quantity --}}
                <div class="input-container mb-5">
                    <input type="number" id="available_quantity" name="available_quantity" value="{{ old('available_quantity', $product->available_quantity) }}" required>
                    <label for="available_quantity" class="label">Stock</label>
                    <div class="underline"></div>
                </div>

                {{-- Subcategory Select --}}
                <div class="input-container mb-5 mt-3" style="width: 30%; position: relative; padding-top: 5px;">
                    <label for="subcategories_id" class="select2-label">Subcategory</label>
                    <select id="subcategories_id" name="subcategories_id" class="styled-select" required>
                        @foreach ($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}"
                            {{ old('subcategories_id', $product->subcategories_id) == $subcategory->id ? 'selected' : '' }}>
                            {{ $subcategory->name_en }}
                        </option>
                        @endforeach
                    </select>
                    <div class="underline"></div>
                </div>

                {{-- Brand Select --}}
                <div class="input-container mb-5 mt-3" style="width: 30%; position: relative; padding-top: 5px;">
                    <label for="brands_id" class="select2-label">Brand</label>
                    <select id="brands_id" name="brands_id" class="styled-select" required>
                        @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ old('brands_id', $product->brands_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name_en }}
                        </option>
                        @endforeach
                    </select>
                    <div class="underline"></div>
                </div>


                {{-- Visibility Toggle --}}
                <div class="checkbox-wrapper-8 mb-5">
                    <label for="visible" class="visible-label">Visible</label>
                    <input type="checkbox" id="visible" name="visible" class="tgl" value="1"
                        {{ old('visible', !$product->hidden) ? 'checked' : '' }}>
                    <label for="visible" class="tgl-btn" data-tg-on="Yes" data-tg-off="No"></label>
                </div>

                {{-- Automatic Hide Toggle --}}
                <div class="checkbox-wrapper-8 mb-5">
                    <label for="automatic_hide" class="visible-label">Automatic Hide</label>
                    <input type="checkbox" id="automatic_hide" name="automatic_hide" class="tgl" value="1"
                        {{ old('automatic_hide', $product->automatic_hide) ? 'checked' : '' }}>
                    <label for="automatic_hide" class="tgl-btn" data-tg-on="Yes" data-tg-off="No"></label>
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
                    @if ($product->extension)
                    <div class="d-flex flex-column mt-3">
                        <img src="{{ asset('storage/products/' . $product->id . '.' . $product->extension) }}" alt="Current Image" class="img-thumbnail" style="max-width: 150px;">
                        <p class="mb-1 text-muted small text-center text-decoration-underline">Current Image</p>
                    </div>
                    @endif

                </div>

                {{-- Submit & Cancel --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('products.index') }}" class="btn bubbles bubbles-grey me-2">
                        <span class="text">Cancel</span></a>
                    <button type="submit" class="btn bubbles"><span class="text">Update</span></button>
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
        $('#subcategories_id').select2({
            placeholder: 'Select a subcategory',
            allowClear: true,
            width: '100%'
        });
    });
    $(document).ready(function() {
        $('#brands_id').select2({
            placeholder: 'Select a brand',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
@include('cms.partials.select2-style')
@endsection
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tax_id').select2({
            placeholder: 'Select a brand',
            allowClear: true,
            width: '100%'
        });
    });

    $(document).ready(function() {
        $('#tax_id').select2({
            placeholder: 'Select a tax',
            allowClear: true,
            width: '100%'
        });

        function updateShelfPrice() {
            let unitPrice = parseFloat($('#unit_price').val());
            let taxRate = parseFloat($('#tax_id option:selected').data('rate')) || 0;
            let shelfPrice = unitPrice;

            if (taxRate > 0) {
                shelfPrice = unitPrice + (unitPrice * (taxRate / 100));
            }

            $('#shelf_price').val(shelfPrice.toFixed(2));
        }

        // Listen to changes in unit price
        $('#unit_price').on('input', function() {
            updateShelfPrice();
        });

        // Listen to changes in tax select
        $('#tax_id').on('change', function() {
            updateShelfPrice();
        });
    });
</script>
@endpush