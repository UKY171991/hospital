<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Material Dashboard Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/material-dashboard@3.1.0/assets/css/material-dashboard.min.css" rel="stylesheet">
    <!-- jQuery (required for AJAX in user management) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('styles')
</head>
<body class="g-sidenav-show bg-gray-200">
    <div class="min-vh-100 d-flex">
        @include('includes.sidebar')
        <main class="main-content flex-grow-1 px-3">
            @include('includes.navbar')
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </main>
    </div>
    <!-- Material Dashboard & Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/material-dashboard@3.1.0/assets/js/material-dashboard.min.js"></script>
    @stack('scripts')
</body>
</html>

<!-- Add new menu item for 'Hospital' -->
<li class="nav-item">
    <a class="nav-link" href="/hospital">
        <i class="fas fa-hospital"></i>
        <span>Hospital</span>
    </a>
</li>
