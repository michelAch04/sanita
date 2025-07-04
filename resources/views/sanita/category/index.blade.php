@extends('sanita.layout')

@section('title', $category->name_en)

@section('content')
<section id="category" class="py-3 bg-light">
    <div class="p-5 gx-0 w-100">
        <!-- Header Buttons -->
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}" class="btn bubbles bubbles-arctic mb-2">
                <span class="text"><i class="fa-solid fa-arrow-left me-1"></i> {{ __('Continue Shopping') }}</span>
            </a>

            <a href="{{ route('website.categories.index', ['locale' => app()->getLocale()]) }}" class="btn bubbles bubbles-arctic mb-2 ">
                <span class="text">{{ __('nav.view_all_categories') }}<i class="fa-solid fa-arrow-right ms-1"></i></span>
            </a>
        </div>

        <!-- Category Title -->
        <div class="text-center mb-4">
            <h2 class="display-5 m-0 text-break section-title">
                {{ $category->{'name_'.app()->getLocale()} ?? $category->name_en }}
            </h2>
        </div>


        @if($category->subcategories->count() > 1)
        <!-- Multiple subcategories: Show tabs -->
        <ul class="nav nav-pills justify-content-center mb-4" id="subcategoryTabs" role="tablist">
            @foreach($category->subcategories as $index => $subcategory)
            <li class="nav-item" role="presentation">
                <button class="nav-link @if($index === 0) active @endif"
                    id="tab-{{ $subcategory->id }}"
                    data-bs-toggle="pill"
                    data-bs-target="#content-{{ $subcategory->id }}"
                    type="button"
                    role="tab">
                    {{ $subcategory->name_en }}
                </button>
            </li>
            @endforeach
        </ul>

        <div class="tab-content" id="subcategoryTabContent">
            @foreach($category->subcategories as $index => $subcategory)
            @php
            $subProducts = $productsBySubcategory[$subcategory->id] ?? null;
            @endphp
            <div class="tab-pane fade @if($index === 0) show active @endif"
                id="content-{{ $subcategory->id }}"
                role="tabpanel">
                @if($subProducts && $subProducts->isNotEmpty())
                <div class="d-flex flex-wrap justify-content-center gap-3">
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
                <div class="d-flex justify-content-center mt-4">
                    {{ $subProducts->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
                @else
                <p class="text-center">{{ __('No products available in this subcategory.') }}</p>
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
        <div class="d-flex flex-wrap justify-content-center gap-3">
            @foreach($products as $product)
            @include('sanita.partials.product-card', [
            'product' => $product,
            'cardType' => 'product'
            ]) @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @else
        <p class="text-center">{{ __('No products available in this category.') }}</p>
        @endif

        @else
        <!-- No subcategories -->
        <p class="text-center">{{ __('No products available in this category.') }}</p>
        @endif
    </div>
</section>

@include('sanita.partials.add-to-cart-modal')
@include('sanita.partials.contact-us')

<style>
    @media(max-width:800px) {
        #category div {
            padding: 0.1rem !important;
        }

        .bubbles {
            width: fit-content;
            font-size: 0.7rem;
            padding: 0.25rem 0.2rem;
        }
    }

    .nav-pills .nav-item .nav-link {
        color: #38B2AC;
    }

    .nav-pills .nav-item .nav-link.active {
        color: #fff;
        background-color: #38B2AC;
    }

    .product-card {
        flex: 0 0 auto;
        width: 18%;
        margin: 5px !important;
    }

    @media (max-width: 1200px) {
        .product-card {
            width: 22%;
        }
    }

    @media (max-width: 992px) {
        .product-card {
            width: 28%;
        }
    }

    @media (max-width: 768px) {
        .product-card {
            width: 45%;
        }
    }

    @media (max-width: 576px) {
        .product-card {
            width: 90%;
        }
    }
</style>
@endsection