@extends('cms.layout')

@section('title', 'Create Brand')

@section('content')
    <div class="container mt-5">
        <h2>Create Brand</h2>
        <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>

                <label for="hidden" class="mt-3">Hidden</label>
                <select id="hidden" name="hidden" class="form-control" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>

                <label for="image" class="mt-3">Upload Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-success">Create</button>
        </form>
    </div>
@endsection