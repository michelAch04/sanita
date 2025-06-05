<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'CMS')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="{{ asset('css/ui-tools.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/view-styles.css') }}" rel="stylesheet" />

    @stack('styles') <!-- For page-specific CSS -->
</head>

<body>

    <div class="container-fluid">
        <div class="d-flex" id="app-container">

            <!-- Sidebar -->
            <nav id="sidebar" class="sidebar bg-dark text-white sidebar-collapsed">
                <div class="sidebar-header p-3 fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-user-cog fs-5"></i>
                    <span class="sidebar-label">Admin Panel</span>
                </div>

                <ul class="nav flex-column">
                    @foreach ($permissions as $permission)
                    <li class="nav-item navbar-hover">
                        <a href="{{ route($permission->page->url) }}"
                            class="nav-link text-white d-flex align-items-center {{ request()->routeIs($permission->page->url) ? 'active' : '' }}">
                            <i class="bi {{ $permission->page->icon }}"></i>
                            <span class="ms-2 sidebar-label">{{ $permission->page->name }}</span>
                        </a>
                    </li>
                    @endforeach
                    <li class="nav-item navbar-hover">
                        <button type="button" class="nav-link text-white border-0 text-start ps-1 pe-2 navbar-hover w-100"
                            data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bi bi-box-arrow-right logout-icon"></i>
                            <span class="sidebar-label sidebar-logout">Logout</span>
                        </button>
                    </li>

            </nav>

            <!-- Content -->
            <main class="flex-grow-1 bg-light p-4">
                @yield('content')
            </main>
        </div>

    </div>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>


    @stack('scripts') <!-- For page-specific JS -->
    @include('components.toast')
    @include('components.modal')

    <script src="{{ asset('js/modals.js') }}"></script>
    <script src="{{ asset('js/ajax-live-search.js') }}"></script>

</body>

</html>