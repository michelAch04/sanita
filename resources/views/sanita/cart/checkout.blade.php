@extends('sanita.layout')

@section('title', __('Checkout'))

@section('content')
<div class="checkout-wrapper container-fluid py-5 px-0 {{ $isRtl ? 'rtl-container' : '' }}">
    <form method="POST" action="{{ route('website.checkout.place_order', ['locale' => app()->getLocale()]) }}">
        @csrf

        <h2 class="display-5 text-center mb-5 section-title">{{ __('cart.checkout') }}</h2>

        {{-- MAIN GRID --}}
        <div class="row gy-4 px-0 mx-0">
            <!-- LEFT COLUMN: CART ITEMS -->
            <div class="col-lg-6 checkout-items-container">
                <div class="checkout-card p-4 shadow-sm rounded">
                    <h3 class="fw-bold mb-3 text-primary">{{ __('cart.your_items') }}</h3>
                    <div class="section-divider mb-4"></div>
                    <div class="d-flex flex-wrap justify-content-center gap-2 items-container">
                        @forelse($cart->cartDetails as $detail)
                        <div class="cart-item d-flex flex-row gap-1 p-3 align-items-start w-100 position-relative" data-id="{{ $detail->id }}">
                            <div class="cart-item-header flex-grow-1 cursor-pointer">
                                <div class="cart-img-container">
                                    <img src="{{ asset('storage/products/' . $detail->product->id . '.' . $detail->product->extension) }}"
                                        alt="{{ $detail->product->{'name_'.app()->getLocale()} ?? $detail->product->name_en }}"
                                        class="cart-item-img rounded">
                                </div>
                                <div class="cart-item-intro d-flex justify-content-between flex-column d-none ps-1 overflow-hidden">
                                    <h5 class="fallback-title text-primary m-0">
                                        {{ $detail->product->{'name_'.app()->getLocale()} ?? $detail->product->name_en }}
                                    </h5>
                                    <p class="fallback-description text-muted small m-0 text-truncate">
                                        {{ \Illuminate\Support\Str::limit($detail->product->{'small_description_'.app()->getLocale()} ?? $detail->product->small_description_en, 80) }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex-grow-1 ms-2 d-flex flex-column justify-content-between w-100 cart-item-content h-100 overflow-hidden">
                                <div class="cart-item-main">
                                    <div class=" d-block">
                                        <h5 class="mb-1 text-primary checkout-item-title">
                                            {{ $detail->product->{'name_'.app()->getLocale()} ?? $detail->product->name_en }}
                                        </h5>
                                        <p class="text-muted small mb-2 text-truncate w-100">
                                            {{ \Illuminate\Support\Str::limit($detail->product->{'small_description_'.app()->getLocale()} ?? $detail->product->small_description_en, 80) }}
                                        </p>
                                    </div>

                                    <div class="cart-item-conf d-flex flex-column">
                                        <div class="cart-item-price">
                                            @if($detail->old_price && $detail->old_price > $detail->shelf_price)
                                            <small class="text-decoration-line-through text-muted me-0 old-cart-item-price">IQD {{ number_format($detail->old_price, 0) }}</small>
                                            @endif
                                            <span class="fw-medium text-primary">
                                                IQD {{ number_format($detail->shelf_price, 0) }}
                                                <span class="text-muted fs-6">/ {{ $detail->UOM }}</span>
                                            </span>
                                        </div>

                                        <p class="mb-0 mt-1 text-muted">
                                            {{ __('cart.quantity') }}: <span class="text-primary">{{ $detail->quantity_foreign }}</span> / {{ __('cart.' . $detail->UOM) }}
                                        </p>
                                    </div>
                                </div>

                                {{-- TOTAL FIXED AT BOTTOM --}}
                                <div class="mt-auto d-flex justify-content-end align-items-center pt-3 checkout-item-total">
                                    <div class="fw-semibold text-secondary total-price fs-6">
                                        {{ __('cart.total') }}: IQD {{ number_format($detail->extended_price, 2) }}
                                    </div>
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
            <div class="col-lg-5 shipping-info">
                <div class="checkout-card right-side-card sticky-lg-top p-4 shadow-sm rounded bg-secondary">
                    <h3 class="fw-bold mb-3 text-primary">{{ __('cart.shipping_info') }}</h3>
                    <div class="section-divider mb-4"></div>

                    <div class="d-flex justify-content-between align-items-start flex-direction-row mb-0">
                        <h5 class="fw-medium mb-2 mt-1 text-primary">
                            {{ __('cart.shipping_address') }}
                        </h5>
                        <button type="button"
                            data-bs-toggle="modal" data-bs-target="#addAddressModal"
                            class="btn underline-btn border-0">
                            + {{ __('cart.add_address') }}
                        </button>
                    </div>
                    <div class="login-inputForm mb-5">
                        <select id="address_id" name="address_id" class="login-input" required>
                            <option value="">{{ __('cart.select_address') }}</option>
                            @foreach($addresses as $address)
                            <option value="{{ $address->id }}" {{ $address->is_default ? 'selected' : '' }}>
                                {{ $address->title }} —
                                {{ $address->city->{'name_' . app()->getLocale()} ?? $address->city->name_en }},
                                {{ $address->district->{'name_' . app()->getLocale()} ?? $address->district->name_en }}
                                | Street {{ $address->street }}, Building {{ $address->building }}, Floor {{ $address->floor }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="payment-method mb-5">
                        <h5 class="fw-medium mb-2 text-primary">{{ __('cart.payment_method') }}</h5>
                        <p class="text-muted ps-4">{{ __('cart.cod') }}</p>
                        <input type="hidden" name="payment_method" value="Cash On Delivery">
                    </div>

                    <h5 class="fw-medium mb-2 text-primary">{{ __('cart.promo_code') }}</h5>
                    <div class="promo mb-4 d-flex gap-3 align-items-center flex-direction-row">
                        <div class="login-inputForm promo-code-container">
                            <input type="text" id="promo_code" name="promo_code"
                                class="login-input w-100 text-primary" placeholder="{{__('cart.Enter_Promo_Code')}}">
                        </div>
                        <div>

                            <button type="button" id="applyPromoBtn" class="btn underline-btn">{{ __('cart.apply') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOTALS FULL WIDTH --}}
        <div class="totals-row sticky-bottom shadow-sm mt-4 py-2 px-5 bottom-0 w-100">
            <div class="d-flex flex-row justify-content-between align-items-start align-items-md-center">
                <div class="totals-left">
                    <p class="mb-1"><strong>{{ __('cart.subtotal') }}:</strong> IQD {{ number_format($subtotal, 2) }}</p>
                    <p class="mb-1"><strong>{{ __('cart.vat') }}:</strong> IQD {{ number_format($totalTax, 2) }}</p>
                </div>
                <div class="totals-right d-flex justify-content-end flex-row mt-3 mt-md-0 h-100 gap-3">
                    <p class="my-auto fs-5 fw-bold">{{ __('cart.total') }}: IQD {{ number_format($total, 2) }}</p>
                    <button type="submit" class="btn bubbles fw-medium fs-6 mt-auto">
                        <span class="text">{{ __('cart.place_order') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-centered modal-lg d-flex justify-content-center">
        <div class="modal-content p-3 pb-2 w-75 bg-secondary">
            <div class="modal-header border-0">
                <h2 class="display-5 login-title text-center mb-0 fs-1">{{ __('Add New Address') }}</h2>
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
@include('sanita.partials.select2',[
'id' => '#address_id',
'placeholder' => "{{ __('cart.select_address') }}"
])
<style>
    .select2-selection__rendered {
        padding-right: 3rem !important;
    }

    .login-inputForm:focus-within {
        border: 1.5px solid #38B2AC;
    }
</style>

@endsection