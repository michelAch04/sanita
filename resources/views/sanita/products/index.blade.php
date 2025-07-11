@extends('sanita.layout')

@section('title', __('Products'))

@section('content')
<section id="products" class="py-3 products-list">
    <div class="px-5 py-2 gx-0 w-100">
        <h2 class="display-5 text-center mb-5 section-title">{{ __('nav.products') }}</h2>

        @if($products->isEmpty())
        <p class="text-center">{{ __('No products available currently.') }}</p>
        @else
        <div class="d-flex flex-wrap justify-content-center gap-2 list-container">
            @foreach($products as $product)
                @include('sanita.partials.product-card', [
                    'product' => $product,
                    'cardType' => 'product'
                ])
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4 list-pagination">
            {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</section>
@include('sanita.partials.contact-us')
@include('sanita.partials.add-to-cart-modal')
<style>
    .product-card {
        flex: 0 0 auto;
        width: 18%;
        /* 5 per row approx */
    }
</style>
@endsection