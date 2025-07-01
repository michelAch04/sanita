@extends('sanita.layout')
@php
$isRtl = app()->getLocale() === 'ar' || app()->getLocale() === 'ku';
@endphp
@section('title', __('Checkout'))

@section('content')
<div class="checkout-wrapper container-fluid py-5 px-0 {{ $isRtl ? 'rtl-container' : '' }}">
    <form method="POST" action="">
        @csrf

        <h2 class="display-5 login-title text-center mb-5">{{ __('cart.checkout') }}</h2>

        {{-- MAIN GRID --}}
        <div class="row gy-4 px-0 mx-0">
            <!-- LEFT COLUMN: CART ITEMS -->
            <div class="col-lg-6">
                <div class="checkout-card p-4 shadow-sm rounded bg-white">
                    <h3 class="fw-bold mb-3">{{ __('cart.your_items') }}</h3>
                    <div class="section-divider mb-4"></div>
                    <div class="row gy-0">
                        @forelse($cart->cartDetails as $item)
                        <div class="col-12">
                            <div class="d-flex gap-3 align-items-start">
                                <img src="{{ asset('storage/products/' . $item->product->id . '.' . $item->product->extension) }}"
                                    alt="product" class="cart-item-img rounded">
                                <div class="flex-grow-1">
                                    <h5 class="fw-semibold mb-1">{{ $item->product->{'name_' . app()->getLocale()} }}</h5>
                                    <p class="text-muted small mb-2">{{ $item->product->{'small_description_' . app()->getLocale()} }}</p>
                                    <p class="mb-1">
                                        @if ($item->old_price && $item->old_price > $item->shelf_price)
                                        <span class="text-decoration-line-through text-muted me-2">${{ number_format($item->old_price, 2) }}</span>
                                        @endif
                                        <span class="fw-semibold">${{ number_format($item->shelf_price, 2) }}</span>
                                    </p>
                                    <p class="mb-0"><small>{{ __('cart.quantity') }}: {{ $item->quantity_ea }} / {{$item->UOM}}</small></p>
                                    <p><small>{{ __('cart.total') }}: ${{ number_format($item->extended_price, 2) }}</small></p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p>{{ __('cart.no_items') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: STICKY ON DESKTOP -->
            <div class="col-lg-5">
                <div class="checkout-card right-side-card sticky-lg-top p-4 shadow-sm rounded bg-white">
                    <h3 class="fw-bold mb-3">{{ __('cart.shipping_info') }}</h3>
                    <div class="section-divider mb-4"></div>

                    <div class="d-flex justify-content-between align-items-start flex-direction-row mb-0">
                        <h5 class="fw-semibold mb-2 mt-1">{{ __('cart.shipping_address') }}</h5>
                        <button type="button"
                            data-bs-toggle="modal" data-bs-target="#addAddressModal"
                            class="btn underline-btn border-0">
                            + {{ __('cart.add_address') }}
                        </button>
                    </div>
                    <div class="login-inputForm">
                        <select id="address_id" name="address_id" class="login-input" required>
                            <option value="">{{ __('cart.select_address') }}</option>
                            @foreach($addresses as $address)
                            <option value="{{ $address->id }}" {{ $address->is_default ? 'selected' : '' }}>
                                {{ $address->title }} — {{ $address->city->name_en }}, {{ $address->district->name_en }} 
                                | Street {{ $address->street }}, Building {{ $address->building }}, Floor {{ $address->floor }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <h5 class="fw-semibold mb-2 mt-5">{{ __('cart.payment_method') }}</h5>
                    <p class="mb-5">{{ __('cart.cod') }}</p>

                    <h5 class="fw-semibold mb-2">{{ __('cart.promo_code') }}</h5>
                    <div class="promo mb-4 d-flex gap-3 align-items-center flex-direction-row">
                        <div class="login-inputForm" style="width: 40%;">
                            <input type="text" id="promo_code" name="promo_code"
                            class="login-input" style="width: 100%;" placeholder="Enter Promo Code">
                        </div>
                        <div>
                            <button type="submit" class="btn underline-btn">{{ __('cart.apply') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOTALS FULL WIDTH --}}
        <div class="totals-row shadow-sm mt-4 py-2 px-5 bottom-0 w-100">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="totals-left">
                    <p class="mb-1"><strong>{{ __('cart.subtotal') }}:</strong> ${{ number_format($subtotal, 2) }}</p>
                    <p class="mb-1"><strong>{{ __('cart.vat') }}:</strong> ${{ number_format($totalTax, 2) }}</p>
                </div>
                <div class="totals-right d-flex justify-content-end flex-direction-row mt-3 mt-md-0 h-100 gap-3">
                    <p class="my-auto fs-5 fw-bold">{{ __('cart.total') }}: ${{ number_format($total, 2) }}</p>
                    <button type="submit" class="btn bubbles fw-semibold fs-6 mt-auto">
                        <span class="text">{{ __('cart.place_order') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg d-flex justify-content-center">
        <div class="modal-content p-3 pb-2" style="width: 75%;">
            <div class="modal-header" style="border: none !important;">
                <h2 class="display-5 login-title text-center mb-0" style="font-size: 2.5rem;">{{ __('Add New Address') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                @include('sanita.addresses.create') {{-- We'll extract the form here --}}
            </div>
        </div>
    </div>
</div>

{{-- Styles --}}
<link href="{{ asset('css/cart.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .login-inputForm:focus-within {
        border: 1.5px solid #38B2AC;
    }
</style>

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