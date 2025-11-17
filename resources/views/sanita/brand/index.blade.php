@extends('sanita.layout')

@section('title', $brand->{'name_'.app()->getLocale()} ?? $brand->name_en)

@section('content')
<section id="brand" class="py-2 pt-0 bg-light">
    <!-- Header Buttons -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 p-3 pb-0">
        <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}" class="btn underline-btn mb-2 underline-arctic">
            <span class="text"><i class="fa-solid fa-arrow-left me-1"></i> {{ __('nav.back') }}</span>
        </a>
        <a href="{{ route('website.brands.index', ['locale' => app()->getLocale()]) }}" class="btn underline-btn mb-2 underline-arctic">
            <span class="text">{{ __('nav.all_brands') }}<i class="fa-solid fa-arrow-right ms-1"></i></span>
        </a>
    </div>

    <div class="p-5 pt-0 gx-0 w-100 brand-info">
        <!-- Brand Title -->
        <div class="text-center mb-4 brand-title">
            <h2 class="display-5 m-0 text-break section-title">
                {{ $brand->{'name_'.app()->getLocale()} ?? $brand->name_en }}
            </h2>
        </div>

        @if($products->isNotEmpty())
        <div class="products-list">
            <div class="d-flex flex-wrap justify-content-center gap-2 list-container">
                @foreach($products as $product)
                @php
                $isOffer = $offers && in_array($product, $offers);
                $cardType = $isOffer ? 'offer' : 'product';
                $badge = $isOffer ? __('nav.offer') : null;
                @endphp
                @include('sanita.partials.product-card', [
                'product' => $product,
                'cardType' => $cardType,
                'badge' => $badge
                ])
                @endforeach
            </div>
        </div>
        <div class="d-flex justify-content-center mt-0">
            {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @else
        <p class="text-center pt-5 text-primary">{{ __('No products available in this brand.') }}</p>
        @endif
    </div>
</section>

@include('sanita.partials.add-to-cart-modal')
@include('sanita.partials.contact-us')
<link href="{{ asset('css/category.css') }}" rel="stylesheet" />

@endsection