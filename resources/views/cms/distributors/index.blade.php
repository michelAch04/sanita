@extends('cms.layout')

@section('title', 'Distributors List')

@section('content')
<div class="container py-4">

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h2>Distributors List</h2>

    <a href="{{ route('distributor.create') }}" class="btn btn-primary mb-3">Add New Distributor</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($distributors as $distributor)
            <tr>
                <td>{{ $distributor->name }}</td>
                <td>{{ $distributor->email }}</td>
                <td>{{ $distributor->mobile }}</td>
                <td>{{ $distributor->location }}</td>
                <td>
                    <a href="{{ route('distributor.edit', $distributor->id) }}" class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection