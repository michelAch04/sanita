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

<!-- Categories Section -->
<section id="categories" class="py-5">
    <div class="container text-center">
        <h2 class="display-5 mb-4">Categories</h2>
        <div class="row justify-content-center">
            @foreach($categories as $category)
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        @if($category->extension)
                        <img src="{{ asset('storage/categories/' . $category->id . '.' . $category->extension) }}" alt="{{ $category->name }}" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                        @endif
                        <h5 class="card-title">

                            <a href="{{ route('categories.show', $category->id) }}" class="text-decoration-none text-dark">
                                {{ $category->name }}
                            </a>
                        </h5>
                        <p class="card-text text-muted">{{ $category->description ?? '' }}</p>
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
        <h2 class="display-5 text-center mb-4">Products</h2>
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
                        <h5 class="card-title mb-2" style="min-height: 2.5em;">{{ $product->name }}</h5>
                        <p class="card-text text-muted mb-2" style="min-height: 3em;">{{ \Illuminate\Support\Str::limit($product->small_description, 80) }}</p>

                        <div class="d-flex align-items-center justify-content-between mt-auto">
                            <span class="fw-bold text-primary">${{ $product->unit_price }}</span>
                            <form action="{{ route('cart.store') }}" method="POST" class="ms-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="price" value="{{ $product->unit_price }}">
                                <input type="hidden" name="description" value="{{ $product->description }}">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-cart-plus me-1"></i> Add to Cart
                                </button>
                            </form>
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
    });
</script>
@endsection