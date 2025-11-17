@extends('cms.layout')

@section('title', 'POS Locations')

@php
use App\Models\Permission;
$permissions = Permission::with('page')
    ->join('pages', 'permissions.pages_id', '=', 'pages.id')
    ->where('permissions.users_id', auth()->user()->id)
    ->where('pages.name', 'POS Locations')
    ->first();
$canAdd = $permissions && $permissions->add;
$canEdit = $permissions && $permissions->edit;
$canDelete = $permissions && $permissions->delete;
@endphp

@section('content')
{{-- Search --}}
<div class="d-flex justify-content-center w-100 mb-3">
    <form class="search-form d-flex align-items-center w-50" data-search-target="#pos-table-body" action="{{ route('pos_locations.index') }}">
        <input type="text" name="query" class="form-control me-2 search-input rounded-pill shadow-soft" placeholder="Search..." autocomplete="off">
    </form>
</div>

<div class="ps-4 mt-5 ms-0 me-0" style="width: 95vw !important;">
    <div class="card-header text-dark d-flex justify-content-between align-items-center m-2 mb-3">
        <h2 class="mb-0">POS Locations</h2>
        @if($canAdd)
        <a href="{{ route('pos_locations.create') }}" class="btn bubbles fw-medium">
            <span class="text">+ Create POS Location</span></a>
        @endif
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive rounded-1" style="overflow-x: auto; overflow-y: auto; height: 70vh; width: 100%;">
                <table class="table mb-0 mr-0 w-100">
                    <thead class="bg-grey text-dark opacity-75">
                        <tr>
                            <th class="position-sticky top-0 bg-grey">Name</th>
                            <th class="position-sticky top-0 bg-grey">Address</th>
                            <th class="position-sticky top-0 bg-grey">City</th>
                            <th class="position-sticky top-0 bg-grey">Latitude</th>
                            <th class="position-sticky top-0 bg-grey">Longitude</th>
                            <th class="position-sticky top-0 bg-grey">Created At</th>
                            <th class="position-sticky top-0 bg-grey">Updated At</th>
                            <th class="position-sticky top-0 bg-grey text-end">Options</th>
                        </tr>
                    </thead>
                    <tbody id="pos-table-body">
                        @section('pos_locations_list')
                        @forelse ($posLocations as $pos)
                        <tr class="bg-hover-light-grey" data-id="{{ $pos->id }}">
                            <td>{{ $pos->name }}</td>
                            <td>{{ $pos->address }}</td>
                            <td>{{ $pos->city->name ?? 'N/A' }}</td>
                            <td>{{ $pos->latitude }}</td>
                            <td>{{ $pos->longitude }}</td>
                            <td>{{ $pos->created_at }}</td>
                            <td>{{ $pos->updated_at }}</td>
                            <td class="text-end">
                                @if($canEdit || $canDelete)
                                <div class="dropdown">
                                    <button class="btn btn-sm text-secondary rounded-circle border-0 bg-hover-teal" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if($canEdit)
                                        <li>
                                            <a class="dropdown-item bg-hover-light-grey" href="{{ route('pos_locations.edit', $pos->id) }}">
                                                <i class="bi bi-pencil-square me-2"></i>Edit
                                            </a>
                                        </li>
                                        @endif
                                        @if($canDelete)
                                        <li>
                                            <button class="dropdown-item text-danger bg-hover-light-grey"
                                                onclick="confirmDelete('{{ route('pos_locations.destroy', $pos->id) }}')">
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
                        <tr>
                            <td colspan="8" class="text-center text-muted">No POS locations found.</td>
                        </tr>
                        @endforelse
                        @endsection
                        @yield('pos_locations_list')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
