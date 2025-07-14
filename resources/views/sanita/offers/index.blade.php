@extends('sanita.layout')

@section('title', __('Offers'))

@section('content')
<section id="offers" class="py-3 products-list">
    <div class="px-5 py-2 gx-0 w-100">
        <h2 class="display-5 text-center mb-5 section-title">special {{ __('nav.offers') }}</h2>

        @if($offers->isEmpty())
        <p class="text-center">{{ __('No offers available currently.') }}</p>
        @else
        <div class="d-flex flex-wrap justify-content-center gap-2 list-container">
            @foreach($offers as $product)
                @include('sanita.partials.product-card', [
                'product' => $product,
                'cardType' => 'offer',
                'badge' => __('nav.offer')
                ])
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center list-pagination">
            {{ $offers->withQueryString()->links('pagination::bootstrap-5') }}
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