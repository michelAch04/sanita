@extends('cms.layout')

@section('title', 'Manage Carts')

@section('content')
<div class="container mt-5">
    <h2>Manage Carts</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cart ID</th>
                <th>Customer Name</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carts as $cart)
            <tr>
                <td>{{ $cart->id }}</td>
                <td>{{ $cart->customer->name }}</td>
                <td>{{ $cart->created_at }}</td>
                <td>{{ $cart->updated_at }}</td>
                <td>
                    <a href="{{ route('admin.carts.edit', $cart->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.carts.destroy', $cart->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection