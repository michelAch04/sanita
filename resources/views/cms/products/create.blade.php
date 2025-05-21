@extends('cms.layout')

@section('title', 'Create Product')

@section('content')
<div class="container mt-5">
    <h2>Create Product</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" required>

            <label for="sku">SKU</label>
            <input type="text" id="sku" name="sku" class="form-control" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control"></textarea>

            <label for="small_description">Small Description</label>
            <input type="text" id="small_description" name="small_description" class="form-control">

            <label for="unit_price">Unit Price</label>
            <input type="number" id="unit_price" name="unit_price" class="form-control" required>

            <label for="shelf_price">Shelf Price</label>
            <input type="number" id="shelf_price" name="shelf_price" class="form-control" required>

            <label for="threshold">Threshold</label>
            <input type="number" id="threshold" name="threshold" class="form-control" required>

            <label for="tax">Tax</label>
            <input type="number" id="tax" name="tax" class="form-control" required>

            <label for="available_quantity">Available Quantity</label>
            <input type="number" id="available_quantity" name="available_quantity" class="form-control" required>

            <label for="hidden">Hidden</label>
            <select id="hidden" name="hidden" class="form-control" required>
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>

            <label for="automatic_hide">Automatic Hide</label>
            <select id="automatic_hide" name="automatic_hide" class="form-control" required>
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>

            <label for="image">Image</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Create Product</button>
    </form>
</div>
@endsection