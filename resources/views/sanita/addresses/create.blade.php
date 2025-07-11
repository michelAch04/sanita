<div class="container mt-2 mx-1 {{ $isRtl ? 'text-end w-100' : '' }}">
    <form action="{{ route('addresses.store', ['locale' => app()->getLocale()]) }}" method="POST"
        class="{{ $isRtl ? 'rtl-container' : '' }} address-form">
        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label for="title" class="{{ $isRtl ? 'text-end w-100' : '' }} text-primary">{{ __('address.title') }}</label>
            <div class="login-inputForm @error('title') is-invalid @enderror">
                <i class="fa fa-tag"></i>
                <input type="text" name="title" id="title" class="login-input" value="{{ old('title') }}" placeholder="{{ __('address.title') }}">
            </div>
            @error('title')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Governorate --}}
        <div id="governoratesInput" class="mb-3">
            <label for="governorate" class="{{ $isRtl ? 'text-end w-100' : '' }} text-primary">{{ __('address.Governorate') }}</label>
            <div class="login-inputForm @error('governorate') is-invalid @enderror {{ $isRtl ? 'text-end w-100' : '' }} " dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
                <i class="fa-solid fa-map"></i>
                <select name="governorate" id="governorate" class="login-input" required>
                    <option value="" disabled {{ old('governorate') ? '' : 'selected' }}>{{ __('address.Select_Governorate') }}</option>
                    @foreach ($governorates as $gov)
                    <option value="{{ $gov->id }}" {{ old('governorate') == $gov->id ? 'selected' : '' }}>{{ $gov->{'name_' . app()->getLocale()} ?? $gov->name_en }}</option>
                    @endforeach
                </select>
            </div>
            @error('governorate')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- District --}}
        <div id="districtsInput" class="mb-3 o-50 o-transition">
            <label for="district" class="{{ $isRtl ? 'text-end w-100' : '' }} text-primary">{{ __('address.District') }}</label>
            <div class="login-inputForm @error('district') is-invalid @enderror {{ $isRtl ? 'text-end w-100' : '' }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
                <i class="fa-solid fa-map-marker-alt "></i>
                <select name="district" id="district" class="login-input" required>
                    <option value="" disabled selected>{{ __('address.Select_District') }}</option>
                </select>
            </div>
            @error('district')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- City --}}
        <div id="citiesInput" class="mb-3 o-50 o-transition">
            <label for="city" class="{{ $isRtl ? 'text-end w-100' : '' }} text-primary">{{ __('address.City') }}</label>
            <div class="login-inputForm @error('city') is-invalid @enderror {{ $isRtl ? 'text-end w-100' : '' }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
                <i class="fa fa-city"></i>
                <select name="city" id="city" class="login-input" required>
                    <option value="" disabled selected>{{ __('address.Select_City') }}</option>
                </select>
            </div>
            @error('city')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Street --}}
        <div class="mb-3">
            <label for="street" class="{{ $isRtl ? 'text-end w-100' : '' }} text-primary">{{ __('address.Street') }}</label>
            <div class="login-inputForm @error('street') is-invalid @enderror">
                <i class="fa fa-road"></i>
                <input type="text" name="street" id="street" class="login-input" value="{{ old('street') }}" placeholder="{{ __('address.Street') }}" required>
            </div>
            @error('street')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Building --}}
        <div class="mb-3">
            <label for="building" class="{{ $isRtl ? 'text-end w-100' : '' }} text-primary">{{ __('address.Building') }}</label>
            <div class="login-inputForm @error('building') is-invalid @enderror">
                <i class="fa fa-building"></i>
                <input type="text" name="building" id="building" class="login-input" value="{{ old('building') }}" placeholder="{{ __('address.Building') }}" required>
            </div>
            @error('building')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Floor --}}
        <div class="mb-3">
            <label for="floor" class="{{ $isRtl ? 'text-end w-100' : '' }} text-primary">{{ __('address.Floor') }}</label>
            <div class="login-inputForm @error('floor') is-invalid @enderror">
                <i class="fa fa-layer-group"></i>
                <input type="text" name="floor" id="floor" class="login-input" value="{{ old('floor') }}" placeholder="{{ __('address.Floor') }}">
            </div>
            @error('floor')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Notes --}}
        <div class="mb-3">
            <label for="notes" class="{{ $isRtl ? 'text-end w-100' : '' }} text-primary">{{ __('address.Notes') }}</label>
            <div class="login-inputForm @error('notes') is-invalid @enderror textarea-container">
                <i class="fa fa-sticky-note"></i>
                <textarea name="notes" id="notes" class="login-input textarea-input" placeholder="{{ __('address.Notes') }}">{{ old('notes') }}</textarea>
            </div>
            @error('notes')
            <div class="login-error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="login-button-submit bubbles">
            <span class="text">{{ __('address.Save_Address') }}</span>
        </button>
    </form>
</div>

@include('sanita.partials.select2',[
'id' => '#governorate',
'placeholder' => "{{ __('cart.select_address') }}"
])
<link rel="stylesheet" href="{{ asset('css/address.css') }}" />
<script src="{{ asset('js/address.js') }}"></script>