@extends('cms.layout')

@section('title', 'Edit Category')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light text-black">
            <h4 class="mb-0">Edit Category</h4>
        </div>

        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="hidden" class="form-label">Hidden <span class="text-danger">*</span></label>
                    <select id="hidden" name="hidden" class="form-select" required>
                        <option value="0" {{ old('hidden', $category->hidden) == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('hidden', $category->hidden) == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Update Image</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*">

                    @if ($category->extension)
                    <img src="{{ asset('storage/categories/' . $category->id . '.' . $category->extension) }}"
                        alt="{{ $category->name }}"
                        class="img-thumbnail mt-2"
                        style="width: 100px; height: 100px;">
                    @else
                    <p class="text-muted mt-2">No Image Available</p>
                    @endif
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection