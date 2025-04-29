@extends('cms.layout')

@section('title', 'Add Product')

@section('content')
    <div class="container mt-5">
        <h2>Add Product</h2>

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

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
                <label for="description" class="mt-3">Description</label>
                <textarea id="description" name="description" class="form-control"></textarea>
                <label for="price" class="mt-3">Price</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                <label for="quantity" class="mt-3">quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" required>
                <label for="hidden" class="mt-3">Hidden</label>
                <select id="hidden" name="hidden" class="form-control" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
                <label for="image" class="mt-3">Upload Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success">Add Product</button>
        </form>
    </div>
@endsection