<form method="GET" action="{{ url()->current() }}" class="filter-form">
    <div class="filter-sidebar">

        {{-- === BRAND FILTER === --}}
        <div class="filter-group mb-3">
            <div class="d-flex justify-content-between align-items-center toggle-header mb-1">
                <h6 class="mb-0">{{ __('Filter by Brand') }}</h6>
                <button type="button" class="toggle-btn" data-target="#brand-filter">+</button>
            </div>
            <div id="brand-filter" class="toggle-content">
                @foreach($brands as $brand)
                @php $checkedBrands = (array) request()->input('brand', []); @endphp
                <div class="form-check d-flex align-items-center mb-1">
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
        <div class="filter-group mb-3">
            <div class="d-flex justify-content-between align-items-center toggle-header mb-1">
                <h6 class="mb-0">{{ __('Filter by Category') }}</h6>
                <button type="button" class="toggle-btn" data-target="#category-filter">+</button>
            </div>
            <div id="category-filter" class="toggle-content">
                @foreach($categories as $category)
                @php $checkedCategories = (array) request()->input('category', []); @endphp
                <div class="form-check d-flex align-items-center mb-1">
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
        <div class="filter-group mb-3">
            <div class="d-flex justify-content-between align-items-center toggle-header mb-1">
                <h6 class="mb-0">{{ __('Filter by Price') }}</h6>
                <button type="button" class="toggle-btn" data-target="#price-filter">+</button>
            </div>
            <div id="price-filter" class="toggle-content">
                <div class="my-2">
                    <label for="min_price">{{ __('Min Price') }}</label>
                    <input type="number" name="min_price" id="min_price"
                        class="form-control auto-submit"
                        value="{{ request('min_price') }}">
                </div>
                <div class="mb-2">
                    <label for="max_price">{{ __('Max Price') }}</label>
                    <input type="number" name="max_price" id="max_price"
                        class="form-control auto-submit"
                        value="{{ request('max_price') }}">
                </div>
            </div>
        </div>
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.filter-form');

    // === Auto-submit on input change ===
    form.querySelectorAll('.auto-submit').forEach(input => {
        input.addEventListener('change', () => {
            const formData = new FormData(form);
            const params = new URLSearchParams();

            for (const [key, value] of formData.entries()) {
                params.append(key, value);
            }

            window.location.href = `${form.action}?${params.toString()}`;
        });
    });

    // === Expand only sections that have active query values ===
    const urlParams = new URLSearchParams(window.location.search);
    const activeFields = ['brand', 'category', 'min_price', 'max_price'];

    activeFields.forEach(field => {
        if (urlParams.has(field) || urlParams.getAll(`${field}[]`).length > 0) {
            const targetId = `#${field.replace('_', '-')}-filter`;
            const content = document.querySelector(targetId);
            const toggleBtn = document.querySelector(`.toggle-btn[data-target="${targetId}"]`);

            if (content && toggleBtn) {
                content.classList.add('expanded');
                content.style.maxHeight = content.scrollHeight + 'px';
                toggleBtn.textContent = '−';
            }
        }
    });

    // === Toggle on click
    document.querySelectorAll('.toggle-btn').forEach(button => {
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
});
</script>
