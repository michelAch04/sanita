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
    <link href="{{ asset('css/ui-tools.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/view-styles.css') }}" rel="stylesheet" />

    @stack('styles') <!-- For page-specific CSS -->
</head>

<body>
    
   <div class="container-fluid">
       <div class="row">
           <!-- Sidebar -->
           <nav class="col-md-3 col-lg-2 bg-dark text-white p-3 position-sticky" style="top: 0; height: 100vh;">
               <h4 class="mb-4">Admin Panel</h4>
               <ul class="nav flex-column">
                   @foreach ($permissions as $permission)
                   <li class="nav-item navbar-hover">
                       <a
                           href="{{ route($permission->page->url) }}"
                           class="nav-link text-white {{ request()->routeIs($permission->page->url) ? 'active' : '' }}">
                           <i class="bi {{ $permission->page->icon }}"></i> {{ $permission->page->name }}
                       </a>
                   </li>
                   @endforeach
                   <li class="nav-item">
                       <form action="{{ route('admin.logout') }}" method="POST" class="d-inline w-100">
                           @csrf
                           <button type="submit" class="nav-link text-white border-0 text-start ps-1 pe-2 navbar-hover w-100">
                               <i class="bi bi-box-arrow-right"></i> Logout
                           </button>
                       </form>
                   </li>
               </ul>
           </nav>

           <!-- Main Content -->
           <main class="col-md-9 col-lg-10 bg-light p-4">
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