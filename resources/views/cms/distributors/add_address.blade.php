@extends('cms.layout')

@section('title', 'Assign City to Distributor')

@section('content')
<div class="container py-4" style="max-width: 700px;">
    {{-- Page Title --}}
    <div class="mb-4 text-center">
        <h2>Edit Cities of: {{ $distributor->name }}</h2>
    </div>

    <div class="d-md-flex flex-row align-items-center justify-content-center gap-2 ms-5">
        {{-- Assign City Form Card --}}
        <div class="card shadow-sm border-0 col-md-11">
            <div class="card-body">
                <h4 class="mb-5">Assign a City</h4>
                <form method="POST" action="{{ route('distributor.storeAddress', $distributor->id) }}">
                    @csrf
                    <div class="input-container mb-4" style="width: 50%; position: relative; padding-top: 5px;">
                        <label for="cities_id" class="label select2-label">Select City</label>
                        <select id="cities_id" name="cities_id" class="styled-select" required>
                            <option value="">-- Choose City --</option>
                            @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name_en }}</option>
                            @endforeach
                        </select>
                        <div class="underline"></div>
                        @error('cities_id')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('distributor.index') }}" class="btn bubbles bubbles-grey me-2">
                            <span class="text">Back</span>
                        </a>
                        <button type="submit" class="btn bubbles">
                            <span class="text">Assign City</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Assigned Cities List Card --}}
        <div class="card shadow-sm border-0 col-md-11">
            <div class="card-body">
                <h4 class="mb-5">Assigned Cities</h4>
                <ul class="list-group">
                    @foreach($distributor->addresses as $address)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $address->city->name_en }}
                        <button
                            type="button"
                            class="btn btn-sm btn-outline-danger"
                            title="Remove City"
                            onclick="confirmDelete(`{{ route('distributor.removeAddress', [$distributor->id, $address->id]) }}`)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </li>
                    @endforeach
                </ul>
            </div>
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
        $('#cities_id').select2({
            placeholder: 'Select a city',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush

@include('cms.partials.select2-style')
@endsection