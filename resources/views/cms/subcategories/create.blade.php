@extends('cms.layout')

@section('title', 'Add Subcategory')

@section('content')
    <div class="container mt-5">
        <h2>Add Subcategory</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">Select a Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <label for="name" class="mt-3">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>

                <label for="hidden" class="mt-3">Hidden</label>
                <select id="hidden" name="hidden" class="form-control" required>
                    <option value="0" {{ old('hidden') == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('hidden') == 1 ? 'selected' : '' }}>Yes</option>
                </select>

                <label for="image" class="mt-3">Upload Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success">Add Subcategory</button>
        </form>
    </div>
@endsection