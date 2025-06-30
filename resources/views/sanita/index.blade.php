@extends('sanita.layout')

@section('title', 'Home')
@php
$isRtl = app()->getLocale() === 'ar' || app()->getLocale() === 'ku';
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
<section id="offers" class="py-5 bg-light">
    <div class="container gx-0">
        <h2 class="display-5 text-center mb-4">{{ __('nav.offers') }}</h2>
        <div class="carousel gx-0">
            @foreach($offers as $product)
            @php
            $imagePath = 'products/' . $product->id . '.' . $product->extension;
            $storage = \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath);
            $price = $product->listPrices->first();
            @endphp
            @if($price->shelf_price > 0 )
            <div class="product-card mb-4" data-url="{{ route('website.product.index', ['locale' => app()->getLocale(), 'product' => $product->id]) }}">
                <div class="card">
                    <div class="card__shine"></div>
                    <div class="card__glow"></div>
                    <div class="card__content">
                        <div class="card__badge">{{ __('nav.offer') }}</div>
                        <div style="--bg-color: #a78bfa" class="card__image">
                            @if($storage)
                            <img src="{{ asset('storage/products/' . $product->id . '.' . $product->extension) }}"
                                alt="{{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}"
                                class="img-fluid w-100 h-100 dynamic-fit">
                            @endif
                        </div>
                        <div class="card__text">
                            <p class="card__title">
                                <a href="{{ route('website.product.index', ['locale' => app()->getLocale(), 'product' => $product->id]) }}"
                                    class="text-decoration-none text-dark">
                                    {{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}
                                </a>
                            </p>
                            <p class="card__description">
                                {{ \Illuminate\Support\Str::limit($product->{'small_description_'.app()->getLocale()} ?? $product->small_description_en, 80) }}
                            </p>
                        </div>
                        <div class="card__footer">

                            <div class="card__price">
                                @if($price)
                                @if($price->old_price > $price->shelf_price)
                                <small class="text-muted text-decoration-line-through me-1">
                                    ${{ number_format($price->old_price, 2) }}
                                </small>
                                @endif
                                <span>${{ number_format($price->shelf_price, 2) }}</span>
                                @else
                                <span>{{ __('product.no_price') }}</span>
                                @endif
                            </div>
                            @php
                            $auth = auth('customer')->user();
                            $totalStock = $product->distributorStocks?->sum('stock') ?? 0;
                            @endphp
                            <div class="card__button">
                                @if(!$auth)
                                <form action="{{ route('website.cart.store', ['locale' => app()->getLocale()]) }}" method="POST" class="add-to-cart-form m-0">
                                    @csrf
                                    <input type="hidden" name="old_price" value="{{ $price->old_price }}">
                                    <input type="hidden" name="type" value="{{ $price->type }}">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="{{ $totalStock }}">
                                    <input type="hidden" name="unit_price" value="{{ $price->unit_price}}">
                                    <input type="hidden" name="shelf_price" value="{{ $price->shelf_price }}">
                                    <input type="hidden" name="description" value="{{ $product->{'small_description_'.app()->getLocale()} ?? $product->small_description_en }}">
                                    <input type="hidden" name="name" value="{{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}">
                                    <input type="hidden" name="ea-ca" value="{{ $product->ea_ca ?? 12 }}">
                                    <input type="hidden" name="ea-pl" value="{{ $product->ea_pl ?? 144 }}">
                                    <input type="hidden" name="ea" value="{{ $price->EA }}">
                                    <input type="hidden" name="ca" value="{{ $price->CA }}">
                                    <input type="hidden" name="pl" value="{{ $price->PL }}">
                                    <button type="submit" class="border-0 bg-transparent p-0">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                                @else
                                @if($totalStock > 0)
                                <form action="{{ route('website.cart.store', ['locale' => app()->getLocale()]) }}" method="POST" class="add-to-cart-form m-0">
                                    @csrf
                                    <input type="hidden" name="old_price" value="{{ $price->old_price }}">
                                    <input type="hidden" name="type" value="{{ $price->type }}">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="{{ $totalStock }}">
                                    <input type="hidden" name="unit_price" value="{{ $price->unit_price}}">
                                    <input type="hidden" name="shelf_price" value="{{ $price->shelf_price }}">
                                    <input type="hidden" name="description" value="{{ $product->{'small_description_'.app()->getLocale()} ?? $product->small_description_en }}">
                                    <input type="hidden" name="name" value="{{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}">
                                    <input type="hidden" name="ea-ca" value="{{ $product->ea_ca ?? 12 }}">
                                    <input type="hidden" name="ea-pl" value="{{ $product->ea_pl ?? 144 }}">
                                    <input type="hidden" name="ea" value="{{ $price->EA }}">
                                    <input type="hidden" name="ca" value="{{ $price->CA }}">
                                    <input type="hidden" name="pl" value="{{ $price->PL }}">
                                    <button type="submit" class="border-0 bg-transparent p-0">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-sm btn-secondary" disabled>
                                    {{ __('cart.out_of_stock') ?: 'Out of Stock' }}
                                </button>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
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
        <h2 class="display-5 mb-4">{{ __('nav.categories') }}</h2>
        <div class="carousel mx-auto mb-5">
            @foreach($categories as $category)
            <div class="px-2">
                <div class="category-card" data-url="{{ route('website.category.index', ['locale' => app()->getLocale(), 'category' => $category->id]) }}">
                    <div class="category-card-body">
                        @if($category->extension)
                        <img src="{{ asset('storage/categories/' . $category->id . '.' . $category->extension) }}"
                            alt="{{ $category->{'name_'.app()->getLocale()} ?? $category->name_en }}"
                            class="img-fluid mb-5">
                        @endif
                        <h5 class="card-title">
                            <a href="{{ route('website.category.index', ['locale' => app()->getLocale(), 'category' => $category->id]) }}"
                                class="text-decoration-none text-dark">
                                {{ $category->{'name_'.app()->getLocale()} ?? $category->name_en }}
                            </a>
                        </h5>
                        <p class="card-text text-muted">
                            {{ $category->{'description_'.app()->getLocale()} ?? $category->description }}
                        </p>
                    </div>
                </div>
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
<section id="products" class="py-5 bg-light">
    <div class="container">
        <h2 class="display-5 text-center mb-4">{{ __('nav.products') }}</h2>
        <div class="carousel gx-0">
            @foreach($products as $product)
            @php
            $price = $product->listPrices->first();
            @endphp
            @if($price && $price->shelf_price > 0 )
            <div class="product-card mb-2" data-url="{{ route('website.product.index', ['locale' => app()->getLocale(), 'product' => $product->id]) }}">
                <div class="card">
                    <div class="card__shine"></div>
                    <div class="card__glow"></div>
                    <div class="card__content">
                        @if($product->created_at && $product->created_at->gt(\Illuminate\Support\Carbon::now()->subDays(7)))
                        <div class="card__badge new-badge">
                            {{ __('nav.new') }}
                        </div>
                        @endif
                        @php
                        $imagePath = 'products/' . $product->id . '.' . $product->extension;
                        $storage = \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath);
                        @endphp
                        <div style="--bg-color: #38bdf8" class="card__image">
                            @if($storage)
                            <img src="{{ asset('storage/products/' . $product->id . '.' . $product->extension) }}"
                                alt="{{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}"
                                class="img-fluid w-100 h-100 dynamic-fit" style="border-radius: 12px;">
                            @endif
                        </div>
                        <div class="card__text">
                            <p class="card__title">
                                <a href="{{ route('website.product.index', ['locale' => app()->getLocale(), 'product' => $product->id]) }}"
                                    class="text-decoration-none text-dark">
                                    {{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}
                                </a>
                            </p>
                            <p class="card__description">
                                {{ \Illuminate\Support\Str::limit($product->{'small_description_'.app()->getLocale()} ?? $product->small_description_en, 80) }}
                            </p>
                        </div>
                        <div class="card__footer">
                            <div class="card__price">
                                @if($price)
                                @if($price->old_price > $price->shelf_price)
                                <small class="text-muted text-decoration-line-through me-1">
                                    ${{ number_format($price->old_price, 2) }}
                                </small>
                                @endif
                                <span>${{ number_format($price->shelf_price, 2) }}</span>
                                @else
                                <span>{{ __('product.no_price') }}</span>
                                @endif
                            </div>
                            @php
                            $auth = auth('customer')->user();
                            $totalStock = $product->distributorStocks?->sum('stock') ?? 0;
                            @endphp
                            <div class=" card__button">
                                @if(!$auth)
                                <form action="{{ route('website.cart.store', ['locale' => app()->getLocale()]) }}" method="POST" class="add-to-cart-form m-0">
                                    @csrf
                                    <input type="hidden" name="old_price" value="{{ $price->old_price }}">
                                    <input type="hidden" name="type" value="{{ $price->type }}">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="{{ $totalStock }}">
                                    <input type="hidden" name="unit_price" value="{{ $price->unit_price}}">
                                    <input type="hidden" name="shelf_price" value="{{ $price->shelf_price }}">
                                    <input type="hidden" name="description" value="{{ $product->{'small_description_'.app()->getLocale()} ?? $product->small_description_en }}">
                                    <input type="hidden" name="name" value="{{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}">
                                    <input type="hidden" name="ea-ca" value="{{ $product->ea_ca ?? 12 }}">
                                    <input type="hidden" name="ea-pl" value="{{ $product->ea_pl ?? 144 }}">
                                    <input type="hidden" name="ea" value="{{ $price->EA }}">
                                    <input type="hidden" name="ca" value="{{ $price->CA }}">
                                    <input type="hidden" name="pl" value="{{ $price->PL }}">
                                    <button type="submit" class="border-0 bg-transparent p-0">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                                @else
                                @if($totalStock > 0)
                                <form action="{{ route('website.cart.store', ['locale' => app()->getLocale()]) }}" method="POST" class="add-to-cart-form m-0">
                                    @csrf
                                    <input type="hidden" name="old_price" value="{{ $price->old_price }}">
                                    <input type="hidden" name="type" value="{{ $price->type }}">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="{{ $totalStock }}">
                                    <input type="hidden" name="unit_price" value="{{ $price->unit_price}}">
                                    <input type="hidden" name="shelf_price" value="{{ $price->shelf_price }}">
                                    <input type="hidden" name="description" value="{{ $product->{'small_description_'.app()->getLocale()} ?? $product->small_description_en }}">
                                    <input type="hidden" name="name" value="{{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}">
                                    <input type="hidden" name="ea-ca" value="{{ $product->ea_ca ?? 12 }}">
                                    <input type="hidden" name="ea-pl" value="{{ $product->ea_pl ?? 144 }}">
                                    <input type="hidden" name="ea" value="{{ $price->EA }}">
                                    <input type="hidden" name="ca" value="{{ $price->CA }}">
                                    <input type="hidden" name="pl" value="{{ $price->PL }}">
                                    <button type="submit" class="border-0 bg-transparent p-0">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-sm btn-secondary" disabled>
                                    {{ __('cart.out_of_stock') ?: 'Out of Stock' }}
                                </button>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
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

@include('sanita.partials.contact-us')

@section('scripts')
<script>
    window.signinUrl = "{{ route('customer.signin', ['locale' => app()->getLocale()]) }}";
    window.csrfToken = "{{ csrf_token() }}";
    window.cartMessages = {
        addSuccess: "{{ __('nav.cart_add_success') }}",
        addFail: "{{ __('nav.cart_add_failed') }}",
        addError: "{{ __('nav.cart_add_error') }}"
    };
</script>
@endsection
@yield('scripts')
@endsection