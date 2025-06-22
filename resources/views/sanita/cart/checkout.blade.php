@extends('sanita.layout')

@section('title', __('Checkout'))

@section('content')
<div class="py-5 w-100 px-5">
    {{-- Main Checkout Form --}}
    <form method="POST" action="">
        @csrf
        <h2 class="display-5 login-title text-center mb-4 mt-4">{{ __('cart.checkout') }}</h2>

        {{-- Cart Items Section --}}
        <h3 class="fw-bold mb-3">{{ __('cart.your_items') }}</h3>
        <hr class="section-divider">
        <div class="row g-4 mb-5 w-100">
            @forelse($cart->cartDetails as $item)
            <div class="col-md-4">
                <div class="cart-item d-flex flex-row gap-3 p-3 rounded shadow-sm align-items-start h-100">
                    <img src="{{ asset('storage/products/' . $item->product->id . '.' . $item->product->extension) }}" alt="product" class="cart-item-img rounded">
                    <div class="flex-grow-1">
                        <h5 class="fw-semibold mb-1">{{ $item->product->{'name_' . app()->getLocale()} }}</h5>
                        <p class="text-muted small mb-2">{{ $item->product->{'small_description_' . app()->getLocale()} }}</p>
                        <p class="mb-1">
                            @if ($item->old_price && $item->old_price > $item->shelf_price)
                            <span class="text-decoration-line-through text-muted me-2">${{ number_format($item->old_price, 2) }}</span>
                            @endif
                            <span class="fw-semibold">${{ number_format($item->shelf_price, 2) }}</span>
                        </p>
                        <p class="mb-0"><small>{{ __('cart.quantity') }}: {{ $item->quantity }}</small></p>
                        <p><small>{{ __('cart.total') }}: ${{ number_format($item->shelf_price * $item->quantity, 2) }}</small></p>
                    </div>
                </div>
            </div>
            @empty
            <p>{{ __('cart.no_items') }}</p>
            @endforelse
        </div>

        {{-- Shipping Address --}}
        <h3 class="fw-bold mb-3">{{ __('cart.shipping_address') }}</h3>
        <hr class="section-divider">
        <div class="mb-4">
            <div class="input-container" style="max-width: 400px; position: relative;">
                <label for="address_id" class="form-label fw-semibold">{{ __('cart.shipping_address') }}</label>
                <select id="address_id" name="address_id" class="form-select styled-select" required>
                    <option value="">{{ __('cart.select_address') }}</option>
                    @foreach($addresses as $address)
                    <option value="{{ $address->id }}" {{ $address->is_default ? 'selected' : '' }}>
                        {{ $address->title }} — {{ $address->street }}, {{ $address->building }}, {{ $address->floor }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="button" onclick="window.location='{{ route('addresses.create', app()->getLocale()) }}'" class="btn btn-outline-primary mt-3">
                + {{ __('cart.add_address') }}
            </button>
        </div>

        {{-- Payment Method --}}
        <h3 class="fw-bold mb-3">{{ __('cart.payment_method') }}</h3>
        <hr class="section-divider">
        <p class="mb-5">{{ __('cart.cod') }}</p>

        {{-- Promo Code --}}
        <h3 class="fw-bold mb-3">{{ __('cart.promo_code') }}</h3>
        <hr class="section-divider">
        <div class="promo mb-5">
            <form method="POST" action="" class="row g-2 align-items-center">
                @csrf
                <div class="col">
                    <input type="text" name="promo_code" placeholder="{{ __('cart.enter_promo_code') }}" class="form-control input_field">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">{{ __('cart.apply') }}</button>
                </div>
            </form>
        </div>

        {{-- Totals --}}
        <h3 class="fw-bold mb-3">{{ __('cart.payment') }}</h3>
        <hr class="section-divider">
        <div class="payments mb-5">
            <div class="details">
                <div class="d-flex justify-content-between"><span>{{ __('cart.subtotal') }}:</span><span>${{ number_format($subtotal, 2) }}</span></div>
                <div class="d-flex justify-content-between"><span>{{ __('cart.vat') }}:</span><span>${{ number_format($totalTax, 2) }}</span></div>
                <div class="d-flex justify-content-between total-price"><span>{{ __('cart.total') }}:</span><span>${{ number_format($total, 2) }}</span></div>
            </div>
        </div>
</div>
{{-- Checkout Footer --}}
<div class="sticky-checkout-bar checkout bg-white border-top shadow-sm py-3 px-4 d-flex justify-content-between align-items-center mb-0">
    <label class="price">{{ number_format($total, 2) }} {{ __('cart.currency') }}</label>
    <button type="submit" class="btn bubbles fw-semibold fs-6"><span class="text">{{ __('cart.place_order') }}</span></button>
</div>
</form>

{{-- Styles --}}
<link href="{{ asset('css/cart.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<script>
    $(document).ready(function() {
        $('#address_id').select2({
            placeholder: "{{ __('cart.select_address') }}",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@include('sanita.partials.select2-style')
@endsection