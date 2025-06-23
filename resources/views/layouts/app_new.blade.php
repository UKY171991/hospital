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
        <!-- DataTables with Bootstrap 4 styling -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
        <!-- Toastr for notifications -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <style>
            :root {
                --primary-color: #007bff;
                --secondary-color: #6c757d;
                --success-color: #28a745;
                --danger-color: #dc3545;
                --warning-color: #ffc107;
                --info-color: #17a2b8;
                --light-color: #f8f9fa;
                --dark-color: #343a40;
                --white-color: #ffffff;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f4f6f9;
                color: var(--dark-color);
            }

            /* Header Improvements */
            .main-header {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }

            .navbar-brand {
                font-weight: 700;
                font-size: 1.4rem;
                color: white !important;
            }

            /* Sidebar Improvements */
            .main-sidebar {
                background: var(--white-color);
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }

            .sidebar {
                padding-top: 1rem;
            }

            .nav-sidebar .nav-item .nav-link {
                color: var(--dark-color);
                border-radius: 8px;
                margin: 2px 8px;
                transition: all 0.3s ease;
            }

            .nav-sidebar .nav-item .nav-link:hover {
                background-color: rgba(0, 123, 255, 0.1);
                color: var(--primary-color);
            }

            .nav-sidebar .nav-item.menu-open .nav-link,
            .nav-sidebar .nav-item .nav-link.active {
                background-color: var(--primary-color);
                color: white;
            }

            /* Card Improvements */
            .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 2px 15px rgba(0,0,0,0.08);
                transition: all 0.3s ease;
                margin-bottom: 1.5rem;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 25px rgba(0,0,0,0.12);
            }

            .card-header {
                background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
                border-bottom: 1px solid rgba(0,0,0,0.05);
                border-radius: 12px 12px 0 0 !important;
                padding: 1rem 1.25rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            /* Button Improvements */
            .btn {
                border-radius: 8px;
                font-weight: 500;
                padding: 0.5rem 1rem;
                transition: all 0.3s ease;
                border: none;
            }

            .btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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
                background: linear-gradient(135deg, var(--warning-color) 0%, #e0a800 100%);
                color: var(--dark-color);
            }

            .btn-xs {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
                border-radius: 6px;
            }

            /* Table Improvements */
            .table {
                background: var(--white-color);
                border-radius: 8px;
                overflow: hidden;
            }

            .table thead th {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                border: none;
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.8rem;
                letter-spacing: 0.5px;
                padding: 1rem 0.75rem;
            }

            .table-primary thead th {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
                color: white;
            }

            .table tbody td {
                padding: 0.75rem;
                vertical-align: middle;
                border-top: 1px solid rgba(0,0,0,0.05);
            }

            .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(0,0,0,0.02);
            }

            .table-hover tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.05);
            }

            /* Form Improvements */
            .form-control {
                border: 2px solid #e9ecef;
                border-radius: 8px;
                padding: 0.75rem;
                transition: all 0.3s ease;
            }

            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }

            .form-group label {
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 0.5rem;
            }

            /* Modal Improvements */
            .modal-content {
                border: none;
                border-radius: 12px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            }

            .modal-header {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
                color: white;
                border-radius: 12px 12px 0 0;
                border-bottom: none;
            }

            .modal-header .close {
                color: white;
                opacity: 0.8;
            }

            .modal-header .close:hover {
                opacity: 1;
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

            /* Status Toggle Button Styling */
            .toggleStatus {
                min-width: 80px;
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .toggleStatus:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }

            /* Loading Spinner */
            .spinner-border-sm {
                width: 1rem;
                height: 1rem;
            }
        </style>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-dark">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                            <i class="fas fa-bars"></i>
                        </a>
                    </li>
                </ul>

                <div class="navbar-brand ml-3">
                    <i class="fas fa-hospital-alt mr-2"></i>
                    Hospital Management System
                </div>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="fas fa-user-circle fa-lg"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-item dropdown-header">{{ Auth::user()->name ?? 'User' }}</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-cogs mr-2"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" class="dropdown-item-text">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 text-left" style="text-decoration: none; color: inherit;">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-light-primary elevation-4">
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
                            
                            <li class="nav-item">
                                <a href="/doctor" class="nav-link {{ request()->is('doctor*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-md"></i>
                                    <p>Doctors</p>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="/employee" class="nav-link {{ request()->is('employee*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Employees</p>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="/patient" class="nav-link {{ request()->is('patient*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-procedures"></i>
                                    <p>Patients</p>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="/department" class="nav-link {{ request()->is('department*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-building"></i>
                                    <p>Departments</p>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="/ward" class="nav-link {{ request()->is('ward*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-bed"></i>
                                    <p>Wards</p>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="/investigation" class="nav-link {{ request()->is('investigation*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-search"></i>
                                    <p>Investigations</p>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="/balance-sheet" class="nav-link {{ request()->is('balance-sheet*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>Balance Sheet</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <!-- Content Header -->
                @hasSection('content-header')
                    <div class="content-header">
                        @yield('content-header')
                    </div>
                @endif

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
        <!-- Bootstrap 4 -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
        <!-- DataTables -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
        <!-- Toastr -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
                $('.nav-sidebar .nav-item.menu-is-opening').addClass('menu-open');
                
                // Toastr configuration
                if (typeof toastr !== 'undefined') {
                    toastr.options = {
                        closeButton: true,
                        debug: false,
                        newestOnTop: false,
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
            });
        </script>

        @stack('scripts')
    </body>
</html>
