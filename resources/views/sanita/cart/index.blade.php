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
                    <th>image </th>
                    <th scope="col">{{ __('cart.product') }}</th>
                    <th>{{ __('cart.description') }}</th>
                    <th>{{ __('cart.shelf_price') }}</th>
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
                    <td>
                        <img 
  class="fw-semibold text-primary" 
  style="width: 150px; height: auto;" 
  src="{{ asset('storage/products/'.$detail->product->id.'.'.$detail->product->extension) }}" 
  alt="Product Image">
                    </td>
                    <td class="fw-semibold text-primary">
                         {{ $detail->product->{'name_'.app()->getLocale()} ?? $product->name_en }}
                    </td>
                    <td class="text-muted">
                         {{ $detail->product->{'small_description_'.app()->getLocale()} ?? $product->name_en }}
                    </td>           
                    <td>${{ number_format($detail->unit_price, 2) }}</td>
                    <td>
                        {{-- Update quantity form --}}
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
                        {{-- Delete form --}}
                        <form class="delete-item-form" method="POST" action="{{ route('cart.destroy', ['locale' => app()->getLocale(), 'cart' => $detail->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-outline-danger btn-sm btn-delete" title="{{ __('cart.remove') }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr class="table-light fw-bold" id="cart-total-row">
                    <td colspan="4" class="text-end">{{ __('cart.cart_total') }}</td>
                    <td colspan="2" id="cart-total">${{ number_format($cartTotal, 2) }}</td>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';

    // Debounce helper
    const debounce = (func, delay = 300) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func(...args), delay);
        };
    };

    // Recalculate cart total
    const recalculateCartTotal = () => {
        let total = 0;
        document.querySelectorAll('.item-total').forEach(el => {
            const val = parseFloat(el.textContent.replace('$', ''));
            if (!isNaN(val)) total += val;
        });
        document.getElementById('cart-total').textContent = `$${total.toFixed(2)}`;
    };

    // Quantity update
    document.querySelectorAll('.update-quantity-form').forEach(form => {
        const input = form.querySelector('.quantity-input');
        const id = form.closest('tr').dataset.id;

        const updateQuantity = debounce(() => {
            const quantity = parseInt(input.value) || 1;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    _method: 'PUT',
                    quantity: quantity
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    input.value = data.quantity;
                    document.querySelector(`tr[data-id="${id}"] .item-total`).textContent = `$${parseFloat(data.item_total).toFixed(2)}`;
                    recalculateCartTotal();
                } else {
                    alert(data.error || 'Failed to update cart.');
                }
            })
            .catch(() => alert('Error updating cart.'));
        }, 300);

        input.addEventListener('input', updateQuantity);

        form.querySelector('.btn-increase')?.addEventListener('click', () => {
            input.value = parseInt(input.value || 1) + 1;
            input.dispatchEvent(new Event('input'));
        });

        form.querySelector('.btn-decrease')?.addEventListener('click', () => {
            let val = parseInt(input.value || 1);
            if (val > 1) {
                input.value = val - 1;
                input.dispatchEvent(new Event('input'));
            }
        });
    });

    // Delete cart item
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
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    row.remove();
                    recalculateCartTotal();

                    if (document.querySelectorAll('tbody tr').length === 1) {
                        location.reload(); // Only total row left, reload to show empty message
                    }
                } else {
                    alert(data.message || 'Failed to delete item.');
                }
            })
            .catch(() => alert('Error deleting item.'));
        });
    });
});
</script>
@endsection
