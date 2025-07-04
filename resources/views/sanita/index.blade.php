@extends('sanita.layout')

@section('title', 'Home')
@php
$type = auth()->user()->type ?? 'b2c';
@endphp

@section('content')
@if(session('force_address_modal'))
@include('sanita.partials.address-on-sign-up')
@endif

<!-- Hero Section -->
<div class="hero-carousel">
    @foreach ($slideshow as $image)
    <div>
        <img src="{{ asset('storage/slideshow/' . $image->id . '.' . $image->extension) }}" alt="Slide" class="img-fluid rounded shadow">
    </div>
    @endforeach
</div>

<!-- Offers Section -->
<section id="offers" class="py-5">
    <div class="container gx-0">
        <h2 class="display-5 text-center mb-4 section-title">{{ __('nav.offers') }}</h2>
        <div class="carousel gx-0">
            @foreach($offers as $product)
            @include('sanita.partials.product-card', [
            'product' => $product,
            'cardType' => 'offer'
            ])
            @endforeach
        </div>
        <div class="text-center mt-4 mb-0">
            <a href="{{ route('website.offers.index', ['locale' => app()->getLocale()]) }}" class="btn bubbles bubbles-arctic view-all-btn">
                <span class="text">{{ __('nav.view_all_offers') }}
                    <i class="fa-solid fa-arrow-right me-1 {{ $isRtl ? 'd-none' : '' }}"></i>
                </span>
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section id="categories" class="py-5">
    <div class="container text-center">
        <h2 class="display-5 mb-4 section-title">{{ __('nav.categories') }}</h2>
        <div class="carousel mx-auto mb-5">
            @foreach($categories as $category)
            <div class="px-0">
                @include('sanita.partials.category-card', [
                'category' => $category,
                ])
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5 mb-0">
            <a href="{{ route('website.categories.index', ['locale' => app()->getLocale()]) }}" class="btn bubbles bubbles-arctic view-all-btn">
                <span class="text">
                    {{ __('nav.view_all_categories') }}
                    <i class="fa-solid fa-arrow-right me-1 {{ $isRtl ? 'd-none' : '' }}"></i>
                </span>
            </a>
        </div>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="py-5">
    <div class="container">
        <h2 class="display-5 text-center mb-4 section-title">{{ __('nav.products') }}</h2>
        <div class="carousel gx-0">
            @foreach($products as $product)
            @include('sanita.partials.product-card', [
            'product' => $product,
            'cardType' => 'product'
            ])
            @endforeach
        </div>
        <div class="text-center mt-5 mb-0">
            <a href="{{ route('website.products.index', ['locale' => app()->getLocale()]) }}" class="btn bubbles bubbles-arctic view-all-btn">
                <span class="text">
                    {{ __('nav.view_all_products') }}
                    <i class="fa-solid fa-arrow-right me-1 {{ $isRtl ? 'd-none' : '' }}"></i>
                </span>
            </a>
        </div>
    </div>
</section>

<section id="brands" class="py-5">
    <div class="container text-center">
        <h2 class="display-5 mb-4 section-title">{{ __('nav.brands') }}</h2>
        <div class="carousel mx-auto mb-5">
            @foreach($brands as $brand)
            <div class="px-0">
                @include('sanita.partials.category-card', [
                'category' => $brand,
                ])
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5 mb-0">
            <a href="{{ route('website.categories.index', ['locale' => app()->getLocale()]) }}" class="btn bubbles bubbles-arctic view-all-btn">
                <span class="text">
                    {{ __('nav.view_all_brands') }}
                    <i class="fa-solid fa-arrow-right me-1 {{ $isRtl ? 'd-none' : '' }}"></i>
                </span>
            </a>
        </div>
    </div>
</section>
@include('sanita.partials.contact-us')
@include('sanita.partials.add-to-cart-modal')

@endsection