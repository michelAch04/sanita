<!DOCTYPE html>
<html lang="en" style="min-height:100vh;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanita</title>

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
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('sanita.index') }}">
                <span>Sanita</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('sanita.index') }}#categories">Categories</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('sanita.index') }}#products">Products</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('about') }}">About Us</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('contact') }}">Contact Us</a></li>
                    @auth('customer')
                    <li class="nav-item">
                        <a href="{{ route('cart.index') }}" class="nav-link">
                            <i class="fas fa-shopping-cart cart-icon"></i>
                        </a>
                    </li>
                    @endauth
                </ul>

                <div class="d-flex ms-3">
                    @guest('customer')
                    <a href="{{ route('customer.signin') }}" class="btn btn-outline-light me-2">Sign In</a>
                    @else
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i>
                            {{ Auth::guard('customer')->user()->first_name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li>
                                <form action="{{ route('customer.signout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Sign Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer text-center bg-dark text-white mt-auto py-4">
        <div class="container">
            <p class="mb-1">&copy; 2025 Sanita. All rights reserved.</p>
            <p>
                <a href="#categories" class="text-white text-decoration-none">Categories</a> |
                <a href="#products" class="text-white text-decoration-none">Products</a> |
                <a href="#about-us" class="text-white text-decoration-none">About Us</a> |
                <a href="#contact-us" class="text-white text-decoration-none">Contact Us</a>
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
        });
    </script>
</body>

</html>