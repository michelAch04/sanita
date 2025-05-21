@extends('cms.layout')

@section('title', 'Categories')

@section('content')
<div class="container mt-5">
    <h2>Categories</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Hidden</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>
                    @if ($category->id)
                    <img src="{{ asset('storage/categories/' . $category->id . '.' . $category->extension) }}" alt="{{ $category->name }}" width="50">
                    @else
                    No Image
                    @endif
                </td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->hidden ? 'Yes' : 'No' }}</td>
                <td>{{ $category->created_at }}</td>
                <td>{{ $category->updated_at }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
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