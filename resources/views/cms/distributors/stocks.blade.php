@extends('cms.layout')

@section('title', 'Manage Stocks for ' . $distributor->name)

@section('content')
<div class="container py-4">
    <a href="{{ route('distributor.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Back to Distributors
    </a>

    <h2>Manage Stocks for {{ $distributor->name }}</h2>

    <form action="{{ route('distributor.storeStock', $distributor->id) }}" method="POST" class="mb-4">
        @csrf
        <div class="row g-2 align-items-end">
            <div class="col-md-6">
                <label for="products_id" class="form-label">Product</label>
                <select name="products_id" id="products_id" class="form-select" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name_en ?? $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" min="0" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Add/Update</button>
            </div>
        </div>
    </form>

    <h4>Current Stocks</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @forelse($distributor->stocks as $stock)
            <tr>
                <td>{{ $stock->product->sku }}</td>
                <td>{{ $stock->stock }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="text-center">No stock records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection