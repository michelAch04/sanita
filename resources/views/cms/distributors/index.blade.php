@extends('cms.layout')

@section('title', 'Distributors List')

@section('content')
<div class="container py-4">

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Distributors List</h2>
        <a href="{{ route('distributor.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Distributor
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($distributors as $distributor)
            <tr>
                <td>{{ $distributor->name }}</td>
                <td>{{ $distributor->email }}</td>
                <td>{{ $distributor->mobile }}</td>
                <td>{{ $distributor->location }}</td>
                <td>
                    <a href="{{ route('distributor.edit', $distributor->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('distributor.addAddress', $distributor->id) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-geo-alt"></i> Add City
                    </a>
                    <a href="{{ route('distributor.stocks', $distributor->id) }}" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-box-seam"></i> Add Stock
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No distributors found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection