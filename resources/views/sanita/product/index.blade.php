@extends('sanita.layout')

@section('title', $product->{'name_' . app()->getLocale()})

@section('content')
@php
$auth = auth('customer')->user();
$type = $auth->type ?? 'b2c';
$prices = $product->listPrices->where('type', $type);
$price = $prices->where('UOM', 'EA')->first() ?? $prices->where('UOM', 'CA')->first() ?? $prices->where('UOM', 'PL')->first();
$availableUOMs = $prices->where('type', $type)->pluck('UOM')->toArray();
$totalStock = $product->distributorStocks?->sum('stock') ?? 0;
$uomLabels = [
'EA' => __('cart.EA'),
'CA' => __('cart.CA'),
'PL' => __('cart.PL'),
];
$cartProductIds = [];
if ($auth) {
$cart = \App\Models\Cart::with('cartDetails')
->where('customers_id', $auth->id)
->first();

if ($cart) {
$cartProductIds = $cart->cartDetails->pluck('products_id')->toArray();
}
}
$inCart = in_array($product->id, $cartProductIds);

@endphp

<div class="product-container product-page">
    <!-- Left Column / Product Image -->
    <div class="left-column">
        <img src="{{ asset('storage/products/' .$product->id .'.' .  $product->extension ) }}"
            alt="{{ $product->{'name_' . app()->getLocale()} }}"
            class="active product-image">
    </div>

    <!-- Right Column -->
    <div class="right-column">
        <!-- Product Description -->
        <div class="product-description">
            <span>{{ __('nav.products') }}</span>
            <h1>{{ $product->{'name_' . app()->getLocale()} }}</h1>
            <p>{{ $product->{'small_description_' . app()->getLocale()} ?? __('product.no_description') }}</p>
        </div>

        <div class="product-classification">
            <p class="mb-0 text-tertiary fw-light">{{ __('product.category') }}:
                <span class="text-primary fw-normal">{{ $product->subcategories->{'name_' . app()->getLocale()} }}</span>
            </p>
            <p class="text-tertiary fw-light">{{ __('product.brand') }}:
                <span class="text-primary fw-normal">{{ $product->brand->{'name_' . app()->getLocale()} }}</span>
            </p>
        </div>

        <!-- Product Configuration -->
        <form action="{{ route('website.cart.store', ['locale' => app()->getLocale()]) }}"
            method="POST" class="add-to-cart-form" data-available-uoms="{{ json_encode($prices->where('type', $type)->pluck('UOM')) }}">
            @csrf
            <div class="product-configuration pb-3">
                <!-- UOM Selection (replaces cable config) -->
                <div class="select-container mt-3 position-relative d-flex align-items-start flex-column">
                    <label for="status" class="label">{{ __('cart.order-per') }}</label>
                    <div class="mt-2">
                        @foreach ($availableUOMs as $uom)
                        <label for="uom-{{ $uom }}" class="select-label">
                            <input type="radio" id="uom-{{ $uom }}" name="UOM" value="{{ $uom }}" {{ $loop->first ? 'checked' : '' }}>
                            <span>{{ $uomLabels[$uom] ?? $uom }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div id="conversionText" class="mb-1 mt-1 text-muted small">
                    @if($availableUOMs[0] !== 'EA')
                    {{ __($availableUOMs[0] === 'CA' ? 'cart.conversion_case_each' : 'cart.conversion_pallet_each', [
                    'count' => $availableUOMs[0] === 'CA' ? $product->ea_ca ?? 12 : $product->ea_pl ?? 144,
                    ]) }}
                    @endif
                </div>

                <!-- Quantity Selector -->
                <div class="product-quantity mt-3">
                    <span>{{ __('cart.quantity') }}</span>
                    <div class="update-quantity-form align-items-center d-flex mb-2">
                        <button type="button" class="btn btn-sm btn-decrease"><i class="fa fa-minus"></i></button>
                        <input type="text" name="quantity" class="quantity-input" value="{{ $price->min_quantity_to_order ?? 1 }}">
                        <button type="button" class="btn btn-sm btn-increase"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>

            <!-- Product Price -->
            <div class="product-price">
                <div>
                    <span id="oldPrice" class="old-price text-muted text-decoration-line-through" style="display: {{ ($price->old_price && $price->old_price > $price->shelf_price) ? 'inline' : 'none' }};">
                        ${{ number_format($price->old_price, 2) }}
                    </span>
                    <span id="shelfPrice" class="new-price fw-medium">
                        ${{ number_format($price->shelf_price, 2) }}
                    </span>
                </div>

                @if (!$auth)
                {{-- Not logged in --}}
                <button type="submit" class="btn btn-arctic">
                    <i class="fas fa-cart-plus me-2"></i> {{ __('cart.add_to_cart') }}
                </button>
                @elseif ($totalStock <= 0)
                    {{-- Out of stock --}}
                    <button class="btn btn-disabled" disabled>
                    <i class="fa-solid fa-ban me-2"></i> {{ __('cart.out_of_stock') }}
                    </button>
                    @elseif ($inCart)
                    {{-- Already in cart --}}
                    <a href="{{ route('website.cart.index', ['locale' => app()->getLocale()]) }}" class="btn btn-success">
                        <i class="fas fa-shopping-cart me-2"></i>{{ __('cart.view_in_cart') }}
                    </a>
                    @else
                    {{-- In stock and not in cart --}}
                    <button type="submit" class="btn btn-arctic" id="addToCartSubmit">
                        <i class="fas fa-cart-plus me-2"></i>{{ __('cart.add_to_cart') }}
                    </button>
                    @endif
            </div>
            @include('sanita.partials.product-inputs', [$prices, $price])
        </form>
    </div>
    <div id="productPageForm">
        <form id="addToCartForm">
            @include('sanita.partials.add-to-cart-needs')
            <input type="hidden" id="modalProductQuantity" name="modalProductQuantity">
        </form>
    </div>
</div>

<link href="{{ asset('css/product-page.css') }}" rel="stylesheet">
@php
$productPrices = $prices->keyBy('UOM')->map(function($item) {
return [
'shelf_price' => $item->shelf_price,
'old_price' => $item->old_price,
];
});
@endphp
<script>
    window.productPrices = @json($productPrices);
    window.isProductPage = true;
</script>
<script src="{{ asset('js/quantity-script.js') }}"></script>
<script src="{{ asset('js/product-page.js') }}"></script>
@endsection