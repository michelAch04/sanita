@extends('cms.layout')

@section('title', 'Subcategories')

@php
use App\Models\Permission;
$permissions = Permission::with('page')->join('pages', 'permissions.pages_id', '=', 'pages.id')
->where('permissions.users_id', auth()->user()->id)
->where('pages.name', 'Subcategories')
->first();
$canAdd = $permissions && $permissions->add;
$canEdit = $permissions && $permissions->edit;
$canDelete = $permissions && $permissions->delete;
@endphp

@section('content')
{{-- Search --}}
<div class="d-flex justify-content-center w-100 mb-3">
    <form class="search-form d-flex align-items-center w-50" data-search-target="#subcategory-table-body" action="{{ route('subcategories.index') }}">
        <input type="text" name="query" class="form-control me-2 search-input rounded-pill shadow-soft" placeholder="Search..." autocomplete="off">
    </form>
</div>

<div class="container mt-5">
    {{-- Header --}}
    <div class="card-header text-dark d-flex justify-content-between align-items-center m-2 mb-3">
        <h2 class="mb-0">Subcategories</h2>
        @if($canAdd)
        <a href="{{ route('subcategories.create') }}" class="btn bubbles fw-medium">
            <span class="text">+ Add Subcategory</span></a>
        @endif
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive rounded-1">
                <table class="table mb-0">
                    <thead class="bg-grey text-dark opacity-75">
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th class="text-end">Options</th>
                        </tr>
                    </thead>
                    <tbody id="subcategory-table-body">
                        @section('subcategories_list')
                        @forelse ($subcategories as $subcategory)
                        <tr class="bg-hover-light-grey">
                            <td>{{ $subcategory->name }}</td>
                            <td>{{ $subcategory->category->name }}</td>
                            <td class="text-end">
                                @if($canEdit || $canDelete)
                                <div class="dropdown">
                                    <button class="btn btn-sm text-secondary rounded-circle border-0 bg-hover-teal" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if($canEdit)
                                        <li>
                                            <a class="dropdown-item bg-hover-light-grey" href="{{ route('subcategories.edit', $subcategory->id) }}">
                                                <i class="bi bi-pencil-square me-2"></i>Edit
                                            </a>
                                        </li>
                                        @endif
                                        @if($canDelete)
                                        <li>
                                            <button type="button" class="dropdown-item text-danger bg-hover-light-grey"
                                                onclick="confirmDelete('{{ route('subcategories.destroy', $subcategory->id) }}')">
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
                            <td colspan="3" class="text-center text-muted">No subcategories found.</td>
                        </tr>
                        @endforelse
                        @endsection

                        @yield('subcategories_list')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection