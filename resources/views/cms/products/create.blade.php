@extends('cms.layout')

@section('title', 'Create Product')

@section('content')
<div class="ps-5 mt-3">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Create Product</h2>
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

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="tab-content" id="productTabsContent">
                    {{-- Product Info Tab --}}
                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                        <h5 class="mb-5">Product Information</h5>

                        <div class="input-container mb-5 mt-3" style="width: 30%;">
                            <input type="text" name="sku" value="{{ old('sku') }}" required style="width: 100%;" placeholder="">
                            <label class="label">SKU</label>
                            <div class="underline"></div>
                        </div>

                        <div class="input-container mb-5 mt-3" style="width: 30%;">
                            <input type="text" name="barcode" value="{{ old('barcode') }}" required style="width: 100%;" placeholder="">
                            <label class="label">Barcode</label>
                            <div class="underline"></div>
                        </div>

                        @foreach ([
                        'name_en' => 'Product Name (English)',
                        'name_ar' => 'Product Name (Arabic)',
                        'name_ku' => 'Product Name (Kurdish)'
                        ] as $field => $label)
                        <div class="input-container mb-5 mt-3" style="width: 30%;">
                            <input type="text" name="{{ $field }}" value="{{ old($field) }}" required style="width: 100%;" placeholder="">
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
                            <textarea name="{{ $field }}" rows="2" style="width: 100%;">{{ old($field) }}</textarea>
                            <label class="label" style="top: -25px;">{{ $label }}</label>
                            <div class="underline"></div>
                        </div>
                        @endforeach

                        <div class="input-container mb-5 mt-3" style="width: 30%;">
                            <input type="number" name="ea_ca" value="{{ old('ea_ca') }}" required style="width: 100%;" placeholder="">
                            <label class="label">EA/CA</label>
                            <div class="underline"></div>
                        </div>

                        <div class="input-container mb-5 mt-3" style="width: 30%;">
                            <input type="number" name="ea_pl" value="{{ old('ea_pl') }}" required style="width: 100%;" placeholder="">
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
                            <select id="{{ $name }}" name="{{ $name }}" class="styled-select select2" required>
                                <option value="" disabled selected hidden>Select {{ $labelText }}</option>
                                @foreach ($options as $option)
                                <option value="{{ $option->id }}" {{ old($name) == $option->id ? 'selected' : '' }}>
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
                                <input type="file" id="image" name="image" accept="image/*" hidden required>
                                @error('image')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="previewContainer" style="display: none;">
                                <img id="imagePreview" src="#" alt="Selected Image" class="img-thumbnail" style="max-width: 150px;">
                                <div id="fileName" class="text-muted mt-2 small text-center text-decoration-underline mb-1"></div>
                            </div>
                        </div>
                    </div>

                    {{-- B2B Tab --}}
                    <div class="tab-pane fade" id="b2b" role="tabpanel">
                        <h5 class="mb-2">B2B Price</h5>
                        @include('cms.partials.price_fields', ['prefix' => 'b2b', 'data' => null])
                    </div>

                    {{-- B2C Tab --}}
                    <div class="tab-pane fade" id="b2c" role="tabpanel">
                        <h5 class="mb-2">B2C Price</h5>
                        @include('cms.partials.price_fields', ['prefix' => 'b2c', 'data' => null])
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('products.index') }}" class="btn bubbles bubbles-grey me-2">
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
        $('.select2').select2({
            placeholder: 'Select an option',
            width: '100%'
        });
    });

    window.taxRates = @json($taxes - > pluck('rate', 'id'));

    function getSelectedTaxRate() {
        const taxSelect = document.getElementById('tax_id');
        if (!taxSelect) return 0;
        const selectedId = taxSelect.value;
        return window.taxRates && window.taxRates[selectedId] ? parseFloat(window.taxRates[selectedId]) : 0;
    }

    function calculateShelfPrice(unitPrice, taxRate) {
        return (parseFloat(unitPrice) + (parseFloat(unitPrice) * taxRate / 100)).toFixed(2);
    }

    function updateShelfPrices() {
        const taxRate = getSelectedTaxRate();
        document.querySelectorAll('input[id$="_unit_price"]').forEach(unitInput => {
            const shelfInputId = unitInput.id.replace('unit_price', 'shelf_price');
            const shelfInput = document.getElementById(shelfInputId);
            if (shelfInput) {
                shelfInput.value = calculateShelfPrice(unitInput.value || 0, taxRate);
            }
        });
    }

    // Listen for changes on unit price inputs
    document.querySelectorAll('input[id$="_unit_price"]').forEach(unitInput => {
        unitInput.addEventListener('input', updateShelfPrices);
        // Trigger once on load
        unitInput.dispatchEvent(new Event('input'));
    });

    // Listen for changes on tax select
    const taxSelect = document.getElementById('tax_id');
    if (taxSelect) {
        taxSelect.addEventListener('change', updateShelfPrices);
    }

    // Listen for Bootstrap tab shown event
    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(tabBtn => {
        tabBtn.addEventListener('shown.bs.tab', function() {
            updateShelfPrices();
        });
    });
</script>
@endpush
@include('cms.partials.select2-style')
@endsection