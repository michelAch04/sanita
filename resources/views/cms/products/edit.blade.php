@extends('cms.layout')

@section('title', 'Edit Product')

@section('content')
<div class="ps-5 mt-3">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Edit Product</h2>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button">Product Info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="b2b-tab" data-bs-toggle="tab" data-bs-target="#b2b" type="button">B2B</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="b2c-tab" data-bs-toggle="tab" data-bs-target="#b2c" type="button">B2C</button>
                </li>
            </ul>

            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="tab-content" id="productTabsContent">
                    {{-- Product Info --}}
                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                        <h5 class="mb-5">Product Information</h5>

                        <div class="input-container mb-5 mt-3" style="width: 30%;">
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required placeholder="">
                            <label class="label">SKU</label>
                            <div class="underline"></div>
                        </div>

                        @foreach ([
                        'name_en' => 'Product Name (English)',
                        'name_ar' => 'Product Name (Arabic)',
                        'name_ku' => 'Product Name (Kurdish)'
                        ] as $field => $label)
                        <div class="input-container mb-5 mt-3" style="width: 30%;">
                            <input type="text" name="{{ $field }}" value="{{ old($field, $product->$field) }}" required placeholder="">
                            <label class="label">{{ $label }}</label>
                            <div class="underline"></div>
                        </div>
                        @endforeach

                        @foreach ([
                        'small_description_en' => 'Small Description (EN)',
                        'small_description_ar' => 'Small Description (AR)',
                        'small_description_ku' => 'Small Description (KU)'
                        ] as $field => $label)
                        <div class="input-container mb-5 mt-3" style="width: 30%;">
                            <textarea name="{{ $field }}" rows="2">{{ old($field, $product->$field) }}</textarea>
                            <label class="label" style="top: -25px;">{{ $label }}</label>
                            <div class="underline"></div>
                        </div>
                        @endforeach

                        <div class="input-container mb-5 mt-3" style="width: 30%;">
                            <input type="number" name="ea_ca" value="{{ old('ea_ca', $product->ea_ca) }}" required placeholder="">
                            <label class="label">EA/CA</label>
                            <div class="underline"></div>
                        </div>

                        <div class="input-container mb-5 mt-3" style="width: 30%;">
                            <input type="number" name="ea_pl" value="{{ old('ea_pl', $product->ea_pl) }}" required placeholder="">
                            <label class="label">EA/PL</label>
                            <div class="underline"></div>
                        </div>

                        {{-- Select2 Dropdowns --}}
                        @php
                        $selectFields = [
                        'subcategories_id' => ['Subcategory', $subcategories],
                        'brands_id' => ['Brand', $brands],
                        'tax_id' => ['Tax', $taxes]
                        ];
                        @endphp

                        @foreach ($selectFields as $name => [$labelText, $options])
                        <div class="input-container mb-5 mt-3" style="width: 30%; position: relative; padding-top: 5px;">
                            <label for="{{ $name }}" class="label select2-label">{{ $labelText }}</label>
                            <select id="{{ $name }}" name="{{ $name }}" class="styled-select select2" {{ $name !== 'tax_id' ? 'required' : '' }}>
                                <option value="" disabled hidden>Select {{ $labelText }}</option>
                                @foreach ($options as $option)
                                <option value="{{ $option->id }}" {{ old($name, $product->$name) == $option->id ? 'selected' : '' }}>
                                    {{ $option->name_en ?? $option->name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="underline"></div>
                        </div>
                        @endforeach

                        {{-- Image Upload --}}
                        <div class="d-flex align-items-start gap-4 mb-4 flex-wrap upload-container">
                            <div>
                                <label for="image" id="imageLabel" class="btn underline-btn">Upload Image</label>
                                <input type="file" id="image" name="image" accept="image/*" hidden>
                                @error('image')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($product->image)
                            <div id="previewContainer" style="display: block;">
                                <img id="imagePreview" src="{{ asset('storage/'.$product->image) }}" alt="Current Image" class="img-thumbnail" style="max-width: 150px;">
                                <div id="fileName" class="text-muted mt-2 small text-center text-decoration-underline mb-1">{{ basename($product->image) }}</div>
                            </div>
                            @else
                            <div id="previewContainer" style="display: none;">
                                <img id="imagePreview" src="#" alt="Selected Image" class="img-thumbnail" style="max-width: 150px;">
                                <div id="fileName" class="text-muted mt-2 small text-center text-decoration-underline mb-1"></div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- B2B Tab --}}
                    <div class="tab-pane fade" id="b2b" role="tabpanel">
                        <h5 class="mb-2">B2B Price</h5>
                        @include('cms.partials.price_fields', ['prefix' => 'b2b', 'data' => $data])
                    </div>

                    {{-- B2C Tab --}}
                    <div class="tab-pane fade" id="b2c" role="tabpanel">
                        <h5 class="mb-2">B2C Price</h5>
                        @include('cms.partials.price_fields', ['prefix' => 'b2c', 'data' => $data])
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('products.index') }}" class="btn bubbles bubbles-grey me-2">
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
        $('.select2').select2({
            placeholder: 'Select an option',
            width: '100%'
        });
    });
</script>
@endpush

@include('cms.partials.select2-style')
@endsection