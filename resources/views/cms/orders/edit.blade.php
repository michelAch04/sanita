@extends('cms.layout')

@section('title', 'Edit Order')

@section('content')
    <div class="container mt-5">
        <h2>Edit Order</h2>

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

        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="customer_id">Customer</label>
                <select id="customer_id" name="customer_id" class="form-control" required>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id', $order->customer_id) == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>

                <label for="status" class="mt-3">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <label for="total_price" class="mt-3">Total Price</label>
                <input type="number" id="total_price" name="total_price" class="form-control" step="0.01" value="{{ old('total_price', $order->total_price) }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update Order</button>
        </form>
    </div>
@endsection