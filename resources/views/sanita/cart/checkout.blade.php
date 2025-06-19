@extends('sanita.layout')

@section('title', __('Checkout'))

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-4">{{ __('cart.checkout') }}</h2>

    {{-- All content in one block --}}
    <div>

        {{-- Shipping Address --}}
        <h4>{{ __('cart.shipping_address') }}</h4>
        @if($addresses->isNotEmpty())
        @foreach($addresses as $address)
        <div class="mb-2">
            <input type="radio" name="address_id" id="address{{ $address->id }}" value="{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }}>
            <label for="address{{ $address->id }}">
                🏠 {{ $address->title }} —
                {{ $address->street }}, {{ $address->building }}, {{ $address->floor }}
                @if($address->notes)
                ({{ $address->notes }})
                @endif
            </label>
        </div>
        @endforeach
        @else
        <p>{{ __('cart.no_address_found') }}</p>
        <a href="{{ route('customer.address.create', app()->getLocale()) }}">{{ __('cart.add_address') }}</a>
        @endif

        <hr>

        {{-- Cart Items --}}
        <h4>{{ __('cart.your_items') }}</h4>
        @forelse($cart->cartDetails as $item)
        <div class="mb-3 d-flex gap-3 align-items-start">
            <div>
                <img src="{{ asset('storage/products/' . $item->product->image) }}" alt="product" width="80">
            </div>
            <div>
                <strong>{{ $item->product->{'name_' . app()->getLocale()} }}</strong><br>
                {{ $item->product->{'small_description_' . app()->getLocale()} }}<br>
                {{ __('cart.price') }}: {{ number_format($item->unit_price, 2) }} {{ __('cart.currency') }}<br>

                @if ($item->old_price && $item->old_price > $item->unit_price)
                {{ __('cart.old_price') }}:
                <del class="text-danger">{{ number_format($item->old_price, 2) }} {{ __('cart.currency') }}</del><br>
                @endif

                {{ __('cart.quantity') }}: {{ $item->quantity }}<br>
                {{ __('cart.total') }}: {{ number_format($item->unit_price * $item->quantity, 2) }} {{ __('cart.currency') }}
            </div>
        </div>
        @empty
        <p>{{ __('cart.no_items') }}</p>
        @endforelse

        <hr>

        {{-- Promo Code --}}
        <h4>{{ __('cart.promo_code') }}</h4>
        <form class="mb-3">
            <input type="text" name="promo_code" placeholder="{{ __('cart.enter_promo_code') }}">
            <button type="submit">{{ __('cart.apply') }}</button>
        </form>

        <hr>

        {{-- Summary and Purchase --}}
        <div>
            <p>{{ __('cart.subtotal') }}: <strong>{{ number_format($subtotal, 2) }} {{ __('cart.currency') }}</strong></p>
            <p>{{ __('cart.vat') }}: <strong>{{ number_format($totalTax, 2) }} {{ __('cart.currency') }}</strong></p>
            <p>{{ __('cart.total') }}: <strong>{{ number_format($total, 2) }} {{ __('cart.currency') }}</strong></p>

            <form action="" method="POST">
                @csrf
                <input type="hidden" name="address_id" id="selected-address">
                <button type="submit">{{ __('cart.place_order') }}</button>
            </form>
        </div>

    </div>
</div>

<script>
    // Handle address selection
    document.querySelectorAll('input[name="address_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('selected-address').value = this.value;
        });
    });

    // Set default address on page load
    document.addEventListener('DOMContentLoaded', function() {
        const checked = document.querySelector('input[name="address_id"]:checked');
        if (checked) {
            document.getElementById('selected-address').value = checked.value;
        }
    });
</script>
@endsection