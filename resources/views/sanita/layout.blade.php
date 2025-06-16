<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" style="min-height:100vh;">

<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sanita')</title>

    <!-- CSS Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <style>
        .hero-carousel {
            margin-top: 56px;
        }

        .hero-carousel img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .cart-icon {
            font-size: 1.5rem;
        }

        .nav-item.position-relative {
            position: relative;
        }

        #cart-count {
            font-size: 0.75rem;
            width: 20px;
            height: 20px;
            line-height: 18px;
            text-align: center;
            padding: 0;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}">
                <span>Sanita</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}#offers">
                            {{ __('nav.offers') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('sanita.index', ['locale' => app()->getLocale()]) }}#products">
                            {{ __('nav.store') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('about', ['locale' => app()->getLocale()]) }}">
                            {{ __('nav.about') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('contact', ['locale' => app()->getLocale()]) }}">
                            {{ __('nav.contact') }}
                        </a>
                    </li>
                    @auth('customer')
                    <li class="nav-item position-relative">
                        <a href="{{ route('cart.index', ['locale' => app()->getLocale()]) }}" class="nav-link">
                            <i class="fas fa-shopping-cart cart-icon"></i>
                            <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        </a>
                    </li>
                    @endauth
                </ul>

                <div class="d-flex ms-3">
                    @guest('customer')
                    <a href="{{ route('customer.signin', ['locale' => app()->getLocale()]) }}" class="btn btn-outline-light me-2">
                        {{ __('nav.sign_in') }}
                    </a>
                    @else
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i>
                            {{ Auth::guard('customer')->user()->first_name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li>
                                <a href="{{ route('addresses.index', ['locale' => app()->getLocale()]) }}" class="dropdown-item">
                                    <i class="fas fa-map-marker-alt me-2"></i> {{ __('nav.addresses') }}
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('customer.signout', ['locale' => app()->getLocale()]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">{{ __('nav.sign_out') }}</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endguest

                    <form method="GET" action="" class="me-3">
                        <select class="form-select" style="width:auto;display:inline;" onchange="window.location.href=this.value;">
                            <option value="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), array_merge(request()->route()->parameters(), ['locale' => 'en'])) }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                            <option value="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), array_merge(request()->route()->parameters(), ['locale' => 'ar'])) }}" {{ app()->getLocale() == 'ar' ? 'selected' : '' }}>العربية</option>
                            <option value="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), array_merge(request()->route()->parameters(), ['locale' => 'ku'])) }}" {{ app()->getLocale() == 'ku' ? 'selected' : '' }}>کوردی</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')
    @stack('scripts')

    <!-- Footer -->
    <footer class="footer text-center bg-dark text-white mt-auto py-4">
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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.hero-carousel').slick({
                dots: false,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: false,
                draggable: true,
                swipe: true,
            });

            // AJAX Add to Cart Handler
            $(document).on('submit', 'form.add-to-cart-form', function(e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let data = form.serialize();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.cart_count !== undefined) {
                                $('#cart-count').text(response.cart_count);
                            } else {
                                let current = parseInt($('#cart-count').text()) || 0;
                                $('#cart-count').text(current + 1);
                            }
                            alert(response.message || 'Added to cart successfully!');
                            location.reload();
                        } else {
                            alert(response.message || 'Failed to add to cart.');
                        }
                    },
                    error: function() {
                        alert('Error occurred while adding to cart.');
                    }
                });
            });
        });
    </script>

</body>

</html>