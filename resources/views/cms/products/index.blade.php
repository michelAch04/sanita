@extends('cms.layout')

@section('title', 'Products')

@php
use App\Models\Permission;
$permissions = Permission::with('page')
->join('pages', 'permissions.pages_id', '=', 'pages.id')
->where('permissions.users_id', auth()->user()->id)
->where('pages.name', 'Products')
->first();
$canAdd = $permissions && $permissions->add;
$canEdit = $permissions && $permissions->edit;
$canDelete = $permissions && $permissions->delete;
@endphp

@section('content')
{{-- Search --}}
<div class="d-flex justify-content-center w-100 mb-3">
    <form class="search-form d-flex align-items-center w-50" data-search-target="#product-table-body" action="{{ route('products.index') }}">
        <input type="text" name="query" class="form-control me-2 search-input rounded-pill shadow-soft" placeholder="Search..." autocomplete="off">
    </form>
</div>

<div class="container mt-5">
    <div class="card-header text-dark d-flex justify-content-between align-items-center m-2 mb-3">
        <h2 class="mb-0">Products</h2>
        @if($canAdd)
        <a href="{{ route('products.create') }}" class="btn bubbles fw-medium">
            <span class="text">+ Create Product</span></a>
        @endif
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive rounded-1">
                <table class="table mb-0">
                    <thead class="bg-grey text-dark opacity-75">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Small Description</th>
                            <th>Unit Price</th>
                            <th>Available Quantity</th>
                            <th>Hidden</th>
                            <th class="text-end">Options</th>
                        </tr>
                    </thead>
                    <tbody id="product-table-body">
                        @section('products_list')
                        @forelse ($products as $product)
                        <tr class="bg-hover-light-grey">
                            <td>{{ $product->id }}</td>
                            <td>
                                @if ($product->id)
                                <img src="{{ asset('storage/products/' . $product->id . '.' . $product->extension) }}"
                                    alt="{{ $product->name }}" class="img-thumbnail" style="width: 100px; height: 100px;">
                                @else
                                <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->small_description }}</td>
                            <td>${{ $product->unit_price }}</td>
                            <td>{{ $product->available_quantity }}</td>
                            <td>{{ $product->hidden ? 'Yes' : 'No' }}</td>
                            <td class="text-end">
                                @if($canEdit || $canDelete)
                                <div class="dropdown">
                                    <button class="btn btn-sm text-secondary rounded-circle border-0 bg-hover-teal" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if($canEdit)
                                        <li>
                                            <a class="dropdown-item bg-hover-light-grey" href="{{ route('products.edit', $product->id) }}">
                                                <i class="bi bi-pencil-square me-2"></i>Edit
                                            </a>
                                        </li>
                                        @endif
                                        @if($canDelete)
                                        <li>
                                            <button class="dropdown-item text-danger bg-hover-light-grey"
                                                onclick="confirmDelete('{{ route('products.destroy', $product->id) }}')">
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
                            <td colspan="8" class="text-center text-muted">No products found.</td>
                        </tr>
                        @endforelse
                        @endsection
                        @yield('products_list')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection