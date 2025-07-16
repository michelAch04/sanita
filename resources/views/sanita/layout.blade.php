<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="min-vh-100">

<head>

    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sanita')</title>


    <!-- CSS Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ui-tools.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<!-- Start of Tawk.to Script-->
<!-- <script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/685bf31998cd33190fa73cd9/1iujir7d8';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script> -->
<!--End of Tawk.to Script -->

<body class="d-flex flex-column">
    <nav id="mainNavbar" class="navbar shadow fixed-top px-2">
        <div class="container-fluid m-0">
            <div class="d-flex w-100 align-items-center justify-content-between">
                {{-- Toggle Menu (left) --}}
                <div class="col-4">
                    <button class="btn text-start border-0" id="menuToggle" aria-label="Toggle navigation">
                        <i class="fas fa-bars fs-4 text-primary nav-link"></i>
                    </button>
                </div>

                {{-- Brand (centered) --}}
                <a class="navbar-brand col-4 text-center m-0" href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}">
                    <img src="{{ asset('storage/login/sanita.png') }}" alt="Logo" height="32">
                </a>

                {{-- Right Icons --}}
                <div class="d-flex align-items-center justify-content-end gap-0 col-4 right-icons-container">
                    @auth('customer')
                    <div class="nav-link text-break text-nowrap overflow-visible">
                        @php
                        $defaultAddress = \App\Models\Address::with(['city', 'district'])
                        ->where('customers_id', auth('customer')->id())
                        ->where('is_default', true)
                        ->where('cancelled', false)
                        ->first();
                        @endphp

                        @if($defaultAddress)
                        <a href="{{ route('addresses.index', ['locale' => app()->getLocale()]) }}" class="nav-link me-2" title="{{ __('nav.addresses') }}">
                            <i class="fa-solid fa-location-dot me-1"></i>
                            <div class="d-none d-md-inline">
                                {{ $defaultAddress->city->{'name_' . app()->getLocale()} ?? '' }}, {{ $defaultAddress->district->{'name_' . app()->getLocale()} ?? '' }}
                            </div>
                        </a>
                        @else
                        <a href="{{ route('addresses.index', ['locale' => app()->getLocale()]) }}" class="btn btn-outline-light me-2" title="{{ __('nav.addresses') }}">
                            <i class="fa-solid fa-location-dot me-2"></i> {{ __('nav.addresses') }}
                        </a>
                        @endif
                    </div>

                    {{-- Cart --}}
                    <div class="position-relative nav-link">
                        <a href="{{ route('website.cart.index', ['locale' => app()->getLocale()]) }}" class="nav-link cart-icon-container">
                            <i class="fas fa-shopping-cart cart-icon"></i>
                            <span id="cart-count">
                                {{ $cartCount }}
                            </span>
                        </a>
                    </div>
                    @else
                    <a href="{{ route('customer.signin', ['locale' => app()->getLocale()]) }}" class="btn btn-outline-light me-2 pe-2 text-truncate">
                        {{ __('nav.sign_in') }}
                    </a>
                    @endauth

                    {{-- Search --}}
                    <div class="expanding-search nav-link">
                        <i class="fas fa-search search-icon"></i>
                        <input type="search" id="searchInput" placeholder="{{ __('nav.search_placeholder') }}">
                    </div>
                </div>
            </div>

            {{-- Offcanvas Menu --}}
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu">
                <div class="offcanvas-header">
                    <h4 class="offcanvas-title">{{ __('nav.menu') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body d-flex flex-column justify-content-between">
                    {{-- Main Navigation Links --}}
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}">
                                <i class="fa-solid fa-house me-2"></i>{{ __('nav.home') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('website.offers.index', ['locale' => app()->getLocale()]) }}">
                                <i class="fa-solid fa-tags me-2"></i>{{ __('nav.offers') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('website.products.index', ['locale' => app()->getLocale()]) }}">
                                <i class="fa-solid fa-store me-2"></i>{{ __('nav.store') }}
                            </a>
                        </li>
                        @auth('customer')
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('website.orders.index', ['locale' => app()->getLocale()]) }}">
                                <i class="fa-solid fa-box-archive me-2"></i>{{ __('nav.order_history') }}
                            </a>
                        </li>
                        @endauth
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('about', ['locale' => app()->getLocale()]) }}">
                                <i class="fa-solid fa-circle-info me-2"></i>{{ __('nav.about') }}
                            </a>
                        </li>
                    </ul>
                    <div class="d-flex ms-3 justify-content-end">
                        @auth('customer')
                        <div class="dropup pe-2">
                            <button class="btn btn-outline-light dropdown-toggle d-flex justify-content-center align-items-center flex-row" type="button" id="userDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>
                                <span class="user-dropdown-text">{{ Auth::guard('customer')->user()->first_name }}</span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li>
                                    <form action="{{ route('customer.signout', ['locale' => app()->getLocale()]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="fa-solid fa-right-from-bracket me-2"></i>{{ __('nav.sign_out') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @endauth

                        <div class="dropup me-3">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" id="localeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ strtoupper(app()->getLocale()) }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="localeDropdown">
                                <li>
                                    <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                                        href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), array_merge(request()->route()->parameters(), ['locale' => 'en'])) }}">
                                        EN English
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}"
                                        href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), array_merge(request()->route()->parameters(), ['locale' => 'ar'])) }}">
                                        AR العربية
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ app()->getLocale() == 'ku' ? 'active' : '' }}"
                                        href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), array_merge(request()->route()->parameters(), ['locale' => 'ku'])) }}">
                                        KU کوردی
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </nav>

    <div id="content">
        <!-- Main Content -->
        @yield('content')
    </div>

    @include('components.toast')

    <!-- Footer -->
    <footer class="footer text-center mt-auto py-4">
        <div class="container">
            <p class="mb-1">{{ __('nav.copyright') }}</p>
            <p>
                <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}#offers" class="text-decoration-none">
                    {{ __('nav.offers') }}
                </a> |
                <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}#products" class="text-decoration-none">
                    {{ __('nav.products') }}
                </a> |
                <a href="{{ route('about', ['locale' => app()->getLocale()]) }}" class="text-decoration-none">
                    {{ __('nav.about') }}
                </a>
            </p>
        </div>
    </footer>

    <div id="pageLoader" class="page-loader">
        <div class="cubes-container">
            <div class="loop cubes" role="status">
                <div class="loop-item cubes"></div>
                <div class="loop-item cubes"></div>
                <div class="loop-item cubes"></div>
                <div class="loop-item cubes"></div>
                <div class="loop-item cubes"></div>
            </div>
        </div>
    </div>
</body>

<!-- Core Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional: Your JS Plugins -->
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<!-- Laravel Assets -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/modals.js') }}"></script>
<script src="{{ asset('js/promocode.js') }}"></script>ip

<!-- Global Window Variables -->
<script>
    window.csrfToken = "{{ csrf_token() }}";
    window.toastMessages = {
        success: "{{ __('nav.success') }}",
        failed: "{{ __('nav.failed') }}",
        error: "{{ __('nav.error') }}",
        warning: "{{ __('nav.warning') }}"
    }
    window.isRtl = '{{ $isRtl }}';
    window.signinUrl = "{{ route('customer.signin', ['locale' => app()->getLocale()]) }}";
    window.validatePromoUrl = "{{ route('cart.validatepromocode', ['locale' => app()->getLocale()]) }}";
    window.removePromoUrl = "{{ route('cart.validatepromocode' , ['locale' => app()->getLocale()]) }}";
    window.csrfToken = "{{ csrf_token() }}";
    window.cartMessages = {
        addSuccess: "{{ __('nav.cart_add_success') }}",
        addFail: "{{ __('nav.cart_add_failed') }}",
        addError: "{{ __('nav.cart_add_error') }}",
        viewInCart: "{{ __('cart.view_in_cart') }}",
        outOfStock: "{{ __('cart.out_of_stock') }}",
        updateSuccess: '{{ __("cart.update_success") }}',
        updateFailed: '{{ __("cart.update_failed") }}',
        updateError: '{{ __("cart.update_error") }}',
        removeConfirm: '{{ __("cart.remove_confirm") }}',
        removeSuccess: '{{ __("cart.remove_success") }}',
        removeFailed: '{{ __("cart.remove_failed") }}',
        removeError: '{{ __("cart.remove_error") }}'
    };
    window.locale = "{{ app()->getLocale() }}";
    window.url = "{{ url('') }}";
    window.addressMessages = {
        loading: "{{ __('address.Loading...') }}",
        selectCity: "{{ __('address.Select_City') }}",
        selectDistrict: "{{ __('address.Select_District') }}",
        selectGovernorate: "{{ __('address.Select_Governorate') }}"
    };
    window.uomLabels = {
        EA: "{{ __('cart.EA') }}",
        CA: "{{ __('cart.CA') }}",
        PL: "{{ __('cart.PL') }}"
    };
    window.locale = "{{ app()->getLocale() }}";

    window.conversionCaseEach = "{{ __('cart.conversion_case_each') }}";
    window.conversionPalletEach = "{{ __('cart.conversion_pallet_each') }}";

    window.currentPriceUpdates = {
        unitPrice: 0,
        shelfPrice: 0,
        oldPrice: 0,
        minQuantity: 0,
        maxQuantity: 0,
        conversionText: ''
    };
</script>

<!-- Per-page Scripts -->
@stack('scripts')

</html>