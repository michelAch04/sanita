@extends('cms.layout')

@section('title', 'Edit Order')

@section('content')
<div class="container mt-4">
    <h3>Edit Order #{{ $order->id }}</h3>

    <div class="card mb-4">
        <div class="card-header">Customer Information</div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer->email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer->mobile }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Shipping Address</div>
        <div class="card-body">
            <p><strong>Governorate:</strong> {{ $order->address->governorate->name_en ?? 'N/A' }}</p>
            <p><strong>District:</strong> {{ $order->address->district->name_en ?? 'N/A' }}</p>
            <p><strong>City:</strong> {{ $order->address->city->name_en ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Order Items</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty_ea</th>
                        <th>Qty_foreign</th>
                        <th>UOM </th>
                        <th>Unit Price</th>
                        <th>Shelf Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $item)
                    <tr>
                        <td>{{ $item->product->name_en ?? 'N/A' }}</td>
                        <td>{{ $item->quantity_primary }}</td>
                        <td>{{ $item->quantity_foreign }}</td>
                        <td>{{ $item->UOM}}</td>
                        <td>${{ number_format($item->unit_price, 2) }}</td>
                        <td>${{ number_format($item->shelf_price, 2) }}</td>
                        <td>${{ number_format($item->extended_price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Order Info</div>
        <div class="card-body">
            <p><strong>Status:</strong> {{ $order->status->description }}</p>
            <p><strong>Payment Method:</strong> {{ $order->payment_method ?? 'N/A' }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
            @if (!empty($order->promocode))
            <p><strong>Promo Code:</strong> {{ $order->promocode }}</p>
            <p><strong>Discount:</strong>
                @if (!empty($order->discount_percentage))
                {{ $order->discount_percentage }}%
                @elseif (!empty($order->discount_amount))
                ${{ number_format($order->discount_amount, 2) }}
                @else
                N/A
                @endif
            </p>
            <p><strong>Total After Discount:</strong> ${{ number_format($order->total_amount_after_discount, 2) }}</p>
            @endif
        </div>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
</div>
@endsection