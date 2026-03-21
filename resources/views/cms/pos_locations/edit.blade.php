@extends('cms.layout')

@section('title', 'Edit POS Location')

@section('content')
<div class="ps-5 mt-3">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Edit POS Location</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('pos_locations.update', $pos->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="name" name="name" value="{{ old('name', $pos->name) }}" required style="width: 100%;">
                    <label for="name" class="label">POS Name</label>
                    <div class="underline"></div>
                </div>

                {{-- Address --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="address" name="address" value="{{ old('address', $pos->address) }}" required style="width: 100%;">
                    <label for="address" class="label">Address</label>
                    <div class="underline"></div>
                </div>

                {{-- City Select --}}
                <div class="input-container mb-5 mt-3" style="width: 30%; position: relative; padding-top: 5px;">
                    <label for="cities_id" class="label select2-label">City <small class="text-muted">(optional)</small></label>
                    <select id="cities_id" name="cities_id" class="styled-select">
                        <option value="">Select a City</option>
                        @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ old('cities_id', $pos->cities_id) == $city->id ? 'selected' : '' }}>
                            {{ $city->name_en }}
                        </option>
                        @endforeach
                    </select>
                    <div class="underline"></div>
                </div>

                {{-- Latitude --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="number" step="0.000001" id="latitude" name="latitude" value="{{ old('latitude', $pos->latitude) }}" style="width: 100%;">
                    <label for="latitude" class="label">Latitude <small class="text-muted">(optional)</small></label>
                    <div class="underline"></div>
                </div>

                {{-- Longitude --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="number" step="0.000001" id="longitude" name="longitude" value="{{ old('longitude', $pos->longitude) }}" style="width: 100%;">
                    <label for="longitude" class="label">Longitude <small class="text-muted">(optional)</small></label>
                    <div class="underline"></div>
                </div>

                {{-- Submit & Cancel --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('pos_locations.index') }}" class="btn bubbles bubbles-grey me-2">
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

@include('cms.partials.select2', [
    'id' => '#cities_id',
    'placeholder' => 'Select a City',
])
@endsection
