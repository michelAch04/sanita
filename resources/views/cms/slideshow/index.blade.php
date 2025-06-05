@extends('cms.layout')

@section('title', 'Slideshow')

@php
use App\Models\Permission;
$permissions = Permission::with('page')
->join('pages', 'permissions.pages_id', '=', 'pages.id')
->where('permissions.user_id', auth()->user()->id)
->where('pages.name', 'Slideshow')
->first();
$canAdd = $permissions && $permissions->add;
$canEdit = $permissions && $permissions->edit;
$canDelete = $permissions && $permissions->delete;
@endphp

@section('content')
{{-- Search --}}
<div class="d-flex justify-content-center w-100 mb-3">
    <form class="search-form d-flex align-items-center w-50" data-search-target="#slideshow-table-body" action="{{ route('slideshow.index') }}">
        <input type="text" name="query" class="form-control me-2 search-input rounded-pill shadow-soft" placeholder="Search..." autocomplete="off">
    </form>
</div>

<div class="container mt-5">
    {{-- Header --}}
    <div class="card-header text-dark d-flex justify-content-between align-items-center m-2 mb-3">
        <h2 class="mb-0">Slideshow</h2>
        @if($canAdd)
        <a href="{{ route('slideshow.create') }}" class="btn btn-teal fw-medium">+ Create Slide</a>
        @endif
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive rounded-1">
                <table class="table mb-0 align-middle text-center">
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
                    <tbody id="slideshow-table-body">
                        @section('slideshows_list')
                        @forelse ($slideshows as $slide)
                        <tr class="bg-hover-light-grey">
                            <td>{{ $slide->id }}</td>
                            <td>
                                <img src="{{ asset('storage/slideshow/' . $slide->id . '.' . $slide->extension) }}"
                                    alt="{{ $slide->name }}"
                                    class="img-thumbnail"
                                    style="width: 80px; height: auto;">
                            </td>
                            <td>{{ $slide->name }}</td>
                            <td>{{ $slide->hidden ? 'Yes' : 'No' }}</td>
                            <td>{{ $slide->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $slide->updated_at->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                @if($canEdit || $canDelete)
                                <div class="dropdown {{ $loop->first ? 'dropstart' : '' }}">
                                    <button class="btn btn-sm text-secondary rounded-circle border-0 bg-hover-teal" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu {{ $loop->first ? '' : 'dropdown-menu-end' }}">
                                        @if($canEdit)
                                        <li>
                                            <a class="dropdown-item bg-hover-light-grey" href="{{ route('slideshow.edit', $slide->id) }}">
                                                <i class="bi bi-pencil-square me-2"></i>Edit
                                            </a>
                                        </li>
                                        @endif
                                        @if($canDelete)
                                        <li>
                                            <button type="button" class="dropdown-item text-danger bg-hover-light-grey"
                                                onclick="confirmDelete('{{ route('slideshow.destroy', $slide->id) }}')">
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
                            <td colspan="7" class="text-center text-muted">No slideshow items found.</td>
                        </tr>
                        @endforelse
                        @endsection

                        @yield('slideshows_list')
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection