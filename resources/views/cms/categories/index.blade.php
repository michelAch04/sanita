@extends('cms.layout')

@section('title', 'Categories')

@php
use App\Models\Permission;
$permissions = Permission::with('page')
->join('pages', 'permissions.pages_id', '=', 'pages.id')
->where('permissions.users_id', auth()->user()->id)
->where('pages.name', 'Categories')
->first();
$canAdd = $permissions && $permissions->add;
$canEdit = $permissions && $permissions->edit;
$canDelete = $permissions && $permissions->delete;
@endphp

@section('content')
<div class="container mt-5">

    {{-- Header --}}
    <div class="card-header text-dark d-flex justify-content-between align-items-center m-2 mb-3">
        <h2 class="mb-0">Categories</h2>
        @if($canAdd)
        <a href="{{ route('categories.create') }}" class="btn btn-teal fw-medium">+ Create Category</a>
        @endif
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive rounded-1">
                <table class="table mb-0">
                    <thead class="bg-grey text-dark opacity-75">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Hidden</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th class="text-end">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr class="bg-hover-light-grey">
                            <td>{{ $category->id }}</td>
                            <td>
                                @php
                                $imagePath = 'storage/categories/' . $category->id . '.' . $category->extension;
                                @endphp
                                @if ($category->extension && file_exists(public_path($imagePath)))
                                <img src="{{ asset($imagePath) }}" alt="{{ $category->name }}" width="50" height="50" class="rounded">
                                @else
                                <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->hidden ? 'Yes' : 'No' }}</td>
                            <td>{{ $category->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $category->updated_at->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                @if($canEdit || $canDelete)
                                <div class="dropdown {{ $loop->first ? 'dropstart' : '' }}">
                                    <button class="btn btn-sm text-secondary rounded-circle border-0 bg-hover-teal" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu {{ $loop->first ? '' : 'dropdown-menu-end' }}">
                                        @if($canEdit)
                                        <li>
                                            <a class="dropdown-item bg-hover-light-grey" href="{{ route('categories.edit', $category->id) }}">
                                                <i class="bi bi-pencil-square me-2"></i>Edit
                                            </a>
                                        </li>
                                        @endif
                                        @if($canDelete)
                                        <li>
                                            <button type="button" class="dropdown-item text-danger bg-hover-light-grey"
                                                onclick="confirmDelete('{{ route('categories.destroy', $category->id) }}')">
                                                <i class="bi bi-trash3 me-2"></i>Delete
                                            </button>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-hover-light-grey">
                            <td colspan="7" class="text-center text-muted">No categories found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection