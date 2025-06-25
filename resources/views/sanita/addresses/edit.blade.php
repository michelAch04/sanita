@php $isRtl = (app()->getLocale() === 'ar' || app()->getLocale() === 'ku'); @endphp

<div class="container mb-4 mt-2 mx-1 {{ $isRtl ? 'text-end w-100' : '' }}">
    <form action="{{ route('addresses.update', ['locale' => app()->getLocale(), 'address' => $address->id]) }}" method="POST" class="{{ $isRtl ? 'rtl-container' : '' }}">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-3">
            <label for="edit_title" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('Title (e.g. Home, Work)') }}</label>
            <div class="login-inputForm @error('title') is-invalid @enderror">
                <i class="fa fa-tag"></i>
                <input type="text" name="title" id="edit_title" class="login-input" value="{{ old('title', $address->title) }}" placeholder="{{ __('Title (e.g. Home, Work)') }}">
            </div>
            @error('title')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Governorate --}}
        <div id="edit_governoratesInput" class="mb-3">
            <label for="edit_governorate" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('Governorate') }}</label>
            <div class="login-inputForm @error('governorate') is-invalid @enderror {{ $isRtl ? 'text-end w-100' : '' }}">
                <i class="fa-solid fa-map"></i>
                <select name="governorate" id="edit_governorate" class="login-input" required>
                    <option value="" disabled>{{ __('Select Governorate') }}</option>
                    @foreach ($governorates as $gov)
                    <option value="{{ $gov->id }}" {{ $address->governorate_id == $gov->id ? 'selected' : '' }}>{{ $gov->name_en }}</option>
                    @endforeach
                </select>
            </div>
            @error('governorate')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- District --}}
        <div id="edit_districtsInput" class="mb-3">
            <label for="edit_district" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('District') }}</label>
            <div class="login-inputForm @error('district') is-invalid @enderror {{ $isRtl ? 'text-end w-100' : '' }}">
                <i class="fa-solid fa-map-marker-alt "></i>
                <select name="district" id="edit_district" class="login-input" required>
                    <option value="" disabled>{{ __('Select District') }}</option>
                    @foreach ($districts as $district)
                    <option value="{{ $district->id }}" {{ $address->district_id == $district->id ? 'selected' : '' }}>{{ $district->name_en }}</option>
                    @endforeach
                </select>
            </div>
            @error('district')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- City --}}
        <div id="edit_citiesInput" class="mb-3">
            <label for="edit_city" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('City') }}</label>
            <div class="login-inputForm @error('city') is-invalid @enderror {{ $isRtl ? 'text-end w-100' : '' }}">
                <i class="fa fa-city"></i>
                <select name="city" id="edit_city" class="login-input" required>
                    <option value="" disabled>{{ __('Select City') }}</option>
                    @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ $address->city_id == $city->id ? 'selected' : '' }}>{{ $city->name_en }}</option>
                    @endforeach
                </select>
            </div>
            @error('city')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Street --}}
        <div class="mb-3">
            <label for="edit_street" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('Street') }}</label>
            <div class="login-inputForm @error('street') is-invalid @enderror">
                <i class="fa fa-road"></i>
                <input type="text" name="street" id="edit_street" class="login-input" value="{{ old('street', $address->street) }}" placeholder="{{ __('Street') }}" required>
            </div>
            @error('street')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Building --}}
        <div class="mb-3">
            <label for="edit_building" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('Building') }}</label>
            <div class="login-inputForm @error('building') is-invalid @enderror">
                <i class="fa fa-building"></i>
                <input type="text" name="building" id="edit_building" class="login-input" value="{{ old('building', $address->building) }}" placeholder="{{ __('Building') }}" required>
            </div>
            @error('building')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Floor --}}
        <div class="mb-3">
            <label for="edit_floor" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('Floor') }}</label>
            <div class="login-inputForm @error('floor') is-invalid @enderror">
                <i class="fa fa-layer-group"></i>
                <input type="text" name="floor" id="edit_floor" class="login-input" value="{{ old('floor', $address->floor) }}" placeholder="{{ __('Floor') }}">
            </div>
            @error('floor')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Notes --}}
        <div class="mb-3">
            <label for="edit_notes" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('Notes') }}</label>
            <div class="login-inputForm @error('notes') is-invalid @enderror textarea-container">
                <i class="fa fa-sticky-note"></i>
                <textarea name="notes" id="edit_notes" class="login-input textarea-input" placeholder="{{ __('Notes') }}">{{ old('notes', $address->notes) }}</textarea>
            </div>
            @error('notes')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="login-button-submit bubbles">
            <span class="text">{{ __('Update Address') }}</span>
        </button>
    </form>
</div>

<script>
    $(document).ready(function() {
        const locale = '{{ app()->getLocale() }}';
        const baseUrl = '{{ url('') }}';
        const $govIn = $('#edit_governoratesInput');
        const $disIn = $('#edit_districtsInput');
        const $citIn = $('#edit_citiesInput');

        $('#edit_governorate').select2({
            placeholder: "{{ __('Select Governorate') }}",
            allowClear: true,
            width: '95%',
            minimumResultsForSearch: 4,
            dropdownParent: $govIn
        });

        $('#edit_district').select2({
            placeholder: "{{ __('Select District') }}",
            allowClear: true,
            width: '95%',
            minimumResultsForSearch: 4,
            dropdownParent: $disIn
        });

        $('#edit_city').select2({
            placeholder: "{{ __('Select City') }}",
            allowClear: true,
            width: '95%',
            minimumResultsForSearch: 4,
            dropdownParent: $citIn
        });

        $('#edit_governorate').on('change', function() {
            const governorateId = $(this).val();
            $disIn.addClass('o-50');
            $('#edit_district').html('<option value="">{{ __("Loading...") }}</option>').prop('disabled', true);
            $('#edit_city').html('<option value="">{{ __("Select City") }}</option>').prop('disabled', true);

            $.ajax({
                url: `${baseUrl}/${locale}/get-districts`,
                data: {
                    governorate_id: governorateId
                },
                success: function(data) {
                    $('#edit_district').html('<option value="">{{ __("Select District") }}</option>');
                    data.forEach(d => {
                        $('#edit_district').append(`<option value="${d.id}">${d.name_en}</option>`);
                    });
                    $disIn.removeClass('o-50');
                    $('#edit_district').prop('disabled', false);
                }
            });
        });

        $('#edit_district').on('change', function() {
            const districtId = $(this).val();
            $('#edit_city').html('<option value="">{{ __("Loading...") }}</option>').prop('disabled', true);
            $citIn.addClass('o-50');

            $.ajax({
                url: `${baseUrl}/${locale}/get-cities`,
                data: {
                    district_id: districtId
                },
                success: function(data) {
                    $citIn.removeClass('o-50');
                    $('#edit_city').html('<option value="">{{ __("Select City") }}</option>');
                    data.forEach(c => {
                        $('#edit_city').append(`<option value="${c.id}">${c.name_en}</option>`);
                    });
                    $citIn.removeClass('o-50');
                    $('#edit_city').prop('disabled', false);
                }
            });
        });
    });
</script>