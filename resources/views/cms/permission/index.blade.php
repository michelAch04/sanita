@extends('cms.layout')

@section('title', 'Permissions')

@section('content')
<div class="container mt-5">
    <h2>Permissions</h2>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-3">Add Permission</a>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Permission Name</th>
                    <th>Can View</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th style="min-width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($permissions as $permission)
                <tr>
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->user->name ?? '-' }}</td>
                    <td>{{ $permission->name ?? '-' }}</td>
                    <td>
                        @if($permission->can_view ?? $permission->view)
                        <span class="badge bg-success">Yes</span>
                        @else
                        <span class="badge bg-danger">No</span>
                        @endif
                    </td>
                    <td>{{ $permission->created_at }}</td>
                    <td>{{ $permission->updated_at }}</td>
                    <td>
                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning btn-sm mb-1">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Are you sure you want to delete this permission?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mb-1">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No permissions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection