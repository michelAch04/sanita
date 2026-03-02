@extends('sanita.layout')

@section('title', __('Products'))

@section('content')
<section id="products" class="py-3 products-list {{ $isRtl ? 'rtl-container' : '' }}">
    <div class="px-2 py-2 gx-0 w-100">
        <h2 class="display-5 text-center mb-3 mb-md-5 section-title">{{ __('nav.products') }}</h2>

        <div class="d-flex flex-md-row gap-md-1 flex-column">
            <div class="bg-secondary filter-container p-lg-3 p-2">
                <form method="GET" action="{{ url()->current() }}" id="sidebar-filterForm"
                    class="filter-form {{ $isRtl ? 'rtl-container' : '' }}">
                    <div class="filter-sidebar" id="filterSidebar">
                        <h5 class="mb-0">{{ __('Filters') }}</h5>
                        <hr class="mt-1 mb-3">
                        @include('sanita.partials.filter-results',
                        ['brands' => $brands,
                        'categories' => $categories,
                        'products' => $products,
                        'eaPrices' => $eaPrices,
                        'panel' => false])
                    </div>
                </form>
            </div>

            <button class="btn underline-btn underline-arctic d-md-none ms-4 align-self-start"
                onclick="toggleFilterPanel()">
                <i class="fa fa-filter me-1"></i> {{ __('Filters') }}
            </button>

            @if($products->isEmpty())
            <div class="empty-filter-alert text-center py-5 px-4 my-5 rounded-4 shadow-sm">
                <div class="empty-filter-icon">
                    <i class="fa-solid fa-filter-circle-xmark"></i>
                </div>
                <div class="fs-4 fw-semibold mb-2 text-primary empty-filter-msg">
                    {{ __('No products match your filters.') }}
                </div>
                <a href="{{ url()->current() }}" class="btn bubbles bubbles-arctic mt-3 px-4 py-2 fs-6 shadow-sm empty-filter-btn">
                    <span class="text"><i class="fa fa-filter me-2"></i> {{ __('Reset Filters') }}</span>
                </a>
            </div>
            @else
            <div class="d-flex flex-wrap justify-content-center gap-2 list-container filtered-container">
                @foreach($products as $product)
                @include('sanita.partials.product-card', [
                'product' => $product,
                'cardType' => 'product'
                ])
                @endforeach
            </div>
        </div>
    </div>
    <!-- Pagination -->
    <div class="d-flex justify-content-center list-pagination">
        {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
    </div>
</section>
<!-- Filter Slide-Up Panel -->
<div id="filterPanelBackdrop" class="filter-backdrop d-none" onclick="toggleFilterPanel()"></div>

<div id="filterPanel" class="filter-panel d-none fixed-bottom">
    <div class="filter-panel-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
        <h5 class="mb-0">{{ __('Filters') }}</h5>
        <button class="btn-close" onclick="toggleFilterPanel()"></button>
    </div>
    <div class="filter-panel-body px-3 py-2 overflow-auto">
        <form method="GET" action="{{ url()->current() }}" id="panel-filterForm"
            class="filter-form {{ $isRtl ? 'rtl-container' : '' }}">
            @include('sanita.partials.filter-results',
            ['brands' => $brands,
            'categories' => $categories,
            'products' => $products,
            'eaPrices' => $eaPrices,
            'panel' => true])
        </form>
    </div>
</div>
<script>
    function showPriceFilter() {
        const priceContent = document.querySelector(`#panel-price-filter`);
        const priceToggleBtn = document.querySelector(`.toggle-btn[data-target="#panel-price-filter"]`);

        if (priceContent && priceToggleBtn) {
            priceContent.classList.add('expanded');
            priceContent.style.maxHeight = priceContent.scrollHeight + 'px';
            priceToggleBtn.textContent = '−';
        }
    }

    function toggleFilterPanel() {
        const panel = document.getElementById('filterPanel');
        const backdrop = document.getElementById('filterPanelBackdrop');
        const isOpen = panel.classList.contains('show');

        if (isOpen) {
            panel.classList.remove('show');
            setTimeout(() => {
                panel.classList.add('d-none');
                backdrop.classList.add('d-none');
            }, 300);
        } else {
            panel.classList.remove('d-none');
            backdrop.classList.remove('d-none');
            setTimeout(() => {
                panel.classList.add('show');
                showPriceFilter()
            }, 10);
        }
    }
</script>
<link rel="stylesheet" href="{{ asset('css/products-list.css') }}?v=20260302-5" />
@include('sanita.partials.add-to-cart-modal')
@endsection