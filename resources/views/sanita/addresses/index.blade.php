@extends('sanita.layout')

@section('title', __('Your Addresses'))
@php
$sortedAddresses = $addresses->sortByDesc('is_default');
@endphp
@section('content')
<section id="addresses" class="pt-5 bg-light">
    <div class="container px-5 mb-5">
        <h2 class="display-5 text-center mb-5">📍 {{ __('Your Addresses') }}</h2>
        @if($sortedAddresses->count() != 0)
        <div class="d-flex justify-content-center mb-4">
            <button data-bs-toggle="modal" data-bs-target="#addAddressModal" class="btn bubbles bubbles-arctic px-4 py-2" style="border-radius: 2rem;">
                <span class="text"><i class="fa fa-plus me-2"></i>{{ __('Add Address') }}</span>
            </button>
        </div>
        @endif



        @if ($sortedAddresses->count() > 0)
        <div class="d-flex flex-column gap-2">
            @foreach ($sortedAddresses as $address)
            <div class="cart-item d-flex flex-row justify-content-between p-3 bg-white rounded shadow-sm flex-wrap w-100">
                {{-- Address Info --}}
                <div class="d-flex flex-column flex-grow-1 me-3">

                    <div class="d-flex align-items-center gap-2 mb-2">
                        <h5 class="mb-1">{{ $address->title ?? __('Untitled') }}</h5>
                        @if ($address->is_default)
                        <span class="badge bg-success text-white px-2 py-1 rounded-pill">{{ __('Default') }}</span>
                        @endif
                    </div>

                    <p class="text-muted mb-1">
                        <i class="fa fa-map-marker-alt me-1"></i> {{ $address->governorate->name_en }}
                    </p>
                    <p class="text-muted mb-1">
                        <i class="fa fa-city me-1"></i> {{ $address->city->name_en }}, {{ $address->district->name_en }}
                    </p>
                    <p class="text-muted mb-1">
                        <i class="fa fa-home me-1"></i> Street {{ $address->street }}, Building {{ $address->building }}
                    </p>
                    @if ($address->notes)
                    <p class="text-muted small mb-0">
                        <i class="fa fa-sticky-note me-1"></i> {{ $address->notes }}
                    </p>
                    @endif

                    {{-- Set as default --}}
                    @if (!$address->is_default)
                    <form action="{{ route('addresses.setDefault', [app()->getLocale(), $address]) }}" method="POST" class="mt-3">
                        @csrf
                        <button class="btn btn-sm bubbles success-btn px-3">
                            <span class="text">
                                <i class="fa fa-check-circle me-1"></i> {{ __('Set as Default') }}
                            </span>
                        </button>
                    </form>
                    @endif
                </div>

                {{-- Action Buttons Column --}}
                <div class="d-flex flex-column justify-content-between align-items-end">
                    {{-- Edit button --}}
                    <button data-bs-toggle="modal" data-bs-target="#editAddressModal-{{ $address->id }}" class="btn btn-sm bubbles modify-btn edit-btn mb-3">
                        <span class="text"><i class="fa fa-edit me-1"></i> {{ __('Edit') }}</span>
                    </button>

                    {{-- Delete triggers modal --}}
                    <button class="btn btn-sm bubbles modify-btn delete-btn"
                        onclick="confirmDelete('{{ route('addresses.destroy', [app()->getLocale(), $address]) }}')">
                        <span class="text"><i class="fa fa-trash me-1"></i> {{ __('Delete') }}</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-cart-alert text-center py-5 px-4 my-5 rounded-4 shadow-sm" style="background: #f9f9f9; border: 2px dashed var(--primary-blue); max-width: 500px; margin: 0 auto;">
            <div style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 0.5rem;">
                📭
            </div>
            <div class="fs-4 fw-semibold mb-2" style="color: var(--primary-blue);">
                {{ __('No addresses found.') }}
            </div>
            <div class="d-flex justify-content-center mb-4">
                <button data-bs-toggle="modal" data-bs-target="#addAddressModal" class="btn bubbles bubbles-arctic px-4 py-2" style="border-radius: 2rem;">
                    <span class="text"><i class="fa fa-plus me-2"></i>{{ __('Add Address') }}</span>
                </button>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg d-flex justify-content-center">
        <div class="modal-content p-3 pb-2" style="width: 75%;">
            <div class="modal-header" style="border: none !important;">
                <h2 class="display-5 login-title text-center mb-0" style="font-size: 2.5rem;">{{ __('Add New Address') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                @include('sanita.addresses.create') {{-- We'll extract the form here --}}
            </div>
        </div>
    </div>
</div>

@foreach ($sortedAddresses as $address)
<!-- Edit Address Modal -->
<div class="modal fade" id="editAddressModal-{{ $address->id }}" tabindex="-1" aria-labelledby="editAddressLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg d-flex justify-content-center">
        <div class="modal-content p-3 pb-2" style="width: 75%;">
            <div class="modal-header" style="border: none !important;">
                <h2 class="display-5 login-title text-center mb-0" style="font-size: 2.5rem;">{{ __('Edit Address') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                @include('sanita.addresses.edit') {{-- We'll extract the form here --}}
            </div>
        </div>
    </div>
</div>
@endforeach


<link rel="stylesheet" href="{{ asset('css/cart.css') }}" />
<style>
    .modify-btn {
        width: 5.5rem;
        padding: 0.25rem 0.25rem !important;
        border-width: 0.12rem;
    }

    .modify-btn>.text {
        font-weight: 500 !important;
    }

    .edit-btn {
        --c2: rgb(54, 116, 222);
    }

    .delete-btn {
        --c2: rgb(196, 49, 49);
    }

    p i {
        width: 1.2rem;
        text-align: center;
    }

    .success-btn {
        --c2: green;
        padding: 0.25rem 0.5rem !important;
        border-width: 0.08rem;
        font-size: 0.9rem;
    }

    .success-btn>.text {
        font-weight: 400;
    }
</style>

<script>
    function confirmDelete(action) {
        const form = document.getElementById('deleteForm');
        form.action = action;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endsection