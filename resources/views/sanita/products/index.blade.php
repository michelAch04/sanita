@extends('sanita.layout')

@section('title', __('Products'))

@section('content')
<section id="products" class="py-3 products-list {{ $isRtl ? 'rtl-container' : '' }}">
    <div class="px-5 py-2 ps-2 gx-0 w-100">
        <h2 class="display-5 text-center mb-5 section-title">{{ __('nav.products') }}</h2>

        <div class="d-flex flex-direction-row gap-1">
            <div class="bg-secondary filter-container p-lg-3 p-2">
                @include('sanita.partials.filter-results',
                ['brands' => $brands,
                'categories' => $categories,
                'products' => $products,
                'eaPrices' => $eaPrices])
            </div>
            @if($products->isEmpty())
            <div class="empty-filter-alert text-center py-5 px-4 my-5 rounded-4 shadow-sm">
                <div class="empty-filter-icon">
                    <i class="fa-solid fa-filter-circle-xmark"></i>
                </div>
                <div class="fs-4 fw-semibold mb-2 text-primary empty-filter-msg">
                    {{ __('No products match your filters.') }}
                </div>
                <a href="{{ url()->current() }}" class="btn bubbles bubbles-arctic mt-3 px-4 py-2 fs-6 shadow-sm empty-filter-btn">
                    <span class="text"><i class="fa fa-filter me-2"></i> {{ __('Reset Filters') }}</span>
                </a>
            </div>
            @else
            <div class="d-flex flex-wrap justify-content-center gap-2 list-container filtered-container">
                @foreach($products as $product)
                @include('sanita.partials.product-card', [
                'product' => $product,
                'cardType' => 'product'
                ])
                @endforeach
            </div>
        </div>
    </div>
    <!-- Pagination -->
    <div class="d-flex justify-content-center list-pagination">
        {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
    </div>
</section>
<link rel="stylesheet" href="{{ asset('css/products-list.css') }}" />
@include('sanita.partials.contact-us')
@include('sanita.partials.add-to-cart-modal')
@endsection