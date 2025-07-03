@extends('sanita.layout')

@section('title', __('Products'))

@section('content')
<section id="products" class="py-3 bg-light">
    <div class="p-5 gx-0 w-100">
        <h2 class="display-5 text-center mb-4 section-title">{{ __('nav.products') }}</h2>

        @if($products->isEmpty())
        <p class="text-center">{{ __('No products available currently.') }}</p>
        @else
        <div class="d-flex flex-wrap justify-content-center gap-3">
            @foreach($products as $product)
                @php
                $isNew = $product->created_at && $product->created_at->gt(\Illuminate\Support\Carbon::now()->subDays(7));
                @endphp
                @include('sanita.partials.product-card', [
                    'product' => $product,
                    'cardType' => $isNew ? 'new' : 'product',
                    'badge' => __('nav.new')
                ])
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
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
        margin: 5px !important;
    }

    @media (max-width: 1200px) {
        .product-card {
            width: 22%;
        }
    }

    @media (max-width: 992px) {
        .product-card {
            width: 28%;
        }
    }

    @media (max-width: 768px) {
        .product-card {
            width: 45%;
        }
    }

    @media (max-width: 576px) {
        .product-card {
            width: 90%;
        }
    }
</style>
@endsection