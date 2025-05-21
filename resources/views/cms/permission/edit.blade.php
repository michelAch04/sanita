@extends('cms.layout')

@section('title', 'Edit Permission')

@section('content')
<div class="container mt-5">
    <h2>Edit Permission</h2>
    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select id="user_id" name="user_id" class="form-select" required>
                @foreach($users as $user)
                <option value="{{ $user->id }}" @if($permission->user_id == $user->id) selected @endif>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <input type="text" id="role" name="role" class="form-control" value="{{ $permission->role }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Permissions</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="add" id="add" value="1" {{ $permission->add ? 'checked' : '' }}>
                <label class="form-check-label" for="add">Add</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="edit" id="edit" value="1" {{ $permission->edit ? 'checked' : '' }}>
                <label class="form-check-label" for="edit">Edit</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="delete" id="delete" value="1" {{ $permission->delete ? 'checked' : '' }}>
                <label class="form-check-label" for="delete">Delete</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="view" id="view" value="1" {{ $permission->view ? 'checked' : '' }}>
                <label class="form-check-label" for="view">View</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="excel" id="excel" value="1" {{ $permission->excel ? 'checked' : '' }}>
                <label class="form-check-label" for="excel">Excel</label>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Update Permission</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection