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
                        <p class="card-text display-6">{{ $totalCustomers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Orders</h5>
                        <p class="card-text display-6">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Order Value</h5>
                        <p class="card-text display-6">${{ $totalOrderValue }}</p>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-3">
                <div class="card text-white bg-danger shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">Pending Orders</h5>
                        <p class="card-text display-6">{{ $pendingOrders }}</p>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Timeline -->
        <h3 class="mb-4">Order Timeline</h3>
        <div class="card shadow-sm">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach ($orders as $order)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Order #{{ $order->id }}</strong> - ${{ $order->amount }}
                            </div>
                            <span class="text-muted">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection