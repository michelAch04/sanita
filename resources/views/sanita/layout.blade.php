<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="min-vh-100">
@php
$isRtl = app()->getLocale() === 'ar' || app()->getLocale() === 'ku';
@endphp

<head>

    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sanita')</title>

    <!-- CSS Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <link rel="stylesheet" href="{{ asset('css/ui-tools.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
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

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav id="mainNavbar" class="navbar navbar-expand-lg sticky-top shadow p-1">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}">
                <!-- <span>Sanita</span> -->
                <img src="{{ asset('storage/login/sanita.png') }}" alt="Sanita Logo" class="me-2">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav" style="margin-right: -5%;"> <!--CHECK LINE -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('website.offers.index', ['locale' => app()->getLocale()]) }}#offers">
                            {{ __('nav.offers') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('website.products.index', ['locale' => app()->getLocale()]) }}#products">
                            {{ __('nav.store') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('about', ['locale' => app()->getLocale()]) }}">
                            {{ __('nav.about') }}
                        </a>
                    </li>
                    @auth('customer')
                    <li class="nav-item">
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
                            {{ $defaultAddress->city->{'name_' . app()->getLocale()} ?? '' }}, {{ $defaultAddress->district->{'name_' . app()->getLocale()} ?? '' }}
                        </a>
                        @else
                        <a href="{{ route('addresses.index', ['locale' => app()->getLocale()]) }}" class="btn btn-outline me-2" title="{{ __('nav.addresses') }}">
                            <i class="fa-solid fa-location-dot me-2"></i> {{ __('nav.addresses') }}
                        </a>
                        @endif
                    </li>
                    @endauth
                    <li class="nav-item expanding-search position-relative">
                        <i class="fas fa-search search-icon"></i>
                        <input type="search" id="searchInput" placeholder="Search...">
                    </li>
                    @auth('customer')
                    <li class="nav-item position-relative">
                        <a href="{{ route('website.cart.index', ['locale' => app()->getLocale()]) }}" class="nav-link cart-icon-container">
                            <i class="fas fa-shopping-cart cart-icon"></i>
                            <span id="cart-count">
                                {{ $cartCount }}
                            </span>
                        </a>
                    </li>
                    @endauth
                </ul>

                <div class="d-flex ms-3">
                    @guest('customer')
                    <a href="{{ route('customer.signin', ['locale' => app()->getLocale()]) }}" class="btn btn-outline-light me-2 pe-2">
                        {{ __('nav.sign_in') }}
                    </a>
                    @else
                    <div class="dropdown pe-2">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>
                            {{ Auth::guard('customer')->user()->first_name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li>
                                <form action="{{ route('customer.signout', ['locale' => app()->getLocale()]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">{{ __('nav.sign_out') }}</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endguest

                    <div class="dropdown me-3">
                        <button class="btn button-glass dropdown-toggle" type="button" id="localeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-globe"></i> {{ strtoupper(app()->getLocale()) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="localeDropdown">
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
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer text-center text-white mt-auto py-4">
        <div class="container">
            <p class="mb-1">{{ __('nav.copyright') }}</p>
            <p>
                <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}#offers" class="text-white text-decoration-none">
                    {{ __('nav.offers') }}
                </a> |
                <a href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}#products" class="text-white text-decoration-none">
                    {{ __('nav.products') }}
                </a> |
                <a href="{{ route('about', ['locale' => app()->getLocale()]) }}" class="text-white text-decoration-none">
                    {{ __('nav.about') }}
                </a> |
                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="text-white text-decoration-none">
                    {{ __('nav.contact') }}
                </a>
            </p>
        </div>
    </footer>
    @include('components.toast')
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
        loading: "{{ __('Loading...') }}",
        selectCity: "{{ __('Select City') }}",
        selectDistrict: "{{ __('Select District') }}",
        selectGovernorate: "{{ __('Select Governorate') }}"
    };
    window.uomLabels = {
        EA: "{{ __('cart.EA') }}",
        CA: "{{ __('cart.CA') }}",
        PL: "{{ __('cart.PL') }}"
    };

    window.conversionCaseEach = "{{ __('cart.conversion_case_each') }}";
    window.conversionPalletEach = "{{ __('cart.conversion_pallet_each') }}";
</script>

<!-- Per-page Scripts -->
@stack('scripts')

</html>