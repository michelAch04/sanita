@extends('sanita.layout')

@section('title', $category->name_en)

@section('content')
<section id="category" class="py-2 pt-0 bg-light">
    <!-- Header Buttons -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 p-3 pb-0">
        <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}" class="btn underline-btn mb-2 underline-arctic">
            <span class="text"><i class="fa-solid fa-arrow-left me-1"></i> {{ __('nav.back') }}</span>
        </a>
        <a href="{{ route('website.categories.index', ['locale' => app()->getLocale()]) }}" class="btn underline-btn mb-2 underline-arctic">
            <span class="text">{{ __('nav.all_categories') }}<i class="fa-solid fa-arrow-right ms-1"></i></span>
        </a>
    </div>

    <div class="p-5 pt-0 gx-0 w-100 category-info">
        <!-- Category Title -->
        <div class="text-center mb-4 category-title">
            <h2 class="display-5 m-0 text-break section-title">
                {{ $category->{'name_'.app()->getLocale()} ?? $category->name_en }}
            </h2>
        </div>

        @php $hasSubcatFilter = $validSubcategories->count() > 1; @endphp

        @if($categoryBrands->isNotEmpty())
        <!-- Brand Filter Row -->
        <div class="subcategory-tabs-container {{ $hasSubcatFilter ? 'mb-2' : 'mb-4' }} position-relative" id="brandFilterContainer">
            <button class="scroll-btn scroll-left" aria-label="Scroll left">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="subcategory-tabs-wrapper">
                <ul class="nav nav-pills flex-nowrap" id="brandFilterTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-brand="0" type="button">
                            <img src="{{ asset('images/login/sanita.png') }}" alt="All Brands" class="brand-pill-img">
                            <span>{{ __('nav.all_brands') ?? 'All Brands' }}</span>
                        </button>
                    </li>
                    @foreach($categoryBrands as $brand)
                    <li class="nav-item">
                        <button class="nav-link" data-brand="{{ $brand->id }}" type="button">
                            <img src="{{ $brand->extension ? asset('storage/brands/' . $brand->id . '.' . $brand->extension) : asset('images/login/sanita.png') }}"
                                 alt="{{ $brand->{'name_'.app()->getLocale()} ?? $brand->name_en }}"
                                 class="brand-pill-img">
                            <span>{{ $brand->{'name_'.app()->getLocale()} ?? $brand->name_en }}</span>
                        </button>
                    </li>
                    @endforeach
                </ul>
            </div>
            <button class="scroll-btn scroll-right" aria-label="Scroll right">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
        @endif

        @if($hasSubcatFilter)
        <!-- Subcategory Filter Row -->
        <div class="subcategory-tabs-container mb-4 position-relative" id="subcatFilterContainer">
            <button class="scroll-btn scroll-left" aria-label="Scroll left">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="subcategory-tabs-wrapper">
                <ul class="nav nav-pills flex-nowrap" id="subcategoryTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-subcat="0" type="button">
                            {{ __('nav.all_subcategories') ?? 'All Subcategories' }}
                        </button>
                    </li>
                    @foreach($validSubcategories as $subcategory)
                    <li class="nav-item">
                        <button class="nav-link" data-subcat="{{ $subcategory->id }}" type="button">
                            {{ $subcategory->{'name_'.app()->getLocale()} ?? $subcategory->name_en }}
                        </button>
                    </li>
                    @endforeach
                </ul>
            </div>
            <button class="scroll-btn scroll-right" aria-label="Scroll right">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
        @endif

        @if($allProducts->isNotEmpty())
        <div class="products-list">
            <div class="d-flex flex-wrap justify-content-center gap-2 list-container">
                @foreach($allProducts as $product)
                @php
                $isOffer = $offers && in_array($product, $offers);
                $cardType = $isOffer ? 'offer' : 'product';
                $badge = $isOffer ? __('nav.offer') : null;
                @endphp
                @include('sanita.partials.product-card', ['product' => $product, 'cardType' => $cardType, 'badge' => $badge])
                @endforeach
            </div>
        </div>
        <p class="no-results-msg text-center pt-5 text-primary" style="display:none;">
            {{ __('No products match your selection.') }}
        </p>
        @else
        <p class="text-center pt-5 text-primary">{{ __('No products available in this category.') }}</p>
        @endif
    </div>
</section>

@include('sanita.partials.add-to-cart-modal')
@include('sanita.partials.contact-us')
<link href="{{ asset('css/category.css') }}" rel="stylesheet" />
<script>
document.addEventListener("DOMContentLoaded", function () {

    var activeBrand = 0;
    var activeSubcat = 0;

    // ── Combined filter ───────────────────────────────────────────────────
    function applyFilters() {
        var visible = 0;
        document.querySelectorAll('.product-card[data-brand-id]').forEach(function (card) {
            var brandMatch = activeBrand === 0 || parseInt(card.dataset.brandId) === activeBrand;
            var subcatMatch = activeSubcat === 0 || parseInt(card.dataset.subcategoryId) === activeSubcat;
            var show = brandMatch && subcatMatch;
            if (show) {
                card.style.removeProperty('display');
                visible++;
            } else {
                card.style.setProperty('display', 'none', 'important');
            }
        });
        var noMsg = document.querySelector('.no-results-msg');
        if (noMsg) noMsg.style.display = visible === 0 ? '' : 'none';
    }

    // ── Generic scrollable filter row initializer ─────────────────────────
    function initFilterRow(containerId, onActivate) {
        var container = document.getElementById(containerId);
        if (!container) return;

        var wrapper = container.querySelector('.subcategory-tabs-wrapper');
        var btnLeft = container.querySelector('.scroll-left');
        var btnRight = container.querySelector('.scroll-right');
        var pills = Array.from(container.querySelectorAll('.nav-link'));
        if (!wrapper || !pills.length) return;

        var idx = 0;
        pills.forEach(function (p, i) { if (p.classList.contains('active')) idx = i; });

        function activate(newIdx) {
            idx = Math.max(0, Math.min(newIdx, pills.length - 1));
            pills.forEach(function (p) { p.classList.remove('active'); });
            pills[idx].classList.add('active');
            onActivate(pills[idx]);
            applyFilters();
        }

        pills.forEach(function (pill, i) {
            pill.addEventListener('click', function () { activate(i); });
        });

        if (btnRight) {
            btnRight.addEventListener('click', function () {
                btnRight.classList.add('activated');
                activate(idx + 1);
                var t = pills[idx];
                wrapper.scrollTo({ left: t.offsetLeft + t.offsetWidth - wrapper.offsetWidth, behavior: 'smooth' });
                setTimeout(function () { btnRight.classList.remove('activated'); }, 300);
            });
        }

        if (btnLeft) {
            btnLeft.addEventListener('click', function () {
                btnLeft.classList.add('activated');
                activate(idx - 1);
                var t = pills[idx];
                wrapper.scrollTo({ left: t.offsetLeft - wrapper.offsetLeft, behavior: 'smooth' });
                setTimeout(function () { btnLeft.classList.remove('activated'); }, 300);
            });
        }
    }

    // ── Initialise rows ───────────────────────────────────────────────────
    initFilterRow('brandFilterContainer', function (pill) {
        activeBrand = parseInt(pill.dataset.brand ?? 0);
    });

    initFilterRow('subcatFilterContainer', function (pill) {
        activeSubcat = parseInt(pill.dataset.subcat ?? 0);
    });
});
</script>

@endsection
