@extends('cms.layout')

@section('title', 'Edit Category')

@section('content')
    <div class="container mt-5">
        <h2>Edit Category</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>

                <label for="description" class="mt-3">Description</label>
                <textarea id="description" name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Update Category</button>
        </form>
    </div>
@endsection