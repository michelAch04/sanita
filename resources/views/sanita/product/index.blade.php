@extends('sanita.layout')

@section('title', __('product.title') . ': ' . $product->{'name_' . app()->getLocale()})

@section('content')
<div class="container py-5">
    <div class="row g-4 align-items-start">
        <!-- Product Image -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <img src="{{ asset('storage/products/' . ($product->image_url ?? 'default.jpg')) }}"
                    alt="{{ $product->{'name_' . app()->getLocale()} }}"
                    class="img-fluid rounded-start w-100">
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h2 class="mb-3">{{ $product->{'name_' . app()->getLocale()} }}</h2>

            <p class="text-muted">{{ $product->{'small_descritpion_' . app()->getLocale()} ?? __('product.no_description') }}</p>

            <div class="mb-3">
                <strong>{{ __('product.price') }}:</strong>
                <span class="fs-5 fw-bold text-success">${{ number_format($product->unit_price, 2) }}</span>
            </div>

            @if($product->old_price)
            <div class="mb-2">
                <strong>{{ __('product.old_price') }}:</strong>
                <span class="text-muted text-decoration-line-through">${{ number_format($product->old_price, 2) }}</span>
            </div>
            @endif

            @if($product->shelf_price)
            <div class="mb-4">
                <strong>{{ __('product.shelf_price') }}:</strong>
                <span class="text-primary">${{ number_format($product->shelf_price, 2) }}</span>
            </div>
            @endif

            <!-- Add to Cart -->
            <form method="POST" action="{{ route('cart.store', ['locale' => app()->getLocale()]) }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-lg btn-success">
                    <i class="bi bi-cart-plus"></i> {{ __('product.add_to_cart') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection