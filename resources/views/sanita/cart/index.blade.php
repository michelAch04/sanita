@extends('sanita.layout')

@section('title', __('cart.title'))

@section('content')
<div class="container py-5">
    <h1 class="mb-4 display-5 text-center">🛒 {{ __('cart.heading') }}</h1>

    @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if($cart && $cart->cartDetails->count() > 0)
    <div class="table-responsive shadow rounded">
        <table class="table table-hover align-middle mb-4">
            <thead class="table-dark">
                <tr>
                    <th scope="col">{{ __('cart.product') }}</th>
                    <th>{{ __('cart.description') }}</th>
                    <th>{{ __('cart.unit_price') }}</th>
                    <th>{{ __('cart.quantity') }}</th>
                    <th>{{ __('cart.total') }}</th>
                    <th class="text-center">{{ __('cart.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @php $cartTotal = 0; @endphp
                @foreach($cart->cartDetails as $detail)
                @php
                $total = $detail->unit_price * $detail->quantity;
                $cartTotal += $total;
                @endphp
                <tr>
                    <td class="fw-semibold text-primary">
                        {{ $detail->product->name ?? __('cart.product_not_found') }}
                    </td>
                    <td class="text-muted">
                        {{ $detail->desc }}
                    </td>
                    <td>${{ number_format($detail->unit_price, 2) }}</td>
                    <td>
                        <form action="{{ route('cart.update',['locale' => app()->getLocale(),'cart' => $detail->id]) }}" method="POST" class="d-flex align-items-center gap-1">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="action" value="decrease" class="btn btn-sm btn-outline-secondary">−</button>
                            <span class="px-2">{{ $detail->quantity }}</span>
                            <button type="submit" name="action" value="increase" class="btn btn-sm btn-outline-primary">+</button>
                        </form>
                    </td>
                    <td class="fw-bold">${{ number_format($total, 2) }}</td>
                    <td class="text-center">
                        <form action="{{ route('cart.destroy',['locale' => app()->getLocale(),'cart' => $detail->id]) }}" method="POST" onsubmit="return confirm('{{ __('cart.remove_confirm') }}')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" type="submit" title="{{ __('cart.remove') }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr class="table-light fw-bold">
                    <td colspan="4" class="text-end">{{ __('cart.cart_total') }}</td>
                    <td colspan="2">${{ number_format($cartTotal, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-1"></i> {{ __('cart.continue_shopping') }}
        </a>
        <a href="#" class="btn btn-success">
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