@extends('cms.layout')

@section('title', 'Assign City to ' . $distributor->name)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Assign City to {{ $distributor->name }}</h2>
        <a href="{{ route('distributor.index') }}" class="btn bubbles bubbles-grey">
            <span class="text"><i class="bi bi-arrow-left me-1"></i>Back to Distributors</span>
        </a>
    </div>

    <ul class="nav nav-tabs mb-4" id="cityTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="assign-tab" data-bs-toggle="tab" data-bs-target="#assign" type="button">Assign City</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button">Assigned Cities</button>
        </li>
    </ul>

    <div class="tab-content" id="cityTabsContent">
        {{-- Assign City Tab --}}
        <div class="tab-pane fade show active" id="assign" role="tabpanel">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('distributor.storeAddress', $distributor->id) }}">
                        @csrf
                        <div class="col-md-5">
                            <label for="cities_id" class="form-label">Select City</label>
                            <select id="cities_id" name="cities_id" class="form-select styled-select" required>
                                <option value="">-- Choose City --</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name_en }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn bubbles">
                                <span class="text">Assign City</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Assigned Cities Tab --}}
        <div class="tab-pane fade" id="list" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-center w-100 mb-5">
                        <input type="text" id="searchCity" class="form-control w-75 search-input rounded-pill shadow-soft" placeholder="Search city, district, or governorate...">
                    </div>
                    <div class="table-responsive rounded-1">
                        <table class="table mb-0 w-100" id="cityTable">
                            <thead class="bg-grey text-dark opacity-75">
                                <tr>
                                    <th>Assigned City</th>
                                    <th>District</th>
                                    <th>Governorate</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="cityList">
                                @foreach($distributor->addresses as $address)
                                <tr class="bg-hover-light-grey">
                                    <td>{{ $address->city->name_en }}</td>
                                    <td>{{ $address->city->districts->name_en ?? 'N/A' }}</td>
                                    <td>{{ $address->city->districts->governorate->name_en ?? 'N/A' }}</td>
                                    <td class="text-end">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Remove City"
                                            onclick="confirmDelete(`{{ route('distributor.removeAddress', [$distributor->id, $address->id]) }}`)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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

        $('#searchCity').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#cityList tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>
@endpush

@include('cms.partials.select2-style')
@endsection
