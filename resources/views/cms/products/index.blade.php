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

<div class="ps-4 mt-5 ms-0 me-0" style="width: 95vw !important;">
    <div class="card-header text-dark d-flex justify-content-between align-items-center m-2 mb-3">
        <h2 class="mb-0">Products</h2>
        @if($canAdd)
        <a href="{{ route('products.create') }}" class="btn bubbles fw-medium">
            <span class="text">+ Create Product</span></a>
        @endif
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive rounded-1" style="overflow-x: auto; overflow-y: auto; height: 70vh; width: 100%;">
                <table class="table mb-0 mr-0 w-100">
                    <thead class="bg-grey text-dark opacity-75">
                        <tr>
                            <th class="position-sticky top-0 bg-grey" style="background-color: #f8f9fa; z-index:2; width: 50px;"></th>
                            <th class="position-sticky top-0 bg-grey" style="background-color: #f8f9fa; z-index:2;">Image</th>
                            <th class="position-sticky top-0 bg-grey" style="background-color: #f8f9fa; z-index:2;">Item Code</th>
                            <th class="position-sticky top-0 bg-grey" style="background-color: #f8f9fa; z-index:2;">Barcode</th>
                            <th class="position-sticky top-0 bg-grey" style="background-color: #f8f9fa; z-index:2;">Name</th>
                            <th class="position-sticky top-0 bg-grey" style="background-color: #f8f9fa; z-index:2;">Subcategory</th>
                            <th class="position-sticky top-0 bg-grey" style="background-color: #f8f9fa; z-index:2;">Brand</th>
                            <th class="position-sticky top-0 bg-grey" style="background-color: #f8f9fa; z-index:2;">tax</th>
                            <th class="position-sticky top-0 bg-grey" style="background-color: #f8f9fa; z-index:2;">Created At</th>
                            <th class="position-sticky top-0 bg-grey" style="background-color: #f8f9fa; z-index:2;">Updated At</th>
                            <th class="position-sticky top-0 bg-grey text-end" style="background-color: #f8f9fa; z-index:2;">Options</th>
                        </tr>
                    </thead>
                    <tbody id="product-table-body">
                        @section('products_list')
                        @forelse ($products as $product)
                        @php
                        $imagePath = 'products/' . $product->id . '.' . $product->extension;
                        $storage = \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath);
                        @endphp
                        <tr class="bg-hover-light-grey" data-id="{{ $product->id }}">
                            <td class="handle text-muted text-center"><i class="bi bi-list" style="cursor:grab;"></i></td>
                            <td>
                                @if($storage)
                                <img src="{{ asset('storage/products/' . $product->id . '.' . $product->extension) }}"
                                    alt="{{ $product->name }}" class="img-thumbnail" style="width: 100px; height: 100px;">
                                @else
                                <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $product->sku}}</td>
                            <td>{{ $product->barcode }}</td>
                            <td>{{ $product->name_en }}</td>
                            <td>{{ $product->subcategories->name_en ?? 'N/A' }}</td>
                            <td>{{ $product->brands->name_en ?? 'N/A' }}</td>
                            <td>{{ $product->tax->name ?? 'N/A' }}-{{ $product->tax->rate ?? 'N/A'}}</td>
                            <td>{{ $product->created_at }}</td>
                            <td>{{ $product->updated_at }}</td>
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