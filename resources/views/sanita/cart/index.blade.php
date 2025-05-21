@extends('sanita.layout')

@section('title', 'Your Cart')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 display-5 text-center">🛒 Your Shopping Cart</h1>

    @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if($cart && $cart->cartDetails->count() > 0)
    <div class="table-responsive shadow rounded">
        <table class="table table-hover align-middle mb-4">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Product</th>
                    <th>Description</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th class="text-center">Action</th>
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
                        {{ $detail->product->name ?? 'Product not found' }}
                    </td>
                    <td class="text-muted">
                        {{ $detail->desc }}
                    </td>
                    <td>${{ number_format($detail->unit_price, 2) }}</td>
                    <td>
                        <form action="{{ route('cart.update', $detail->id) }}" method="POST" class="d-flex align-items-center gap-1">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="action" value="decrease" class="btn btn-sm btn-outline-secondary">−</button>
                            <span class="px-2">{{ $detail->quantity }}</span>
                            <button type="submit" name="action" value="increase" class="btn btn-sm btn-outline-primary">+</button>
                        </form>
                    </td>
                    <td class="fw-bold">${{ number_format($total, 2) }}</td>
                    <td class="text-center">
                        <form action="{{ route('cart.destroy', $detail->id) }}" method="POST" onsubmit="return confirm('Remove this item?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" type="submit" title="Remove">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr class="table-light fw-bold">
                    <td colspan="4" class="text-end">Cart Total:</td>
                    <td colspan="2">${{ number_format($cartTotal, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('sanita.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-1"></i> Continue Shopping
        </a>
        <a href="#" class="btn btn-success">
            <i class="fa fa-credit-card me-1"></i> Proceed to Checkout
        </a>
    </div>

    @else
    <div class="alert alert-info text-center">
        Your cart is currently empty.
        <br>
        <a href="{{ route('sanita.index') }}" class="btn btn-primary mt-3">Browse Products</a>
    </div>
    @endif
</div>
@endsection