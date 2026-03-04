@extends('sanita.layout')

@section('title', __('Order History'))

@php
$sortedOrders = $orders->sortByDesc('created_at');
@endphp

@section('content')
<section id="orders" class="pt-5">
    <div class="container px-5 mb-5">
        <h2 class="display-5 text-center mb-5 section-title">🧾 {{ __('order.your_orders') }}</h2>

        @if($sortedOrders->count())
        <div class="d-flex flex-column gap-2 orders-container">
            @foreach ($sortedOrders as $order)
            <div class="cart-item d-flex flex-row justify-content-between p-3 rounded shadow-sm flex-wrap w-100">
                {{-- Order Info --}}
                <div class="d-flex flex-column flex-grow-1 me-3">
                    <h4 class="mb-2 text-primary">
                        {{ __('order.order_number', ['number' => $order->id]) }}
                    </h4>

                    <p class="text-muted mb-1">
                        <i class="fa fa-calendar-alt me-1"></i> {{ __('order.placed_on') }}:
                        <span class="text-secondary fw-medium">
                            {{ $order->created_at->format('Y-m-d H:i') }}
                        </span>
                    </p>

                    <p class="text-muted mb-1">
                        <i class="fa fa-money-bill-wave me-1"></i>
                        {{ __('cart.subtotal') }}:
                        <span class="text-secondary fw-medium">
                            {{ number_format($order->total_amount, 2) }} {{ __('order.currency') }}
                        </span>
                    </p>
                    <p class="text-muted mb-1">
                        <i class="fa fa-info-circle me-1"></i> {{ __('order.status') }}:
                        <span class="text-secondary fw-medium">
                            {{ __($order->status->description ?? 'N/A') }}
                        </span>
                    </p>


                    <div class="mt-3">
                        <h6 class="mb-2 text-primary">{{ __('cart.shipping_address') }}</h6>
                        <p class="text-muted mb-1">
                            <i class="fa fa-map-marker-alt me-1"></i> {{ $order->address->governorate->name_en }}
                        </p>
                        <p class="text-muted mb-1">
                            <i class="fa fa-city me-1"></i> {{ $order->address->city->name_en }}, {{ $order->address->district->name_en }}
                        </p>
                        <p class="text-muted mb-0">
                            <i class="fa fa-home me-1"></i> {{ __('address.Street') }} {{ $order->address->street }}, {{ __('address.Building') }} {{ $order->address->building }}
                        </p>
                    </div>
                </div>

                {{-- Action (View / Details) --}}
                <div class="d-flex flex-column justify-content-between align-items-end">
                    <a href="{{ route('website.orders.reorder', ['locale' => app()->getLocale(), 'id' => $order->id]) }}" class="btn btn-sm bubbles bubbles-arctic order-action-btn">
                        <span class="text"><i class="fa fa-repeat me-1"></i> {{ __('order.order_again') }}</span>
                    </a>
                    <a href="{{ route('website.orders.show', ['locale' => app()->getLocale(), 'id' => $order->id]) }}" class="btn btn-sm bubbles bubbles-arctic order-action-btn" target="_blank">
                        <span class="text"><i class="fa fa-eye me-1"></i> {{ __('order.view_details') }}</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-cart-alert text-center py-5 px-4 my-5 rounded-4 shadow-sm">
            <div class="empty-cart-icon">📭</div>
            <div class="fs-4 fw-semibold mb-2 empty-cart-msg">
                {{ __('order.no_orders') }}
            </div>
        </div>
        @endif
    </div>
</section>
<style>
    p i {
        width: 1.2rem !important;
        text-align: center;
    }
</style>
<link rel="stylesheet" href="{{ asset('css/cart.css') }}" />
@include('components.modal')
@endsection