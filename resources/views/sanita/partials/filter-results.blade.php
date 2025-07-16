@php
$minPrice = floor($eaPrices->min());
$maxPrice = ceil($eaPrices->max());
$panelAttribute = $panel == true ? 'panel-' : 'sidebar-';
$panelContainer = $panel == true ? '#filterPanel' : '#filterSidebar';
@endphp

{{-- === BRAND FILTER === --}}
<div class="filter-group mb-2">
    <div class="d-flex justify-content-between align-items-center toggle-header mb-1">
        <h6 class="mb-0">{{ __('nav.brands') }}</h6>
        <button type="button" class="toggle-btn" data-target="#{{ $panelAttribute }}brand-filter">+</button>
    </div>
    <div id="{{ $panelAttribute }}brand-filter" class="toggle-content">
        @foreach($brands as $brand)
        @php $checkedBrands = (array) request()->input('brand', []); @endphp
        <div class="form-check d-flex align-items-center mb-1 ps-0 ps-lg-2">
            <label class="ios-checkbox arctic me-1">
                <input type="checkbox"
                    name="brand[]"
                    value="{{ $brand->id }}"
                    class="form-check-input auto-submit"
                    {{ in_array($brand->id, $checkedBrands) ? 'checked' : '' }}>
                <div class="checkbox-wrapper">
                    <div class="checkbox-bg"></div>
                    <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="3"
                            stroke="currentColor" d="M4 12L10 18L20 6"></path>
                    </svg>
                </div>
            </label>
            <label class="form-check-label">
                {{ $brand->name_en }}
            </label>
        </div>
        @endforeach
    </div>
</div>

{{-- === CATEGORY FILTER === --}}
<div class="filter-group mb-2">
    <div class="d-flex justify-content-between align-items-center toggle-header mb-1">
        <h6 class="mb-0">{{ __('nav.categories') }}</h6>
        <button type="button" class="toggle-btn" data-target="#{{ $panelAttribute }}category-filter">+</button>
    </div>
    <div id="{{ $panelAttribute }}category-filter" class="toggle-content">
        @foreach($categories as $category)
        @php $checkedCategories = (array) request()->input('category', []); @endphp
        <div class="form-check d-flex align-items-center mb-1 ps-0 ps-lg-2">
            <label class="ios-checkbox arctic me-1">
                <input type="checkbox"
                    name="category[]"
                    value="{{ $category->id }}"
                    class="form-check-input auto-submit"
                    {{ in_array($category->id, $checkedCategories) ? 'checked' : '' }}>
                <div class="checkbox-wrapper">
                    <div class="checkbox-bg"></div>
                    <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="3"
                            stroke="currentColor" d="M4 12L10 18L20 6"></path>
                    </svg>
                </div>
            </label>
            <label class="form-check-label">
                {{ $category->name_en }}
            </label>
        </div>
        @endforeach
    </div>
</div>

{{-- === PRICE FILTER === --}}
<div class="filter-group mb-2">
    <div class="d-flex justify-content-between align-items-center toggle-header mb-0">
        <h6 class="mb-0">{{ __('cart.price') }}</h6>
        <button type="button" class="toggle-btn" data-target="#{{ $panelAttribute }}price-filter">+</button>
    </div>
    <div id="{{ $panelAttribute }}price-filter" class="toggle-content">
        <div class="d-flex flex-column align-items-center">
            <div class="position-relative range-wrapper w-100 mb-lg-0 mb-1 d-flex">
                <div class="slider-track-bg"></div>
                <div class="slider-range-fill" id="{{ $panelAttribute }}sliderRangeFill"></div>

                <input type="range" id="{{ $panelAttribute }}range-min" name="min_price"
                    min="{{ $minPrice }}" max="{{ $maxPrice }}"
                    value="{{ request('min_price', $minPrice) }}"
                    class="range-slider" step="1">
                <input type="range" id="{{ $panelAttribute }}range-max" name="max_price"
                    min="{{ $minPrice }}" max="{{ $maxPrice }}"
                    value="{{ request('max_price', $maxPrice) }}"
                    class="range-slider" step="1">
            </div>

            <div class="d-flex flex-xl-row flex-column p-0 gap-2">
                <div class="d-flex justify-content-between align-items-center w-100 p-0 price-range-input">
                    <div class="engraved-label-input pe-1">
                        <label for="range-min" class="text">{{ __('nav.minimum') }} {{ __('cart.price') }}:</label>
                        <input type="number" id="{{ $panelAttribute }}min_price" class="input px-1 py-2"
                            value="{{ request('min_price', $minPrice) }}"
                            step="1">
                    </div>
                    <div class="engraved-label-input">
                        <label for="range-max" class="text">{{ __('nav.maximum') }} {{ __('cart.price') }}:</label>
                        <input type="number" id="{{ $panelAttribute }}max_price" class="input px-1 py-2"
                            value="{{ request('max_price', $maxPrice) }}"
                            step="1">
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-xl-4 px-2 py-lg-0 py-1">
                    {{ __('cart.apply') }}
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const panelAttribute = "{{ $panelAttribute }}";
        const panelContainer = "{{ $panelContainer }}";
        const form = document.getElementById(`${panelAttribute}filterForm`);

        // === Auto-submit on input change ===
        form.querySelectorAll('.auto-submit').forEach(input => {
            input.addEventListener('change', () => {
                const formdata = new FormData(form);
                const params = new URLSearchParams();

                for (const [key, value] of formdata.entries()) {
                    params.append(key, value);
                }

                window.location.href = `${form.action}?${params.toString()}`;
            });
        });

        // === Expand only sections that have active query values ===
        const urlParams = new URLSearchParams(window.location.search);
        const activeFields = ['brand', 'category', 'price'];

        activeFields.forEach(field => {
            if (urlParams.has(field) || urlParams.getAll(`${field}[]`).length > 0) {
                const targetId = `#${panelAttribute}${field.replace('_', '-')}-filter`;
                const content = document.querySelector(targetId);
                const toggleBtn = document.querySelector(`.toggle-btn[data-target="${targetId}"]`);

                if (content && toggleBtn) {
                    content.classList.add('expanded');
                    content.style.maxHeight = content.scrollHeight + 'px';
                    toggleBtn.textContent = '−';
                }
            }
        });

        // === Expand price section on DOMContentLoaded
        const priceContent = document.querySelector(`#${panelAttribute}price-filter`);
        const priceToggleBtn = document.querySelector(`.toggle-btn[data-target="#${panelAttribute}price-filter"]`);

        if (priceContent && priceToggleBtn) {
                priceContent.classList.add('expanded');
                priceContent.style.maxHeight = priceContent.scrollHeight + 'px';
                priceToggleBtn.textContent = '−';
        }

        // === Toggle on click
        document.querySelectorAll(`${panelContainer} .toggle-btn`).forEach(button => {
            const target = document.querySelector(button.dataset.target);

            button.addEventListener('click', () => {
                const isExpanded = target.classList.contains('expanded');

                if (isExpanded) {
                    target.style.maxHeight = '0';
                    target.classList.remove('expanded');
                    button.textContent = '+';
                } else {
                    target.classList.add('expanded');
                    target.style.maxHeight = target.scrollHeight + 'px';
                    button.textContent = '−';
                }
            });
        });

        //=== MIN MAX INPUT HANDLING 
        const rangeMin = document.getElementById(`${panelAttribute}range-min`);
        const rangeMax = document.getElementById(`${panelAttribute}range-max`);
        const minInput = document.getElementById(`${panelAttribute}min_price`);
        const maxInput = document.getElementById(`${panelAttribute}max_price`);
        const fill = document.getElementById(`${panelAttribute}sliderRangeFill`);

        const sliderMin = parseInt(rangeMin.min);
        const sliderMax = parseInt(rangeMin.max);

        function updateSliderFill() {
            let minVal = parseInt(rangeMin.value);
            let maxVal = parseInt(rangeMax.value);

            if (minVal > maxVal)[minVal, maxVal] = [maxVal, minVal];

            const percentMin = ((minVal - sliderMin) / (sliderMax - sliderMin)) * 100;
            const percentMax = ((maxVal - sliderMin) / (sliderMax - sliderMin)) * 100;

            fill.style.left = percentMin + "%";
            fill.style.width = (percentMax - percentMin) + "%";
        }

        function syncFromSlider() {
            let minVal = parseInt(rangeMin.value);
            let maxVal = parseInt(rangeMax.value);

            if (minVal > maxVal)[rangeMin.value, rangeMax.value] = [maxVal, minVal];

            minInput.value = rangeMin.value;
            maxInput.value = rangeMax.value;
            updateSliderFill();
        }

        function syncFromInput() {
            let minVal = parseInt(minInput.value);
            let maxVal = parseInt(maxInput.value);

            if (!isNaN(minVal)) rangeMin.value = minVal;
            if (!isNaN(maxVal)) rangeMax.value = maxVal;

            syncFromSlider();
        }

        rangeMin.addEventListener('input', syncFromSlider);
        rangeMax.addEventListener('input', syncFromSlider);
        minInput.addEventListener('blur', syncFromInput);
        maxInput.addEventListener('blur', syncFromInput);

        // Initial fill
        syncFromSlider();


        // === MODAL LOGIC
    });
</script>