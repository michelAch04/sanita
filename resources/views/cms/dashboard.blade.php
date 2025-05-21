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
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Orders</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Order Value</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <h3 class="mb-4">Order Timeline</h3>
    <div class="card shadow-sm">
        <div class="card-body">

        </div>
    </div>
</div>
@endsection