@extends('sanita.layout')

@section('title', __('Edit Address'))

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">{{ __('Edit Address') }}</h2>

    <form action="{{ route('addresses.update', ['locale' => app()->getLocale(), 'address' => $address->id]) }}" method="POST" id="address-form">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">{{ __('Title (e.g. Home, Work)') }}</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $address->title) }}">
        </div>

        <div class="mb-3">
            <label for="governorate" class="form-label">{{ __('Governorate') }}</label>
            <select name="governorate" id="governorate" class="form-select" required>
                <option value="" disabled>{{ __('Select Governorate') }}</option>
                @foreach ($governorates as $gov)
                <option value="{{ $gov->id }}" {{ $address->governorate_id == $gov->id ? 'selected' : '' }}>{{ $gov->name_en }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="district" class="form-label">{{ __('District') }}</label>
            <select name="district" id="district" class="form-select" required>
                <option value="" disabled>{{ __('Select District') }}</option>
                @foreach ($districts as $district)
                <option value="{{ $district->id }}" {{ $address->district_id == $district->id ? 'selected' : '' }}>{{ $district->name_en }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">{{ __('City') }}</label>
            <select name="city" id="city" class="form-select" required>
                <option value="" disabled>{{ __('Select City') }}</option>
                @foreach ($cities as $city)
                <option value="{{ $city->id }}" {{ $address->city_id == $city->id ? 'selected' : '' }}>{{ $city->name_en }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="street" class="form-label">{{ __('Street') }}</label>
            <input type="text" name="street" id="street" class="form-control" value="{{ old('street', $address->street) }}" required>
        </div>

        <div class="mb-3">
            <label for="building" class="form-label">{{ __('Building') }}</label>
            <input type="text" name="building" id="building" class="form-control" value="{{ old('building', $address->building) }}" required>
        </div>

        <div class="mb-3">
            <label for="floor" class="form-label">{{ __('Floor') }}</label>
            <input type="text" name="floor" id="floor" class="form-control" value="{{ old('floor', $address->floor) }}">
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">{{ __('Notes') }}</label>
            <textarea name="notes" id="notes" class="form-control">{{ old('notes', $address->notes) }}</textarea>
        </div>

        <div class="mb-3 form-check">
            <input type="hidden" name="is_default" value="0">

            <input type="checkbox" name="is_default" id="is_default" value="1"
                class="form-check-input"
                {{ old('is_default', $address->is_default) == 1 ? 'checked' : '' }}>

            <label for="is_default" class="form-check-label">{{ __('Set as default address') }}</label>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">{{ __('Update Address') }}</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const locale = '{{ app()->getLocale() }}';

    $('#governorate').on('change', function() {
        const governorateId = $(this).val();
        $('#district').html('<option value="">{{ __("Loading...") }}</option>');
        $('#city').html('<option value="">{{ __("Select City") }}</option>');

        $.ajax({
            url: '/' + locale + '/get-districts',
            data: {
                governorate_id: governorateId
            },
            success: function(data) {
                $('#district').html('<option value="">{{ __("Select District") }}</option>');
                data.forEach(d => {
                    $('#district').append(`<option value="${d.id}">${d.name_en}</option>`);
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
                data.forEach(c => {
                    $('#city').append(`<option value="${c.id}">${c.name_en}</option>`);
                });
            }
        });
    });
</script>
@endpush

@endsection