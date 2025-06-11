@extends('cms.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <!-- Welcome Message -->
    <div class="text-center mb-5">
        <h1 class="display-4">Welcome, {{ Auth::user()->name }}</h1>
        <p class="text-muted">Here's an overview of your system's performance.</p>
    </div>

    <!-- Dashboard Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Customers</h5>
                    <h2>{{ $totalCustomers }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Orders</h5>
                    <h2>{{ $totalOrders }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Order Value</h5>
                    <h2>${{ number_format($totalOrderValue, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>


    <!-- Timeline -->
    <h3 class="mb-4">Order Timeline</h3>
    <div class="card shadow-sm">
        <div class="card-body">
            @if($orders->isEmpty())
            <p class="text-muted">No recent orders found.</p>
            @else
            <ul class="list-group list-group-flush">
                @foreach($orders as $order)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Order #{{ $order->id }}</strong><br>
                        Customer: {{ $order->customer->name ?? 'N/A' }}<br>
                        Placed on: {{ $order->created_at->format('M d, Y h:i A') }}
                    </div>
                    <span class="badge bg-primary">${{ number_format($order->total_amount, 2) }}</span>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>

</div>
@endsection