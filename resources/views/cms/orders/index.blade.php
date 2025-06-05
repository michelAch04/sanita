@extends('cms.layout')

@section('title', 'Orders')

@php
use App\Models\Permission;
$permissions = Permission::with('page')
->join('pages', 'permissions.pages_id', '=', 'pages.id')
->where('permissions.users_id', auth()->user()->id)
->where('pages.name', 'Orders')
->first();
$canAdd = $permissions && $permissions->add;
$canEdit = $permissions && $permissions->edit;
$canDelete = $permissions && $permissions->delete;
@endphp

@section('content')
<div class="container mt-5">

    {{-- Header --}}
    <div class="card-header text-dark d-flex justify-content-between align-items-center m-2 mb-3">
        <h2 class="mb-0">Orders</h2>
        @if($canAdd)
        <a href="{{ route('orders.create') }}" class="btn btn-teal fw-medium">+ Create Order</a>
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
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total Price</th>
                            <th class="text-end">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr class="bg-hover-light-grey">
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer->name }}</td>
                            <td>{{ $order->status }}</td>
                            <td>${{ number_format($order->total_price, 2) }}</td>
                            <td class="text-end">
                                @if($canEdit || $canDelete)
                                <div class="dropdown {{ $loop->first ? 'dropstart' : '' }}">
                                    <button class="btn btn-sm text-secondary rounded-circle border-0 bg-hover-teal" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu {{ $loop->first ? '' : 'dropdown-menu-end' }}">
                                        @if($canEdit)
                                        <li>
                                            <a class="dropdown-item bg-hover-light-grey" href="{{ route('orders.edit', $order->id) }}">
                                                <i class="bi bi-pencil-square me-2"></i>Edit
                                            </a>
                                        </li>
                                        @endif
                                        @if($canDelete)
                                        <li>
                                            <button type="button" class="dropdown-item text-danger bg-hover-light-grey"
                                                onclick="confirmDelete('{{ route('orders.destroy', $order->id) }}')">
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
                            <td colspan="5" class="text-center text-muted">No orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection