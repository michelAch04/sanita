@extends('sanita.layout')

@section('title', __('cart.title'))

@section('content')
<div class="container py-5">
    <h1 class="mb-4 display-5 text-center">🛒 {{ __('cart.heading') }}</h1>

    @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if($cart && count($items) > 0)
    <div class="table-responsive shadow rounded">
        <table class="table table-hover align-middle mb-4" id="cart-table">
            <thead class="table-dark">
                <tr>
                    <th>{{ __('cart.product') }}</th>
                    <th>{{ __('cart.description') }}</th>
                    <th>{{ __('cart.unit_price') }}</th>
                    <th>{{ __('cart.quantity') }}</th>
                    <th>{{ __('cart.total') }}</th>
                    <th class="text-center">{{ __('cart.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $detail)
                @php
                $total = $detail->unit_price * $detail->quantity;
                $product = $detail->product;
                @endphp
                <tr data-id="{{ $detail->id }}">
                    <td class="fw-semibold text-primary">
                        {!! $product->{'name_' . app()->getLocale()} !!}
                    </td>
                    <td class="text-muted">
                        {!! $product->{'small_description_' . app()->getLocale()} !!}
                    </td>
                    <td>${{ number_format($detail->unit_price, 2) }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-1 cart-quantity-controls" data-id="{{ $detail->id }}">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-decrease">−</button>
                            <span class="px-2 quantity-text">{{ $detail->quantity }}</span>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-increase">+</button>
                        </div>
                    </td>
                    <td class="fw-bold item-total">${{ number_format($total, 2) }}</td>
                    <td class="text-center">
                        <button class="btn btn-outline-danger btn-sm btn-delete-cart" data-id="{{ $detail->id }}" title="{{ __('cart.remove') }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach

                <tr class="table-light fw-bold">
                    <td colspan="4" class="text-end">{{ __('cart.cart_total') }}</td>
                    <td colspan="2" id="subtotal">${{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr class="table-light fw-bold">
                    <td colspan="4" class="text-end">{{ __('cart.delivery_charge') }}</td>
                    <td colspan="2" id="delivery-charge">${{ number_format($cart->delivery_charge, 2) }}</td>
                </tr>
                <tr class="table-light fw-bold">
                    <td colspan="4" class="text-end">{{ __('cart.grand_total') }}</td>
                    <td colspan="2" id="grand-total">${{ number_format($grandTotal, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-1"></i> {{ __('cart.continue_shopping') }}
        </a>
        <a href="" class="btn btn-success">
            <i class="fa fa-credit-card me-1"></i> {{ __('cart.proceed_checkout') }}
        </a>
    </div>

    @else
    <div class="alert alert-info text-center">
        {{ __('cart.empty') }}
        <br>
        <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}" class="btn btn-primary mt-3">{{ __('cart.browse_products') }}</a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // Increase or decrease quantity
        $('.cart-quantity-controls').on('click', '.btn-increase, .btn-decrease', function() {
            const $btn = $(this);
            const $container = $btn.closest('.cart-quantity-controls');
            const cartId = $container.data('id');
            const action = $btn.hasClass('btn-increase') ? 'increase' : 'decrease';

            $.ajax({
                url: `/{{ app()->getLocale() }}/cart/${cartId}`,
                type: 'PUT',
                data: {
                    action
                },
                success: function() {
                    location.reload(); // Optional: can dynamically update instead
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'Error updating cart.');
                }
            });
        });

        // Delete item
        $('.btn-delete-cart').on('click', function() {
            if (!confirm('{{ __("cart.remove_confirm") }}')) return;

            const cartId = $(this).data('id');

            $.ajax({
                url: `/{{ app()->getLocale() }}/cart/${cartId}`,
                type: 'DELETE',
                success: function() {
                    location.reload(); // Optional: can dynamically update instead
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'Error deleting item.');
                }
            });
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>

@endpush