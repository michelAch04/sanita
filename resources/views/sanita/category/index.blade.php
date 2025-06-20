@extends('sanita.layout')

@section('title', $category->name_en)

@section('content')
<div class="container">
    <h1 class="my-4 text-center">{{ __('Category') }}: <strong>{{ $category->name }}</strong></h1>

    <!-- Category Description -->
    <p class="text-center mb-4">{{ $category->name_en }}</p>

    @if($category->subcategories)
    <h2 class="my-4 text-center">{{ __('Subcategories') }}</h2>

    <!-- Subcategory Navbar with Icons and Hover Effect -->
    <div class="nav flex-column nav-pills" id="subcategory-nav" role="tablist" aria-orientation="vertical">
        @foreach($category->subcategories as $index => $subcategory)
        <a class="nav-link @if($index === 0) active @endif"
            id="subcategory-{{ $subcategory->id }}-tab"
            data-bs-toggle="pill"
            href="#subcategory-{{ $subcategory->id }}"
            role="tab"
            aria-controls="subcategory-{{ $subcategory->id }}"
            aria-selected="true">
            <i class="bi bi-folder-fill me-2"></i> {{ $subcategory->name_en }}
        </a>
        @endforeach
    </div>

    <!-- Tab Content for Subcategories -->
    <div class="tab-content mt-4" id="subcategory-content">
        @foreach($category->subcategories as $index => $subcategory)
        <div class="tab-pane fade @if($index === 0) show active @endif"
            id="subcategory-{{ $subcategory->id }}"
            role="tabpanel"
            aria-labelledby="subcategory-{{ $subcategory->id }}-tab">

            <!-- Ensure products are never null -->
            @php
            $products = $subcategory->products ?: collect(); // Fallback to an empty collection if null
            @endphp

            @if($products->isNotEmpty())
            <h6 class="mt-3 text-center">{{ __('Products') }}</h6>

            <!-- Product Grid Layout -->
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($products as $product)
                <div class="col">
                    <div class="card shadow-sm">
                        <img src="{{ asset('storage/products/'. $product->id . '.'.$product->extension) }}" class="card-img-top" alt="{{ $product->name_en }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name_en }}</h5>
                            <p class="card-text">{{ $product->small_description_en }}</p>

                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Price Display -->
                                <div>
                                    <p class="text-muted text-decoration-line-through">${{ $product->old_price }}</p>
                                    <p class="h5 text-primary">${{ $product->shelf_price }}</p>
                                </div>
                                <!-- Product Link -->
                                <a href="{{ route('website.product.index', ['locale' => app()->getLocale(), 'product' => $product->id]) }}" class="btn btn-outline-primary">
                                    {{ __('View Product') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center">{{ __('No products available in this subcategory.') }}</p>
            @endif
        </div>
        @endforeach
    </div>

    @else
    <p class="text-center">{{ __('No subcategories available in this category.') }}</p>
    @endif
</div>
@endsection