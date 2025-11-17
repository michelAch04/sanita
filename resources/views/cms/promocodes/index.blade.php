@extends('cms.layout')

@section('title', 'Promo Codes')

@php
use App\Models\Permission;
$permissions = Permission::with('page')
->join('pages', 'permissions.pages_id', '=', 'pages.id')
->where('permissions.users_id', auth()->user()->id)
->where('pages.name', 'Promo Codes')
->first();

$canAdd = $permissions && $permissions->add;
$canEdit = $permissions && $permissions->edit;
$canDelete = $permissions && $permissions->delete;
@endphp


@section('content')
<div class="d-flex justify-content-center w-100 mb-3">
    <form class="search-form d-flex align-items-center w-50" data-search-target="#promo-table-body" action="{{ route('promocodes.index') }}">
        <input type="text" name="query" class="form-control me-2 search-input rounded-pill shadow-soft" placeholder="Search..." autocomplete="off">
    </form>
</div>

<div class="ps-5 mt-5">
    <div class="card-header text-dark d-flex justify-content-between align-items-center m-2 mb-3">
        <h2 class="mb-0">Promo Codes</h2>
        <a href="{{ route('promocodes.create') }}" class="btn bubbles fw-medium">
            <span class="text">+ Create Promo Code</span>
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive rounded-1">
                <table class="table mb-0">
                    <thead class="bg-grey text-dark opacity-75">
                        <tr>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Used</th>
                            <th class="text-end">Options</th>
                        </tr>
                    </thead>
                    <tbody id="promo-table-body">
                        @forelse ($promoCodes as $promo)
                        <tr class="bg-hover-light-grey">
                            <td>{{ $promo->code }}</td>
                            <td>{{ ucfirst($promo->type) }}</td>
                            <td>
                                {{ $promo->type == 'percentage' ? $promo->value . '%' : '$' . number_format($promo->value, 2) }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($promo->start_date)->format('Y-m-d H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($promo->end_date)->format('Y-m-d H:i') }}</td>
                            <td>
                                {{ $promo->usage_count_in_range }}
                                @if($promo->usage_limit)
                                ({{ round(($promo->usage_count_in_range / $promo->usage_limit) * 100, 2) }}%)
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm text-secondary rounded-circle border-0 bg-hover-teal" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item bg-hover-light-grey" href="{{ route('promocodes.edit', $promo->id) }}">
                                                <i class="bi bi-pencil-square me-2"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item text-danger bg-hover-light-grey"
                                                onclick="confirmDelete('{{ route('promocodes.destroy', $promo->id) }}')">
                                                <i class="bi bi-trash3 me-2"></i>Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-hover-light-grey">
                            <td colspan="8" class="text-center text-muted">No promo codes found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection