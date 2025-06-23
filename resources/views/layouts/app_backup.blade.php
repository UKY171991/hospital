<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap 4.5.2 CSS (required for AdminLTE 3) -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- AdminLTE 3, FontAwesome 5 via CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
        <!-- Toastr CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <!-- Select2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
        
        <style>
            :root {
                --primary-color: #007bff;
                --secondary-color: #6c757d;
                --success-color: #28a745;
                --info-color: #17a2b8;
                --warning-color: #ffc107;
                --danger-color: #dc3545;
                --light-color: #f8f9fa;
                --dark-color: #343a40;
                --white-color: #ffffff;
                --border-radius: 8px;
                --box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                --transition: all 0.3s ease;
            }

            /* Global Styling */
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f4f6f9;
                color: var(--dark-color);
                line-height: 1.6;
            }

            /* Card Enhancements */
            .card {
                border: none;
                border-radius: var(--border-radius);
                box-shadow: var(--box-shadow);
                transition: var(--transition);
                margin-bottom: 20px;
            }

            .card:hover {
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
                transform: translateY(-2px);
            }

            .card-header {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
                color: white;
                border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
                padding: 15px 20px;
                border-bottom: none;
            }

            .card-header h3,
            .card-header h4,
            .card-header h5,
            .card-header h6 {
                margin: 0;
                font-weight: 600;
            }

            .card-body {
                padding: 20px;
            }

            /* Button Enhancements */
            .btn {
                border-radius: var(--border-radius);
                padding: 8px 16px;
                font-weight: 500;
                transition: var(--transition);
                border: none;
                text-transform: none;
            }

            .btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
            }

            .btn-success {
                background: linear-gradient(135deg, var(--success-color) 0%, #1e7e34 100%);
            }

            .btn-danger {
                background: linear-gradient(135deg, var(--danger-color) 0%, #bd2130 100%);
            }

            .btn-warning {
                background: linear-gradient(135deg, var(--warning-color) 0%, #d39e00 100%);
            }

            .btn-info {
                background: linear-gradient(135deg, var(--info-color) 0%, #117a8b 100%);
            }

            /* Table Enhancements */
            .table {
                border-radius: var(--border-radius);
                overflow: hidden;
                background: white;
                box-shadow: var(--box-shadow);
            }

            .table thead th {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                border: none;
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.85rem;
                letter-spacing: 0.5px;
                padding: 15px 10px;
                color: var(--dark-color);
            }

            .table-primary thead th {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
                color: white;
            }

            .table tbody tr {
                transition: var(--transition);
            }

            .table tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.05);
                transform: scale(1.002);
            }

            .table td {
                vertical-align: middle;
                padding: 12px 10px;
                border-top: 1px solid #eee;
            }

            /* Form Enhancements */
            .form-control {
                border-radius: var(--border-radius);
                border: 1px solid #ddd;
                padding: 10px 12px;
                transition: var(--transition);
                font-size: 0.95rem;
            }

            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                transform: translateY(-1px);
            }

            .form-group label {
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 5px;
                font-size: 0.9rem;
            }

            /* Modal Enhancements */
            .modal-content {
                border-radius: var(--border-radius);
                border: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            }

            .modal-header {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
                color: white;
                border-radius: var(--border-radius) var(--border-radius) 0 0;
                border-bottom: none;
                padding: 20px;
            }

            .modal-title {
                font-weight: 600;
                font-size: 1.1rem;
            }

            .modal-body {
                padding: 25px;
            }

            .modal-footer {
                border-top: 1px solid #eee;
                padding: 20px;
            }

            /* Sidebar Enhancements */
            .main-sidebar {
                background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
                box-shadow: 2px 0 6px rgba(0,0,0,0.1);
            }

            .nav-sidebar .nav-link {
                color: rgba(255,255,255,0.8);
                border-radius: var(--border-radius);
                margin: 2px 8px;
                transition: var(--transition);
            }

            .nav-sidebar .nav-link:hover {
                background-color: rgba(255,255,255,0.1);
                color: white;
                transform: translateX(5px);
            }

            .nav-sidebar .nav-link.active {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
                color: white;
            }

            /* Status Badge Enhancements */
            .badge {
                font-size: 0.8rem;
                padding: 6px 12px;
                border-radius: 20px;
                font-weight: 500;
            }

            /* Custom animations */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .fade-in-up {
                animation: fadeInUp 0.6s ease-out;
            }
            
            /* Responsive Improvements */
            @media (max-width: 768px) {
                .btn-group {
                    flex-direction: column;
                    width: 100%;
                }
                
                .btn-group .btn {
                    margin-bottom: 5px;
                    border-radius: 4px !important;
                }
                
                .table-responsive {
                    font-size: 0.85rem;
                }
                
                .card-header h3,
                .card-header h4,
                .card-header h5 {
                    font-size: 1rem;
                }
                
                .content-header h1 {
                    font-size: 1.5rem;
                }
                
                .sidebar {
                    font-size: 0.9rem;
                }
                
                .form-group label {
                    font-size: 0.9rem;
                }
            }
            
            @media (max-width: 576px) {
                .container-fluid {
                    padding-left: 10px;
                    padding-right: 10px;
                }
                
                .card {
                    margin-bottom: 15px;
                }
                
                .btn-block {
                    width: 100%;
                    margin-bottom: 10px;
                }
                
                .modal-dialog {
                    margin: 10px;
                }
                
                .table th,
                .table td {
                    padding: 0.5rem 0.25rem;
                    font-size: 0.8rem;
                }
            }
            
            /* Page Header Styling */
            .content-header {
                background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
                border-bottom: 1px solid rgba(0,0,0,0.05);
                margin-bottom: 20px;
                padding: 20px 0;
            }
            
            .content-header h1 {
                color: var(--dark-color);
                font-size: 1.8rem;
                margin-bottom: 5px;
            }
            
            .breadcrumb {
                background: transparent;
                margin-bottom: 0;
                font-size: 0.9rem;
            }
            
            .breadcrumb-item + .breadcrumb-item::before {
                content: ">";
                color: var(--secondary-color);
            }
            
            /* Dashboard Cards */
            .info-box {
                border-radius: var(--border-radius);
                box-shadow: var(--box-shadow);
                transition: var(--transition);
                overflow: hidden;
            }
            
            .info-box:hover {
                transform: translateY(-3px);
                box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            }
            
            .info-box-icon {
                border-radius: var(--border-radius) 0 0 var(--border-radius);
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            /* Loading Spinner */
            .spinner-border-sm {
                width: 1rem;
                height: 1rem;
            }
            
            /* DataTable Enhancements */
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter,
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_processing,
            .dataTables_wrapper .dataTables_paginate {
                color: var(--dark-color);
                margin-bottom: 10px;
            }
            
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                border-radius: var(--border-radius);
                margin: 0 2px;
            }
            
            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: var(--primary-color) !important;
                border-color: var(--primary-color) !important;
                color: white !important;
            }
            
            /* Toastr customization */
            .toast {
                border-radius: var(--border-radius);
            }
        </style>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                            <i class="fas fa-bars"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- User Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i>
                            {{ Auth::user()->name ?? 'Guest' }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{ route('dashboard') }}" class="brand-link">
                    <i class="fas fa-hospital-alt brand-image text-white"></i>
                    <span class="brand-text font-weight-light text-white">Hospital HMS</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            
                            <!-- Human Resource Management -->
                            <li class="nav-item {{ request()->is('doctor*') || request()->is('employee*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Human Resource
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/doctor" class="nav-link {{ request()->is('doctor*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Doctor</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/employee" class="nav-link {{ request()->is('employee*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Employee</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Patient Management -->
                            <li class="nav-item {{ request()->is('patient*') || request()->is('opd*') || request()->is('ipd*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-injured"></i>
                                    <p>
                                        Patient Management
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/patient" class="nav-link {{ request()->is('patient*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Patient</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/opd" class="nav-link {{ request()->is('opd*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>OPD</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/ipd" class="nav-link {{ request()->is('ipd*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>IPD</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Setup & Configuration -->
                            <li class="nav-item {{ request()->is('department*') || request()->is('ward*') || request()->is('investigation*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>
                                        Setup & Configuration
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/department" class="nav-link {{ request()->is('department*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Department</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/ward" class="nav-link {{ request()->is('ward*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ward</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/investigation" class="nav-link {{ request()->is('investigation*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Investigation</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Finance Management -->
                            <li class="nav-item {{ request()->is('balance-sheet*') || request()->is('payment*') || request()->is('receipt*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        Finance Management
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/balance-sheet" class="nav-link {{ request()->is('balance-sheet*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Balance Sheet</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/payment" class="nav-link {{ request()->is('payment*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Payment</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/receipt" class="nav-link {{ request()->is('receipt*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Receipt</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Communication -->
                            <li class="nav-item {{ request()->is('complaint*') || request()->is('enquiry*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-comments"></i>
                                    <p>
                                        Communication
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/complaint" class="nav-link {{ request()->is('complaint*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Complaint</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/enquiry" class="nav-link {{ request()->is('enquiry*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Enquiry</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    @yield('content-header')
                </div>

                <!-- Main content -->
                <section class="content">
                    @yield('content')
                </section>
            </div>

            <!-- Footer -->
            <footer class="main-footer">
                <strong>Copyright &copy; {{ date('Y') }} Hospital Management System.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 1.0.0
                </div>
            </footer>
        </div>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap 4.5.2 JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                // Set up CSRF token for AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                // Global AJAX error handler for debugging
                $(document).ajaxError(function(event, xhr, settings, error) {
                    if (xhr.status === 419) {
                        console.error('CSRF Token Mismatch - URL:', settings.url);
                        console.error('Token in meta tag:', $('meta[name="csrf-token"]').attr('content'));
                        console.error('Session token from Laravel:', window.Laravel ? window.Laravel.csrfToken : 'Not available');
                        toastr && toastr.error('Session expired. Please refresh the page.');
                    } else {
                        console.error('AJAX Error - Status:', xhr.status, 'URL:', settings.url, 'Error:', error);
                    }
                });
                
                // Global DataTable defaults for responsiveness
                $.extend(true, $.fn.dataTable.defaults, {
                    responsive: true,
                    scrollX: true,
                    autoWidth: false,
                    columnDefs: [
                        { targets: '_all', className: 'text-center' }
                    ],
                    language: {
                        processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
                        search: 'Search:',
                        lengthMenu: 'Show _MENU_ entries per page',
                        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                        infoEmpty: 'No entries available',
                        infoFiltered: '(filtered from _MAX_ total entries)',
                        zeroRecords: 'No matching records found',
                        emptyTable: 'No data available in table'
                    }
                });
                
                // Global status toggle handler
                window.handleStatusToggle = function(element, baseUrl) {
                    var id = $(element).data('id');
                    var status = $(element).data('status');
                    var button = $(element);
                    
                    console.log('Status toggle clicked:', {
                        id: id,
                        status: status,
                        url: baseUrl + '/toggle-status/' + id,
                        token: $('meta[name="csrf-token"]').attr('content')
                    });
                    
                    button.prop('disabled', true);
                    
                    $.ajax({
                        url: baseUrl + '/toggle-status/' + id,
                        type: 'POST',
                        data: { 
                            status: status, 
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            // Reload the page's DataTable if it exists
                            if (window.currentTable) {
                                window.currentTable.ajax.reload();
                            }
                            toastr && toastr.success(res.message || 'Status updated successfully.');
                        },
                        error: function(xhr) {
                            console.error('Status toggle error:', xhr.status, xhr.responseText);
                            console.error('Response headers:', xhr.getAllResponseHeaders());
                            if (xhr.status === 419) {
                                toastr && toastr.error('Session expired. Refreshing page...');
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                var errorMessage = 'Status update failed.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                toastr && toastr.error(errorMessage);
                            }
                        },
                        complete: function() {
                            button.prop('disabled', false);
                        }
                    });
                };
                
                // Auto-expand active menu items
                var currentUrl = window.location.pathname;
                $('.nav-sidebar .nav-link').each(function() {
                    if ($(this).attr('href') && currentUrl.includes($(this).attr('href'))) {
                        $(this).closest('.nav-item').addClass('menu-open');
                        $(this).addClass('active');
                    }
                });
                
                // Initialize Select2 for all select elements
                $('select').select2({
                    theme: 'bootstrap4',
                    width: '100%'
                });
                
                // Toastr configuration
                if (typeof toastr !== 'undefined') {
                    toastr.options = {
                        closeButton: true,
                        debug: false,
                        newestOnTop: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        preventDuplicates: false,
                        onclick: null,
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut"
                    };
                }
                
                // Add fade-in animation to content
                $('.content').addClass('fade-in-up');
            });
        </script>

        @stack('scripts')
    </body>
</html>
