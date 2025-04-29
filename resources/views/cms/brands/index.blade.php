@extends('cms.layout')

@section('title', 'Brands')

@section('content')
    <div class="container mt-5">
        <h2>Brands</h2>
        <a href="{{ route('brands.create') }}" class="btn btn-primary mb-3">Create Brand</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>hidden</th>
                    <th>Extension</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand)
                    <tr>
                        <td>
                            @if ($brand->extension)
                                <a href="{{ asset('storage/brands/' . $brand->id . '.' . $brand->extension) }}" target="_blank">
                                    <img src="{{ asset('storage/brands/' . $brand->id . '.' . $brand->extension) }}" alt="{{ $brand->name }}" width="100">
                                </a>
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $brand->id }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>{{ $brand->hidden ? 'Yes' : 'No' }}</td>
                        <td>{{ $brand->extension}}</td>
                        <td>{{ $brand->created_at }}</td>
                        <td>{{ $brand->updated_at }}</td>
                        <td>
                            <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection