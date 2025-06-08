@extends('cms.layout')

@section('title', 'Add Order')

@section('content')
<div class="container mt-3">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Add Order</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                {{-- Customer Select2 --}}
                <div class="input-container mb-5 mt-3" style="width: 30%; position: relative; padding-top: 5px;">
                    <label for="customers_id" class="label select2-label">Customer</label>
                    <select id="customers_id" name="customers_id" class="styled-select" required>
                        <option value="">Select a customer</option>
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->first_name }} {{ $customer->last_name }}
                        </option>
                        @endforeach
                    </select>
                    <div class="underline"></div>
                </div>

                {{-- Cart Select2 --}}
                <div class="input-container mb-5 mt-3" style="width: 30%; position: relative; padding-top: 5px;">
                    <label for="carts_id" class="label select2-label">Cart</label>
                    <select id="carts_id" name="carts_id" class="styled-select" required>
                        <option value="">Select a cart</option>
                        @foreach ($carts as $cart)
                        <option value="{{ $cart->id }}">
                            Cart #{{ $cart->id }} - {{ $cart->created_at->format('Y-m-d') }}
                        </option>
                        @endforeach
                    </select>
                    <div class="underline"></div>
                </div>

                {{-- Status Radio Buttons --}}
                <div class="select-container mb-5 mt-3" style="width: 30%; position: relative;">
                    <label for="status" class="label">Status</label>
                    <div class="mt-2">
                        <label class="select-label"><input type="radio" name="status" value="pending"> <span>Pending</span></label>
                        <label class="select-label"><input type="radio" name="status" value="completed"> <span>Completed</span></label>
                        <label class="select-label"><input type="radio" name="status" value="cancelled"> <span>Cancelled</span></label>
                    </div>
                </div>

                {{-- Total Price --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="number" id="total_amount" name="total_amount"
                        step="0.01" required placeholder="" style="width: 100%;">
                    <label for="total_amount" class="label">Total Price</label>
                    <div class="underline"></div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('orders.index') }}" class="btn bubbles bubbles-grey me-2">
                        <span class="text">Cancel</span>
                    </a>
                    <button type="submit" class="btn bubbles">
                        <span class="text">Create</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#customers_id').select2({
            placeholder: 'Select a customer',
            allowClear: true,
            width: '100%'
        });
    });
    $(document).ready(function() {
        $('#carts_id').select2({
            placeholder: 'Select a customer',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush

@include('cms.partials.select2-style')
@endsection