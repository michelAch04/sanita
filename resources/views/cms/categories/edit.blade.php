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

    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>

            <label for="hidden">Hidden</label>
            <select id="hidden" name="hidden" class="form-control" required>
                <option value="0" {{ old('hidden', $category->hidden) == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('hidden', $category->hidden) == 1 ? 'selected' : '' }}>Yes</option>
            </select>

            <label for="image" class="mt-3">Update Image</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">

            @if ($category->extension)
            <img src="{{ asset('storage/categories/' . $category->id . '.' . $category->extension) }}" alt="{{ $category->name }}" class="img-thumbnail mt-2" style="width: 100px; height: 100px;">
            @else
            <span class="text-muted">No Image</span>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection