@extends('cms.layout')

@section('title', 'Edit Subcategory')

@section('content')
    <div class="container mt-5">
        <h2>Edit Subcategory</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('subcategories.update', $subcategory->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <label for="name" class="mt-3">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $subcategory->name) }}" required>

             </div>
            <button type="submit" class="btn btn-success">Update Subcategory</button>
        </form>
    </div>
@endsection