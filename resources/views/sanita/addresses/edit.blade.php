<div class="container-fluid mt-2 mx-1 {{ $isRtl ? 'text-end w-100' : '' }}">
    <form action="{{ route('addresses.update', ['locale' => app()->getLocale(), 'address' => $address->id]) }}" method="POST" 
        class="{{ $isRtl ? 'rtl-container' : '' }} address-form">
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
        <div id="edit_districtsInput" class="mb-3  o-transition">
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
        <div id="edit_citiesInput" class="mb-3  o-transition">
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
