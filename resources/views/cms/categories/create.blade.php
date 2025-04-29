@extends('cms.layout')

@section('title', 'Add Category')

@section('content')
    <div class="container mt-5">
        <h2>Add Category</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>

                <label for="hidden" class="mt-3">Hidden</label>
                <select id="hidden" name="hidden" class="form-control" required>
                    <option value="0" {{ old('hidden') == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('hidden') == 1 ? 'selected' : '' }}>Yes</option>
                </select>

                <label for="image" class="mt-3">Upload Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success">Add Category</button>
        </form>
    </div>
@endsection