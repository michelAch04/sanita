@extends('cms.layout')

@section('title', 'Create Product')

@section('content')
<div class="ps-5 mt-3">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Create Product</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label class="form-label">SKU</label>
                        <input type="text" class="form-control" name="sku" value="{{ old('sku') }}" required>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Product Name (English)</label>
                        <input type="text" class="form-control" name="name_en" value="{{ old('name_en') }}" required>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Product Name (Arabic)</label>
                        <input type="text" class="form-control" name="name_ar" value="{{ old('name_ar') }}" required>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Product Name (Kurdish)</label>
                        <input type="text" class="form-control" name="name_ku" value="{{ old('name_ku') }}" required>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Small Description (English)</label>
                        <textarea class="form-control" name="small_description_en">{{ old('small_description_en') }}</textarea>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Small Description (Arabic)</label>
                        <textarea class="form-control" name="small_description_ar">{{ old('small_description_ar') }}</textarea>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Small Description (Kurdish)</label>
                        <textarea class="form-control" name="small_description_ku">{{ old('small_description_ku') }}</textarea>
                    </div>

                    <div class="col-md-2 mb-4">
                        <label class="form-label">EA/CA</label>
                        <input type="number" class="form-control" name="ea_ca" value="{{ old('ea_ca') }}" required>
                    </div>

                    <div class="col-md-2 mb-4">
                        <label class="form-label">EA/PA</label>
                        <input type="number" class="form-control" name="ea_pa" value="{{ old('ea_pa') }}" required>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Subcategory</label>
                        <select name="subcategories_id" class="form-select select2" required>
                            <option value="">Select Subcategory</option>
                            @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}" {{ old('subcategories_id') == $subcategory->id ? 'selected' : '' }}>
                                {{ $subcategory->name_en }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Brand</label>
                        <select name="brands_id" class="form-select select2" required>
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brands_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name_en }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Tax</label>
                        <select name="tax_id" class="form-select select2">
                            <option value="">No VAT</option>
                            @foreach ($taxes as $tax)
                            <option value="{{ $tax->id }}" data-rate="{{ $tax->rate }}" {{ old('tax_id') == $tax->id ? 'selected' : '' }}>
                                {{ $tax->name }} ({{ $tax->rate }}%)
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-4">
                        <label class="form-label">Upload Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                    </div>
                </div>

                <hr>
                <h5>B2B Price</h5>
                @include('cms.partials.price_fields', ['prefix' => 'b2b', 'data' => null])

                <hr>
                <h5>B2C Price</h5>
                @include('cms.partials.price_fields', ['prefix' => 'b2c', 'data' => null])

                <div class="mt-4 text-end">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
@endpush