@php $isRtl = (app()->getLocale() === 'ar' || app()->getLocale() === 'ku'); @endphp

<div class="container mb-4 mt-2 mx-1 {{ $isRtl ? 'text-end w-100' : '' }}">
    <form action="{{ route('addresses.store', ['locale' => app()->getLocale()]) }}" method="POST" class="{{ $isRtl ? 'rtl-container' : '' }}">
        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label for="title" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('Title (e.g. Home, Work)') }}</label>
            <div class="login-inputForm @error('title') is-invalid @enderror">
                <i class="fa fa-tag"></i>
                <input type="text" name="title" id="title" class="login-input" value="{{ old('title') }}" placeholder="{{ __('Title (e.g. Home, Work)') }}">
            </div>
            @error('title')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Governorate --}}
        <div id="governoratesInput" class="mb-3">
            <label for="governorate" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('Governorate') }}</label>
            <div class="login-inputForm @error('governorate') is-invalid @enderror {{ $isRtl ? 'text-end w-100' : '' }}">
                <i class="fa-solid fa-map"></i>
                <select name="governorate" id="governorate" class="login-input" required>
                    <option value="" disabled {{ old('governorate') ? '' : 'selected' }}>{{ __('Select Governorate') }}</option>
                    @foreach ($governorates as $gov)
                    <option value="{{ $gov->id }}" {{ old('governorate') == $gov->id ? 'selected' : '' }}>{{ $gov->name_en }}</option>
                    @endforeach
                </select>
            </div>
            @error('governorate')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- District --}}
        <div id="districtsInput" class="mb-3 d-none">
            <label for="district" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('District') }}</label>
            <div class="login-inputForm @error('district') is-invalid @enderror {{ $isRtl ? 'text-end w-100' : '' }}">
                <i class="fa-solid fa-map-marker-alt "></i>
                <select name="district" id="district" class="login-input" required>
                    <option value="" disabled selected>{{ __('Select District') }}</option>
                </select>
            </div>
            @error('district')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- City --}}
        <div id="citiesInput" class="mb-3 d-none">
            <label for="city" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('City') }}</label>
            <div class="login-inputForm @error('city') is-invalid @enderror {{ $isRtl ? 'text-end w-100' : '' }}">
                <i class="fa fa-city"></i>
                <select name="city" id="city" class="login-input" required>
                    <option value="" disabled selected>{{ __('Select City') }}</option>
                </select>
            </div>
            @error('city')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Street --}}
        <div class="mb-3">
            <label for="street" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('Street') }}</label>
            <div class="login-inputForm @error('street') is-invalid @enderror">
                <i class="fa fa-road"></i>
                <input type="text" name="street" id="street" class="login-input" value="{{ old('street') }}" placeholder="{{ __('Street') }}" required>
            </div>
            @error('street')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Building --}}
        <div class="mb-3">
            <label for="building" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('Building') }}</label>
            <div class="login-inputForm @error('building') is-invalid @enderror">
                <i class="fa fa-building"></i>
                <input type="text" name="building" id="building" class="login-input" value="{{ old('building') }}" placeholder="{{ __('Building') }}" required>
            </div>
            @error('building')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Floor --}}
        <div class="mb-3">
            <label for="floor" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('Floor') }}</label>
            <div class="login-inputForm @error('floor') is-invalid @enderror">
                <i class="fa fa-layer-group"></i>
                <input type="text" name="floor" id="floor" class="login-input" value="{{ old('floor') }}" placeholder="{{ __('Floor') }}">
            </div>
            @error('floor')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Notes --}}
        <div class="mb-3">
            <label for="notes" class="{{ $isRtl ? 'text-end w-100' : '' }}">{{ __('Notes') }}</label>
            <div class="login-inputForm @error('notes') is-invalid @enderror textarea-container">
                <i class="fa fa-sticky-note"></i>
                <textarea name="notes" id="notes" class="login-input textarea-input" placeholder="{{ __('Notes') }}">{{ old('notes') }}</textarea>
            </div>
            @error('notes')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="login-button-submit bubbles">
            <span class="text">{{ __('Save Address') }}</span>
        </button>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@include('sanita.partials.select2-style')
<style>
    .textarea-container {
        height: 5rem;
    }

    .textarea-container {
        align-items: baseline;
    }

    .textarea-input {
        width: 100%;
        resize: none;
    }

    .select2-container--default .select2-selection--single {
        border: none !important;
        width: 100% !important;
    }

    .select2-selection--single {
        display: flex !important;
        align-items: center;
        margin-left: 0.9rem !important;
    }

    .select2-selection__clear {
        display: none !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #767676;
    }

    .select2-container--default .select2-selection--single:hover,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: rgb(65, 75, 152);
    }

    .select2-container .select2-search--dropdown .select2-search__field:focus {
        box-shadow: 0 0 6px rgb(65, 75, 152);
    }

    .select2-results__option--highlighted {
        background-color: rgb(65, 75, 152) !important;
    }

    .select2-container--open {
        z-index: 9999 !important;
    }
</style>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<script>
    $(document).ready(function() {
        var $govIn = $('#governoratesInput');
        var $disIn = $('#districtsInput');
        var $citIn = $('#citiesInput');

        $('#governorate').select2({
            placeholder: "{{ __('Select Governorate') }}",
            allowClear: true,
            width: '95%',
            minimumResultsForSearch: 4,
            dropdownParent: $govIn
        });

        $('#district').select2({
            placeholder: "{{ __('Select District') }}",
            allowClear: true,
            width: '95%',
            minimumResultsForSearch: 4,
            dropdownParent: $disIn
        });

        $('#city').select2({
            placeholder: "{{ __('Select City') }}",
            allowClear: true,
            width: '95%',
            minimumResultsForSearch: 4,
            dropdownParent: $citIn

        });

        const locale = '{{ app()->getLocale() }}';
        const baseUrl = '{{ url("") }}';
        const url = `${baseUrl}/${locale}/get-cities`;
        console.log(url);


        $('#governorate').on('change', function() {
            console.log('changed')
            const governorateId = $(this).val();
            $('#district').html('<option value="">{{ __("Loading...") }}</option>');
            $('#city').html('<option value="">{{ __("Select City") }}</option>');

            $.ajax({
                url: `${baseUrl}/${locale}/get-districts`,
                data: {
                    governorates_id: governorateId
                },
                success: function(data) {
                    $('#districtsInput').removeClass('d-none');
                    $('#district').html('<option value="">{{ __("Select District") }}</option>');
                    console.log(data);
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
                url: `${baseUrl}/${locale}/get-cities`,
                data: {
                    districts_id: districtId
                },
                success: function(data) {
                    $('#citiesInput').removeClass('d-none');
                    $('#city').html('<option value="">{{ __("Select City") }}</option>');
                    data.forEach(c => {
                        $('#city').append(`<option value="${c.id}">${c.name_en}</option>`);
                    });
                }
            });
        });
    });
</script>