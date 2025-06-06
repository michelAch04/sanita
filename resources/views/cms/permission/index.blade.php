@extends('cms.layout')

@section('title', 'Permissions')

@php
use App\Models\Permission;
$permissions = Permission::with('page')
->join('pages', 'permissions.pages_id', '=', 'pages.id')
->where('permissions.users_id', auth()->user()->id)
->where('pages.name', 'Permissions')
->first();

$canAdd = $permissions && $permissions->add;
@endphp

@section('content')
{{-- Search --}}
<div class="d-flex justify-content-center w-100 mb-3">
    <form class="search-form d-flex align-items-center w-50" data-search-target="#permissions-table-body" action="{{ route('permissions.index') }}">
        <input type="text" name="query" class="form-control me-2 search-input rounded-pill shadow-soft" placeholder="Search..." autocomplete="off">
    </form>
</div>

<div class="container mt-5">
    {{-- Header --}}
    <div class="card-header text-dark d-flex justify-content-between align-items-center m-2 mb-3">
        <h2 class="mb-0">Permissions</h2>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive rounded-1">
                <table class="table mb-0">
                    <thead class="bg-grey text-dark opacity-75">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody id="permissions-table-body">
                        @section('permissions_list')
                        @forelse ($users as $user)
                        <tr class="bg-hover-light-grey">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td class="text-end">
                                <a href="{{ route('permissions.create', ['user_id' => $user->id]) }}" target="_blank" class="btn underline-btn">
                                    View Permissions
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-hover-light-grey">
                            <td colspan="4" class="text-center text-muted">No users found.</td>
                        </tr>
                        @endforelse
                        @endsection

                        @yield('permissions_list')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection