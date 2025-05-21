@extends('cms.layout')

@section('title', 'Edit Product')

@section('content')
<div class="container mt-5">
    <h2>Edit Product</h2>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            <label for="description" class="mt-3">Description</label>
            <textarea id="description" name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
            <label for="unit_price" class="mt-3">Price</label>
            <input type="number" id="unit_price" name="unit_price" class="form-control" step="0.01" value="{{ old('unit_price', $product->unit_price) }}" required>
            <label for="available_quantity" class="mt-3">Stock</label>
            <input type="number" id="available_quantity" name="available_quantity" class="form-control" value="{{ old('available_quantity', $product->available_quantity) }}" required>
            <label for="small_description">Small Description</label>
            <textarea id="small_description" name="small_description" class="form-control">{{ old('small_description', $product->small_description) }}</textarea>
            <label for="hidden" class="mt-3">Hidden</label>
            <select id="hidden" name="hidden" class="form-control" required>
                <option value="0" {{ old('hidden', $product->hidden) == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('hidden', $product->hidden) == 1 ? 'selected' : '' }}>Yes</option>
            </select>
            <label for="image" class="mt-3">Upload Image</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
            @if ($product->extension)
            <p class="mt-2">Current Image:
                <a href="{{ asset('storage/products/' . $product->image) }}" target="_blank">View Image</a>
            </p>
            @endif
        </div>
        <button type="submit" class="btn btn-success">Update Product</button>
    </form>
</div>
@endsection