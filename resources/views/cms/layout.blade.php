<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('storage/login/sanita.png') }}">
    <title>@yield('title', 'CMS')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Summernote CSS (Bootstrap 5 compatible version) -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">



    <link href="{{ asset('css/ui-tools.css?v=20260306-2') }}" rel="stylesheet" />
    <link href="{{ asset('css/view-styles.css?v=20260306-2') }}" rel="stylesheet" />
    @stack('styles') <!-- For page-specific CSS -->
</head>

<body style="overflow-x: hidden !important;">

    <div class="container-fluid">
        <div class="d-flex" id="app-container">
            <!-- Sidebar -->
            <nav id="sidebar" class="sidebar bg-dark text-white sidebar-collapsed vh-100 overflow-auto position-fixed top-0 start-0">
                <div class="sidebar-header p-2 fw-bold d-flex align-items-center gap-2">
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
                </ul>
            </nav>

            <!-- Content -->
            <main class="flex-grow-1 bg-light p-4">
                @yield('content')
            </main>

            <!-- Right Hover Sidebar (Logout) -->
            <nav id="sidebar-right" class="sidebar-right bg-danger text-white">
                <ul class="nav flex-column">
                    <li class="nav-item ">
                        <button type="button" class="nav-link text-white border-0 text-start ps-1 pe-2 w-100"
                            data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="sidebar-label">Logout</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    @include('components.toast')
    @include('components.modal')

    @stack('scripts') <!-- For page-specific JS -->

    <script src="{{ asset('js/modals.js?v=20260306-2') }}"></script>
    <script src="{{ asset('js/ajax-live-search.js?v=20260306-2') }}"></script>
    <script src="{{ asset('js/file-input.js?v=20260306-2') }}"></script>
    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    @stack('after-scripts')

    @include('cms.partials.change-order')

</body>

</html>