@extends('sanita.layout')

@section('title', 'Home')

@section('content')

<!-- Hero Section -->
<div class="hero-carousel">
    @foreach ($slideshow as $image)
    <div>
        <img src="{{ asset('storage/slideshow/' . $image->id.'.'.$image->extension) }}" alt="Slide" class="img-fluid rounded shadow">
    </div>
    @endforeach
</div>

<!-- Offers & Deals Section -->
<section id="offers" class="py-5 bg-light">
    <div class="container">
        <h2 class="display-5 text-center mb-4">{{ __('nav.offers') }}</h2>
        <div class="row">
            @foreach($offers as $product)
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow-sm d-flex flex-column">
                    @if($product->extension)
                    <img src="{{ asset('storage/products/' . $product->id . '.' . $product->extension) }}" class="card-img-top" alt="{{ $product->name }}" style="height:200px;object-fit:cover;">
                    @else
                    <img src="{{ asset('images/default-product.jpg') }}" class="card-img-top" alt="Default Image" style="height:200px;object-fit:cover;">
                    @endif

                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title mb-2" style="min-height: 2.5em;">
                            <a href="{{ route('products.show', ['locale' => app()->getLocale(), 'product' => $product->id]) }}">
                                {!! $product->{'name_' . app()->getLocale()} !!}
                            </a>
                        </h5>
                        <p class="card-text text-muted mb-2" style="min-height: 3em;">{!! $product->{'small_description_' . app()->getLocale()} !!}</p>

                        <div class="d-flex align-items-center justify-content-between mt-auto">
                            <div class="d-flex flex-column text-end">
                                @if($product->old_price > $product->shelf_price)
                                <small class="text-muted text-decoration-line-through">${{ number_format($product->old_price, 2) }}</small>
                                @endif
                                <span class="fw-bold text-primary">${{ number_format($product->shelf_price, 2) }}</span>
                            </div>

                            @if($product->available_quantity > 0)
                            <form data-url="{{ route('cart.store', ['locale' => app()->getLocale()]) }}" method="POST" class="add-to-cart-form ms-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="price" value="{{ $product->shelf_price }}">
                                <input type="hidden" name="description" value="{{ $product->description }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-cart-plus me-1"></i> {{ __('cart.add_to_cart') }}
                                </button>
                            </form>
                            @else
                            <button class="btn btn-secondary btn-sm" disabled>
                                {{ __('cart.out_of_stock') ?? 'Out of Stock' }}
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Categories Section -->
<section id="categories" class="py-5">
    <div class="container text-center">
        <h2 class="display-5 mb-4">{{ __('nav.categories') }}</h2>
        <div class="row justify-content-center">
            @foreach($categories->take(5) as $category)
            <div class="col-md-2 col-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        @if($category->extension)
                        <img src="{{ asset('storage/categories/' . $category->id . '.' . $category->extension) }}"
                            alt="{{ $category->name }}"
                            class="img-fluid rounded-circle mb-2"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        @endif
                        <h5 class="card-title">
                            <a href="{{ route('categories.show', ['locale' => app()->getLocale(), 'category' => $category->id]) }}"
                                class="text-decoration-none text-dark">
                                {!! $category->{'name_' . app()->getLocale()} !!}
                            </a>
                        </h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="py-5 bg-light">
    <div class="container">
        <h2 class="display-5 text-center mb-4">{{ __('nav.products') }}</h2>
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow-sm d-flex flex-column">
                    @if($product->extension)
                    <img src="{{ asset('storage/products/' . $product->id . '.' . $product->extension) }}" class="card-img-top" alt="{{ $product->name }}" style="height:200px;object-fit:cover;">
                    @else
                    <img src="{{ asset('images/default-product.jpg') }}" class="card-img-top" alt="Default Image" style="height:200px;object-fit:cover;">
                    @endif

                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title mb-2" style="min-height: 2.5em;">
                            <a href="{{ route('products.show', ['locale' => app()->getLocale(), 'product' => $product->id]) }}">
                                {!! $product->{'name_' . app()->getLocale()} !!}
                            </a>
                        </h5>
                        <p class="card-text text-muted mb-2" style="min-height: 3em;">{!! $product->{'small_description_' . app()->getLocale()} !!}</p>

                        <div class="d-flex align-items-center justify-content-between mt-auto">
                            <span class="fw-bold text-primary">${{ $product->shelf_price }}</span>

                            @if($product->available_quantity > 0)
                            <form
                                class="ms-2 add-to-cart-form"
                                data-url="{{ route('cart.store', ['locale' => app()->getLocale()]) }}">

                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="price" value="{{ $product->shelf_price }}">
                                <input type="hidden" name="description" value="{{ $product->description }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-cart-plus me-1"></i> {{ __('cart.add_to_cart') }}
                                </button>
                            </form>
                            @else
                            <button class="btn btn-secondary btn-sm" disabled>
                                {{ __('cart.out_of_stock') ?? 'Out of Stock' }}
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js" defer></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" />

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('.hero-carousel').slick({
            dots: false,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: false,
            draggable: true,
            swipe: true,
        });

        // AJAX: Add to cart
        $('.add-to-cart-form').on('submit', function(e) {
            e.preventDefault();

            const $form = $(this);
            const url = $form.data('url');
            const data = {
                _token: '{{ csrf_token() }}',
                product_id: $form.find('input[name="product_id"]').val(),
                price: $form.find('input[name="price"]').val(),
                description: $form.find('input[name="description"]').val(),
                quantity: $form.find('input[name="quantity"]').val()
            };

            $.post(url, data, function(response) {
                if (response.success) {
                    $('#cart-count').text(response.cart_count);
                    toastr.success(response.message || 'Added to cart');
                } else {
                    toastr.error(response.message || 'Failed to add to cart');
                }
            }).fail(function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Server error. Please try again.');
            });
        });
    });
</script>

<style>
    .category-carousel .slick-slide {
        padding: 10px;
    }
</style>
@endsection