@extends('sanita.layout')

@section('title', $category->name_en)

@section('content')
<section id="category" class="py-2 pt-0 bg-light">
    <!-- Header Buttons -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 p-3 pb-0">
        <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}" class="btn underline-btn mb-2 category-index-btn">
            <span class="text"><i class="fa-solid fa-arrow-left me-1"></i> {{ __('nav.back') }}</span>
        </a>

        <a href="{{ route('website.categories.index', ['locale' => app()->getLocale()]) }}" class="btn underline-btn mb-2 category-index-btn">
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


        @if($category->subcategories->count() > 1)
        <!-- Multiple subcategories: Show tabs -->
        <div class="subcategory-tabs-container mb-4 position-relative">
            <!-- Left Arrow -->
            <button class="scroll-btn scroll-left" aria-label="Scroll left">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <!-- Scrollable Nav Tabs -->
            <div class="subcategory-tabs-wrapper">
                <ul class="nav nav-pills flex-nowrap" id="subcategoryTabs" role="tablist">
                    @foreach($category->subcategories as $index => $subcategory)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($index === 0) active @endif"
                            id="tab-{{ $subcategory->id }}"
                            data-bs-toggle="pill"
                            data-bs-target="#content-{{ $subcategory->id }}"
                            type="button"
                            role="tab"
                            onclick="activeIndex = '{{ $index }}';">
                            {{ $subcategory->{'name_'.app()->getLocale()} ?? $subcategory->name_en }}
                        </button>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Right Arrow -->
            <button class="scroll-btn scroll-right" aria-label="Scroll right">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <div class="tab-content" id="subcategoryTabContent">
            @foreach($category->subcategories as $index => $subcategory)
            @php
            $subProducts = $productsBySubcategory[$subcategory->id] ?? null;
            @endphp
            <div class="tab-pane fade @if($index === 0) show active @endif"
                id="content-{{ $subcategory->id }}"
                role="tabpanel">
                @if($subProducts && $subProducts->isNotEmpty())
                <div class="products-list">
                    <div class="d-flex flex-wrap justify-content-center gap-2 list-container">
                        @foreach($subProducts as $product)
                        @php
                        $isOffer = $offers && in_array($product, $offers);
                        $cardType = $isOffer ? 'offer' : 'product';
                        $badge = $isOffer ? __('nav.offer') : null;
                        @endphp
                        @include('sanita.partials.product-card', [
                        'product' => $product,
                        'cardType' => $cardType,
                        'badge' => $badge
                        ])
                        @endforeach
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-0">
                    {{ $subProducts->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
                @else
                <p class="text-center pt-5 text-primary">{{ __('No products available in this subcategory.') }}</p>
                @endif
            </div>
            @endforeach
        </div>

        @elseif($category->subcategories->count() === 1)
        <!-- Exactly one subcategory: show products directly -->
        @php
        $onlySubcategory = $category->subcategories->first();
        $products = $productsBySubcategory[$onlySubcategory->id] ?? $products ?? collect();
        @endphp
        @if($products->isNotEmpty())
        <div class="products-list">
            <div class="d-flex flex-wrap justify-content-center gap-2 list-container">
                @foreach($products as $product)
                @include('sanita.partials.product-card', [
                'product' => $product,
                'cardType' => 'product'
                ]) @endforeach
            </div>
        </div>
        <div class="d-flex justify-content-center mt-0">
            {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @else
        <p class="text-center pt-5 text-primary">{{ __('No products available in this category.') }}</p>
        @endif

        @else
        <!-- No subcategories -->
        <p class="text-center pt-5 text-primary">{{ __('No products available in this category.') }}</p>
        @endif
    </div>
</section>

@include('sanita.partials.add-to-cart-modal')
@include('sanita.partials.contact-us')
<link href="{{ asset('css/category.css') }}" rel="stylesheet" />
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const wrapper = document.querySelector(".subcategory-tabs-wrapper");
        const btnLeft = document.querySelector(".scroll-left");
        const btnRight = document.querySelector(".scroll-right");
        const navLinks = wrapper?.querySelectorAll("#subcategoryTabs .nav-link");
        const tabsContent = document.querySelectorAll('#subcategoryTabContent .tab-pane');
        let activeIndex = 0;


        if (!wrapper || !btnLeft || !btnRight || !navLinks?.length) return;

        // Scroll to next tab
        btnRight.addEventListener("click", () => {
            btnRight.classList.add('activated');
            activeIndex++;
            if (activeIndex >= navLinks.length) activeIndex = navLinks.length - 1;
            updateActiveLink();

            const targetBtn = navLinks[activeIndex];
            const offset = targetBtn.offsetLeft + targetBtn.offsetWidth - wrapper.offsetWidth;

            wrapper.scrollTo({
                left: offset,
                behavior: "smooth"
            });

            setTimeout(() => btnRight.classList.remove('activated'), 300);
        });

        // Scroll to previous tab
        btnLeft.addEventListener("click", () => {
            btnLeft.classList.add('activated');
            activeIndex--;
            if (activeIndex < 0) activeIndex = 0;
            updateActiveLink();

            const targetBtn = navLinks[activeIndex];
            const offset = targetBtn.offsetLeft - wrapper.offsetLeft;

            wrapper.scrollTo({
                left: offset,
                behavior: "smooth"
            });

            setTimeout(() => btnLeft.classList.remove('activated'), 300);
        });


        function updateActiveLink() {
            if (activeIndex > navLinks.length - 1 || activeIndex < 0) {
                activeIndex = activeIndex < 0 ? 0 : navLinks.length - 1;
                return;
            }
            const currentActive = document.querySelector('#subcategoryTabs .nav-link.active');
            const currentActiveTab = document.querySelector('#subcategoryTabContent .tab-pane.active');

            currentActive.classList.remove('active');
            currentActiveTab.classList.remove('show');
            currentActiveTab.classList.remove('active');

            navLinks[activeIndex].classList.add('active');
            tabsContent[activeIndex].classList.add('show');
            tabsContent[activeIndex].classList.add('active');
        }
    });

    function initBtnWidth(navLinks) {
        // Make all nav-link buttons same width as the widest one
        let maxWidth = 0;
        navLinks.forEach(btn => {
            btn.style.width = 'auto'; // reset if previously set
            const btnWidth = btn.offsetWidth;
            if (btnWidth > maxWidth) maxWidth = btnWidth;
        });
        navLinks.forEach(btn => btn.style.width = maxWidth + 'px');
    }
</script>

@endsection