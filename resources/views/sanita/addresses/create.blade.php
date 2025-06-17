@extends('sanita.layout')

@section('title', __('Add Address'))

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">{{ __('Add New Address') }}</h2>

    <form action="{{ route('addresses.store', ['locale' => app()->getLocale()]) }}" method="POST" id="address-form">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">{{ __('Title (e.g. Home, Work)') }}</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="governorate" class="form-label">{{ __('Governorate') }}</label>
            <select name="governorate" id="governorate" class="form-select" required>
                <option value="" disabled {{ old('governorate') ? '' : 'selected' }}>{{ __('Select Governorate') }}</option>
                @foreach ($governorates as $gov)
                <option value="{{ $gov->id }}" {{ old('governorate') == $gov->id ? 'selected' : '' }}>{{ $gov->name_en }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="district" class="form-label">{{ __('District') }}</label>
            <select name="district" id="district" class="form-select" required>
                <option value="" disabled {{ old('district') ? '' : 'selected' }}>{{ __('Select District') }}</option>
                @foreach ($districts as $district)
                <option value="{{ $district->id }}" {{ old('district') == $district->id ? 'selected' : '' }}>{{ $district->name_en }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">{{ __('City') }}</label>
            <select name="city" id="city" class="form-select" required>
                <option value="" disabled {{ old('city') ? '' : 'selected' }}>{{ __('Select City') }}</option>
                @foreach ($cities as $city)
                <option value="{{ $city->id }}" {{ old('city') == $city->id ? 'selected' : '' }}>{{ $city->name_en }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="street" class="form-label">{{ __('Street') }}</label>
            <input type="text" name="street" id="street" class="form-control" value="{{ old('street') }}" required>
        </div>

        <div class="mb-3">
            <label for="building" class="form-label">{{ __('Building') }}</label>
            <input type="text" name="building" id="building" class="form-control" value="{{ old('building') }}" required>
        </div>

        <div class="mb-3">
            <label for="floor" class="form-label">{{ __('Floor') }}</label>
            <input type="text" name="floor" id="floor" class="form-control" value="{{ old('floor') }}">
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">{{ __('Notes') }}</label>
            <textarea name="notes" id="notes" class="form-control">{{ old('notes') }}</textarea>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_default" id="is_default" value="1" class="form-check-input" {{ old('is_default') ? 'checked' : '' }}>
            <label for="is_default" class="form-check-label">{{ __('Set as default address') }}</label>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">{{ __('Save Address') }}</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const locale = '{{ app()->getLocale() }}';

    $('#governorate').on('change', function() {
        const governorateId = $(this).val();
        $('#district').html('<option value="">{{ __("Loading...") }}</option>');

        $.ajax({
            url: '/' + locale + '/get-districts',
            data: {
                governorate_id: governorateId
            },
            success: function(data) {
                $('#district').html('<option value="">{{ __("Select District") }}</option>');
                data.forEach(function(district) {
                    $('#district').append(`<option value="${district.id}">${district.name_en}</option>`);
                });
            }
        });
    });

    $('#district').on('change', function() {
        const districtId = $(this).val();
        $('#city').html('<option value="">{{ __("Loading...") }}</option>');

        $.ajax({
            url: '/' + locale + '/get-cities',
            data: {
                district_id: districtId
            },
            success: function(data) {
                $('#city').html('<option value="">{{ __("Select City") }}</option>');
                data.forEach(function(city) {
                    $('#city').append(`<option value="${city.id}">${city.name_en}</option>`);
                });
            }
        });
    });
</script>

@endpush

@endsection