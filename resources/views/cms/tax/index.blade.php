@extends('cms.layout')

@section('title', 'Taxes')

@php
use App\Models\Permission;

$permissions = Permission::with('page')
    ->join('pages', 'permissions.pages_id', '=', 'pages.id')
    ->where('permissions.users_id', auth()->user()->id)
    ->where('pages.name', 'Taxes')
    ->first();

$canAdd = $permissions && $permissions->add;
$canEdit = $permissions && $permissions->edit;
$canDelete = $permissions && $permissions->delete;
@endphp

@section('content')

{{-- Search --}}
<div class="d-flex justify-content-center w-100 mb-3">
    <form class="search-form d-flex align-items-center w-50"
        data-search-target="#tax-table-body"
        action="{{ route('tax.index') }}" method="GET">
        <input type="text" name="query"
            class="form-control me-2 search-input rounded-pill shadow-soft"
            placeholder="Search..." autocomplete="off">
    </form>
</div>

<div class="container mt-5">

    {{-- Header --}}
    <div class="card-header text-dark d-flex justify-content-between align-items-center m-2 mb-3">
        <h2 class="mb-0">Taxes</h2>
        @if($canAdd)
        <a href="{{ route('tax.create') }}" class="btn bubbles fw-medium">
            <span class="text">+ Create Tax</span>
        </a>
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
                            <th>Name</th>
                            <th>Rate (%)</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th class="text-end">Options</th>
                        </tr>
                    </thead>
                    <tbody id="tax-table-body">
                        @section('tax_list')
                        @forelse ($taxes as $tax)
                        <tr class="bg-hover-light-grey">
                            <td>{{ $tax->id }}</td>
                            <td>{{ $tax->name }}</td>
                            <td>{{ $tax->rate }}</td>
                            <td>{{ $tax->active ? 'Active' : 'Inactive' }}</td>
                            <td>{{ $tax->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $tax->updated_at->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                @if($canEdit || $canDelete)
                                <div class="dropdown {{ $loop->first ? 'dropstart' : '' }}">
                                    <button class="btn btn-sm text-secondary rounded-circle border-0 bg-hover-teal" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu {{ $loop->first ? '' : 'dropdown-menu-end' }}">
                                        @if($canEdit)
                                        <li>
                                            <a class="dropdown-item bg-hover-light-grey" href="{{ route('tax.edit', $tax->id) }}">
                                                <i class="bi bi-pencil-square me-2"></i>Edit
                                            </a>
                                        </li>
                                        @endif
                                        @if($canDelete)
                                        <li>
                                            <button class="dropdown-item text-danger bg-hover-light-grey"
                                                onclick="confirmDelete('{{ route('tax.destroy', $tax->id) }}')">
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
                            <td colspan="7" class="text-center text-muted">No taxes found.</td>
                        </tr>
                        @endforelse
                        @endsection
                        @yield('tax_list')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
