@extends('sanita.layout')

@section('title', __('Search Results'))

@section('content')
<div class="container py-5">

    {{-- Products --}}
    @if($products->isNotEmpty())
    <section class="mb-5">
        <h5 class="mb-4 section-title text-center">{{ __('nav.products') }}</h5>
        <div class="carousel gx-0 px-1">
            @foreach($products as $product)
            @include('sanita.partials.product-card', ['product' => $product, 'cardType' => 'product'])
            @endforeach
        </div>
    </section>
    @endif

    {{-- Categories --}}
    @if($categories->isNotEmpty())
    <section class="mb-5">
        <h5 class="mb-4 section-title text-center">{{ __('nav.categories') }}</h5>
        <div class="carousel px-1">
            @foreach($categories as $category)
            <div class="px-0">
                @include('sanita.partials.category-card', ['category' => $category, 'type' => 'categories'])
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- If no results --}}
    @if($products->isEmpty() && $categories->isEmpty() && $subcategories->isEmpty() && $brands->isEmpty())
    <div class=" text-center align_center">{{ __('No results found for') }} "{{ $query }}"</div>
    @endif
</div>
@endsection