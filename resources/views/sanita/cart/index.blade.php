@extends('sanita.layout')

@section('title', __('cart.title'))

@section('content')
<div class="container py-5">
    <h1 class="mb-4 display-5 text-center">🛒 {{ __('cart.heading') }}</h1>

    <div id="cart-message" class="text-center fw-semibold mb-3"></div>

    @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if($cart && $cart->cartDetails->count() > 0)
    <div class="table-responsive shadow rounded">
        <table class="table table-hover align-middle mb-4">
            <thead class="table-dark">
                <tr>
                    <th>image</th>
                    <th>{{ __('cart.product') }}</th>
                    <th>{{ __('cart.description') }}</th>
                    <th>{{ __('cart.shelf_price') }}</th>
                    <th>{{ __('cart.old_price') }}</th>
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
                <tr data-id="{{ $detail->id }}">
                    <td><img style="width: 150px;" src="{{ asset('storage/products/'.$detail->product->id.'.'.$detail->product->extension) }}" alt="Product Image"></td>
                    <td class="fw-semibold text-primary">{{ $detail->product->{'name_'.app()->getLocale()} ?? $detail->product->name_en }}</td>
                    <td class="text-muted">{{ $detail->product->{'small_description_'.app()->getLocale()} ?? $detail->product->name_en }}</td>
                    <td>${{ number_format($detail->unit_price, 2) }}</td>
                    <td>
                        @if($detail->old_price && $detail->old_price > $detail->unit_price)
                        <del class="text-danger">${{ number_format($detail->old_price, 2) }}</del>
                        @else
                        —
                        @endif
                    </td>
                    <td>
                        <form class="update-quantity-form d-inline-flex align-items-center" method="POST" action="{{ route('cart.update', ['locale' => app()->getLocale(), 'cart' => $detail->id]) }}">
                            @csrf
                            @method('PUT')
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-decrease">−</button>
                            <input type="text" name="quantity" class="form-control form-control-sm quantity-input mx-1 text-center" value="{{ $detail->quantity }}" style="width: 50px;">
                            <button type="button" class="btn btn-sm btn-outline-primary btn-increase">+</button>
                        </form>
                    </td>
                    <td class="fw-bold item-total">${{ number_format($total, 2) }}</td>
                    <td class="text-center">
                        <form class="delete-item-form" method="POST" action="{{ route('cart.destroy', ['locale' => app()->getLocale(), 'cart' => $detail->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-outline-danger btn-sm btn-delete"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr class="table-light fw-bold" id="cart-total-row">
                    <td colspan="5" class="text-end">{{ __('cart.cart_total') }}</td>
                    <td colspan="2" id="cart-total">${{ number_format($cartTotal, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-1"></i> {{ __('cart.continue_shopping') }}
        </a>
        <a href="{{ route('cart.checkout', ['locale' => app()->getLocale()]) }}" class="btn btn-success">
            <i class="fa fa-credit-card me-1"></i> {{ __('cart.proceed_checkout') }}
        </a>
    </div>
    @else
    <div class="alert alert-info text-center">
        {{ __('cart.empty') }}<br>
        <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}" class="btn btn-primary mt-3">{{ __('cart.browse_products') }}</a>
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = '{{ csrf_token() }}';

        function displayCartMessage(message, isSuccess = false) {
            const box = document.getElementById('cart-message');
            box.textContent = message;
            box.className = isSuccess ? 'alert alert-success text-center' : 'alert alert-danger text-center';
            setTimeout(() => {
                box.textContent = '';
                box.className = '';
            }, 3000);
        }

        const recalculateCartTotal = () => {
            let total = 0;
            document.querySelectorAll('.item-total').forEach(el => {
                const val = parseFloat(el.textContent.replace('$', ''));
                if (!isNaN(val)) total += val;
            });
            document.getElementById('cart-total').textContent = `$${total.toFixed(2)}`;
        };

        document.querySelectorAll('.update-quantity-form').forEach(form => {
            const input = form.querySelector('.quantity-input');
            const id = form.closest('tr').dataset.id;

            const sendQuantityUpdate = (quantity) => {
                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            _method: 'PUT',
                            quantity
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            input.value = data.quantity;
                            document.querySelector(`tr[data-id="${id}"] .item-total`).textContent = `$${parseFloat(data.item_total).toFixed(2)}`;
                            recalculateCartTotal();
                            displayCartMessage('Cart updated successfully.', true);
                        } else {
                            displayCartMessage(data.message || 'Failed to update cart.');
                        }
                    })
                    .catch(() => displayCartMessage('Error updating cart.'));
            };

            form.querySelector('.btn-increase')?.addEventListener('click', () => {
                const newQty = parseInt(input.value || 1) + 1;
                sendQuantityUpdate(newQty);
            });

            form.querySelector('.btn-decrease')?.addEventListener('click', () => {
                const currentVal = parseInt(input.value || 1);
                if (currentVal > 1) {
                    sendQuantityUpdate(currentVal - 1);
                }
            });

            input.addEventListener('input', () => {
                const newQty = parseInt(input.value || 1);
                if (!isNaN(newQty) && newQty > 0) {
                    sendQuantityUpdate(newQty);
                }
            });
        });

        document.querySelectorAll('.delete-item-form').forEach(form => {
            const id = form.closest('tr').dataset.id;
            form.querySelector('.btn-delete').addEventListener('click', () => {
                if (!confirm('{{ __("cart.remove_confirm") }}')) return;

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            _method: 'DELETE'
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector(`tr[data-id="${id}"]`).remove();
                            recalculateCartTotal();
                            if (document.querySelectorAll('tbody tr').length === 1) {
                                location.reload();
                            } else {
                                displayCartMessage('Item removed from cart.', true);
                            }
                        } else {
                            displayCartMessage(data.message || 'Failed to delete item.');
                        }
                    })
                    .catch(() => displayCartMessage('Error deleting item.'));
            });
        });
    });
</script>
@endsection