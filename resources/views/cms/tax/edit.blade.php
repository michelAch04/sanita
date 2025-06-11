@extends('cms.layout')

@section('title', 'Edit Tax')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header text-dark d-flex justify-content-between align-items-center m-2 mb-3">
            <h2 class="mb-0">Edit Tax</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('tax.update', $tax->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Tax Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $tax->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="rate" class="form-label">Rate (%)</label>
                    <input type="number" name="rate" id="rate" step="0.01" class="form-control" value="{{ old('rate', $tax->rate) }}" required>
                </div>

                <div class="mb-3">
                    <label for="active" class="form-label">Status</label>
                    <select name="active" id="active" class="form-select">
                        <option value="1" {{ old('active', $tax->active) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('active', $tax->active) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection