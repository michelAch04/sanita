@php
$prices = $product->listPrices;
$auth = auth('customer')->user();
$type = $auth->type ?? 'b2c';
$price = $prices->where('UOM', 'EA')->first();
$imagePath = 'products/' . $product->id . '.' . $product->extension;
$storage = \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath);
$auth = auth('customer')->user();
$totalStock = $product->distributorStocks?->sum('stock') ?? 0;
$badge = $badge ?? ($cardType === 'offer' ? __('nav.offer') : ($cardType === 'new' ? __('nav.new') : __('nav.product')));

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

@if($price && $price->shelf_price > 0)
<div class="product-card mb-4  {{ !$auth || $totalStock > 0 ? '' : 'out-of-stock-card' }}" data-url="{{ route('website.product.index', ['locale' => app()->getLocale(), 'product' => $product->id]) }}">
    <div class="card">
        <div class="card__shine"></div>
        <div class="card__glow"></div>
        <div class="card__content">

            <div class="card__badge {{ $cardType === 'offer' ? 'offer-badge' : ($cardType === 'new' ? 'new-badge' : 'd-none') }}">
                {{ $badge }}
            </div>

            <div style="--bg-color: {{ $cardType === 'offer' ? '#a78bfa' : '#38bdf8' }}" class="card__image">
                @if($storage)
                <img src="{{ asset('storage/' . $imagePath) }}"
                    alt="{{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}"
                    class="img-fluid w-100 h-100 dynamic-fit" style="border-radius: 0.75rem;">
                @endif
            </div>

            <div class="card__text">
                <p class="card__title">
                    <a href="{{ route('website.product.index', ['locale' => app()->getLocale(), 'product' => $product->id]) }}"
                        class="text-decoration-none text-primary">
                        {{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}
                    </a>
                </p>
                <p class="card__description">
                    {{ \Illuminate\Support\Str::limit($product->{'small_description_'.app()->getLocale()} ?? $product->small_description_en, 80) }}
                </p>
            </div>

            <div class="card__footer">
                <div class="card__price">
                    @if($price->old_price > $price->shelf_price)
                    <small class="text-muted text-decoration-line-through me-1">
                        IQD {{ number_format($price->old_price, 2) }}
                    </small>
                    @endif
                    <span>IQD {{ number_format($price->shelf_price, 2) }}</span>
                </div>
            </div>

            <div class="card__button-container mt-0">
                @if (!$auth)
                {{-- Not logged in --}}
                <form action="{{ route('website.cart.store', ['locale' => app()->getLocale()]) }}"
                    method="POST" class="add-to-cart-form m-0"
                    data-available-uoms="{{ json_encode($prices->where('type', $type)->pluck('UOM')) }}">
                    @csrf
                    @include('sanita.partials.product-inputs', [$prices, $price])
                    <button type="submit" class="card__button">
                        <i class="fas fa-cart-plus"></i> {{ __('cart.add_to_cart') }}
                    </button>
                </form>
                @elseif ($totalStock <= 0)
                    {{-- Out of stock --}}
                    <button class="card__button" disabled>
                    <i class="fa-solid fa-ban"></i> {{ __('cart.out_of_stock') }}
                    </button>
                    @elseif ($inCart)
                    {{-- Already in cart --}}
                    <a href="{{ route('website.cart.index', ['locale' => app()->getLocale()]) }}" class="card__button card__button-incart">
                        <i class="fas fa-shopping-cart"></i>{{ __('cart.view_in_cart') }}
                    </a>
                    @else
                    {{-- In stock and not in cart --}}
                    <form action="{{ route('website.cart.store', ['locale' => app()->getLocale()]) }}"
                        method="POST" class="add-to-cart-form m-0"
                        data-available-uoms="{{ json_encode($prices->where('type', $type)->pluck('UOM')) }}">
                        @csrf
                        @include('sanita.partials.product-inputs', [$prices, $price])
                        <button type="submit" class="card__button">
                            <i class="fas fa-cart-plus"></i> {{ __('cart.add_to_cart') }}
                        </button>
                    </form>
                    @endif
            </div>
        </div>
    </div>
</div>
@endif