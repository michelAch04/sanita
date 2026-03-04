@extends('sanita.layout')

@section('title', __('nav.search_results'))
@php
$type = auth()->user()->type ?? 'b2c';
@endphp

@section('content')

<h2 class="fs-5 fs-md-1 display-5 text-center mb-2 mt-4 mx-2 section-title">{{ __('nav.search_title') . ' \'' . $query . '\''}} </h2>
<!-- Products Section -->
@if($products->isNotEmpty())
<section id="products" class="py-0">
    <div class="container">
        <div class="carousel gx-0 mb-3 px-1">
            @foreach($products as $product)
            @include('sanita.partials.product-card', [
            'product' => $product,
            'cardType' => 'product'
            ])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Categories Section -->
@if($categories->isNotEmpty())
<section id="categories" class="py-0">
    <div class="container gx-0 text-center">
        <div class="carousel mx-auto mb-3 px-1">
            @foreach($categories as $category)
            <div class="px-0">
                @include('sanita.partials.category-card', [
                'category' => $category,
                'type' => 'categories'
                ])
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif()

@if($brands->isNotEmpty())
<section id="brands" class="py-0">
    <div class="container text-center">
        <div class="carousel mx-auto mb-3 px-1">
            @foreach($brands as $brand)
            <div class="px-0">
                @include('sanita.partials.brand-card', [
                'category' => $brand,
                'type' => 'brand'
                ])
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<section class="mb-1 mt-0 d-block d-md-none"></section>
@include('sanita.partials.contact-us')
@include('sanita.partials.add-to-cart-modal')
<style>
    @media (max-width: 768px) {
        html,
        body {
            overflow-x: hidden !important;
            width: 100% !important;
        }
    }
    @media (min-width: 768px) {
        .fs-md-1 {
            font-size: 2.5rem !important;
            /* whatever size you want */
        }
    }
</style>
@endsection