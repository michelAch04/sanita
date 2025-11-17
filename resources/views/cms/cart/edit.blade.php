@extends('cms.layout')

@section('title', 'Edit Cart')

@section('content')
<div class="container mt-3">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Edit Cart</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Customer Select --}}
                <div class="input-container mb-5 mt-3" style="width: 30%; position: relative; padding-top: 5px;">
                    <label for="customer_id" class="label select2-label">Customer</label>
                    <select id="customer_id" name="customer_id" class="styled-select" required>
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id', $cart->customer_id) == $customer->id ? 'selected' : '' }}>
                            {{ $customer->first_name }} {{ $customer->last_name }} (ID: {{ $customer->id }})
                        </option>
                        @endforeach
                    </select>
                    <div class="underline"></div>
                </div>

                {{-- Delivery Charge --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="number" step="0.01" id="delivery_charge" name="delivery_charge"
                        value="{{ old('delivery_charge', $cart->delivery_charge) }}" required>
                    <label for="delivery_charge" class="label">Delivery Charge</label>
                    <div class="underline"></div>
                </div>

                {{-- Promocode --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="promocode" name="promocode"
                        value="{{ old('promocode', $cart->promocode) }}">
                    <label for="promocode" class="label">Promocode</label>
                    <div class="underline"></div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('cart.cmsindex') }}" class="btn bubbles bubbles-grey me-2">
                        <span class="text">Cancel</span>
                    </a>
                    <button type="submit" class="btn bubbles">
                        <span class="text">Update</span>
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
        $('#customer_id').select2({
            placeholder: 'Select a customer',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush

@include('cms.partials.select2-style')
@endsection
