@extends('sanita.layout')

@section('title', __('cart.title'))

@section('content')
<section id="cart" class="pt-5 bg-light">
    <div class="container px-5 mb-5">
        <h2 class="display-5 text-center mb-5">🛒 {{ __('cart.heading') }}</h2>

        @if($cart && $cart->cartDetails->count() > 0)
        <div class="d-flex flex-wrap justify-content-center gap-2">
            @php $cartTotal = 0; @endphp

            @foreach($cart->cartDetails as $detail)
            <div class="cart-item d-flex flex-row gap-1 p-3 bg-white rounded shadow-sm align-items-center flex-wrap w-100" data-id="{{ $detail->id }}">
                <img src="{{ asset('storage/products/' . $detail->product->id . '.' . $detail->product->extension) }}"
                    alt="{{ $detail->product->{'name_'.app()->getLocale()} ?? $detail->product->name_en }}"
                    class="cart-item-img rounded" style="width: 20%; height: 80%; object-fit: cover;">

                <div class="flex-grow-1 ms-2 mt-3 d-flex flex-column h-100">

                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-1">
                            {{ $detail->product->{'name_'.app()->getLocale()} ?? $detail->product->name_en }}
                        </h5>
                        <div class="fw-bold text-secondary total-price">${{ number_format($detail->extended_price, 2) }}</div>
                    </div>

                    <p class="text-muted small mb-2">
                        {{ \Illuminate\Support\Str::limit($detail->product->{'small_description_'.app()->getLocale()} ?? $detail->product->small_description_en, 80) }}
                    </p>

                    <div>
                        @if($detail->old_price && $detail->old_price > $detail->shelf_price)
                        <small class="text-decoration-line-through text-muted me-2">${{ number_format($detail->old_price, 2) }}</small>
                        @endif
                        <span class="fw-semibold text-dark">
                            ${{ number_format($detail->shelf_price, 2) }}
                            <span class="text-muted fs-6 ms-1">/ {{ $detail->UOM }}</span>
                        </span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <form class="update-quantity-form  d-flex align-items-center gap-2 mt-4 mb-2" method="POST" action="{{ route('website.cart.update', ['locale' => app()->getLocale(), 'cart' => $detail->id]) }}">
                            @csrf
                            @method('PUT')
                            <button type="button" class="btn btn-sm btn-decrease"><i class="fa fa-minus"></i></button>
                            <input type="text" name="quantity" class="quantity-input" value="{{ $detail->quantity_foreign }}">
                            <button type="button" class="btn btn-sm btn-increase"><i class="fa fa-plus"></i></button>
                        </form>
                        <form class="delete-item-form mt-2" method="POST" action="{{ route('website.cart.destroy', ['locale' => app()->getLocale(), 'cart' => $detail->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-item-btn" aria-label="Remove item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg" viewBox="0 0 24 24">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                    <path d="M10 11v6"></path>
                                    <path d="M14 11v6"></path>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-cart-alert text-center py-5 px-4 my-5 rounded-4 shadow-sm" style="background: #f9f9f9; border: 2px dashed var(--primary-blue); max-width: 500px; margin: 0 auto;">
            <div style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 0.5rem;">
                🛒
            </div>
            <div class="fs-4 fw-semibold mb-2" style="color: var(--primary-blue);">
                {{ __('cart.empty') }}
            </div>
            <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}" class="btn bubbles bubbles-arctic mt-3 px-4 py-2 fs-6 shadow-sm" style="border-radius: 2rem;">
                <span class="text"><i class="fa fa-arrow-left me-2"></i> {{ __('cart.browse_products') }}</span>
            </a>
        </div>
        @endif
    </div>

    @if($cart && $cart->cartDetails->count() > 0)
    <!-- Sticky Bottom Checkout Bar -->
    <div class="sticky-checkout-bar bg-white border-top shadow-sm py-3 px-4 d-flex justify-content-between align-items-center mb-0">
        <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}" class="btn bubbles me-2">
            <span class="text"><i class="fa fa-arrow-left me-1"></i> {{ __('cart.continue_shopping') }}</span>
        </a>
        <div class="d-flex align-items-center flex-direction-row gap-4">
            <h5 class="mb-0 fw-bold text-light">{{ __('cart.cart_total') }}: <span id="cart-total">${{ number_format($cart->total_amount, 2) }}</span></h5>
            <a href="{{ route('cart.checkout', ['locale' => app()->getLocale()]) }}" class="btn bubbles fw-semibold">
                <span class="text"><i class="fa fa-credit-card me-1"></i> {{ __('cart.proceed_checkout') }}</span>
            </a>
        </div>
    </div>
    @endif

</section>

<link href="{{ asset('css/cart.css') }}" rel="stylesheet" />
<script>
    window.cartMessages = {
        csrfToken: '{{ csrf_token() }}',
        updateSuccess: '{{ __("cart.update_success") }}',
        updateFailed: '{{ __("cart.update_failed") }}',
        updateError: '{{ __("cart.update_error") }}',
        removeConfirm: '{{ __("cart.remove_confirm") }}',
        removeSuccess: '{{ __("cart.remove_success") }}',
        removeFailed: '{{ __("cart.remove_failed") }}',
        removeError: '{{ __("cart.remove_error") }}'
    };
</script>

<script src="{{ asset('js/cart.js') }}"></script>
@endsection