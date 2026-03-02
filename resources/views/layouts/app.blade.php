<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <style>
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
            
            .breadcrumb a {
                color: var(--primary-color);
                text-decoration: none;
            }
            
            .breadcrumb a:hover {
                text-decoration: underline;
            }
            
            /* Enhanced Action Bars */
            .action-bar {
                background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
                border-radius: 12px;
                border: 1px solid rgba(0,0,0,0.05);
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            }
            
            /* Enhanced Filter Sections */
            .filter-section {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                border-radius: 12px;
                border: 1px solid rgba(0,0,0,0.05);
            }
            
            /* Enhanced Tables */
            .table-primary th {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%) !important;
                color: white !important;
                border: none !important;
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.85rem;
                letter-spacing: 0.5px;
                padding: 12px 8px;
            }
            
            .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(0,123,255,0.02);
            }
            
            .table tbody tr {
                transition: all 0.2s ease;
                border-color: rgba(0,0,0,0.05);
            }
            
            .table tbody tr:hover {
                background-color: rgba(0,123,255,0.08) !important;
                transform: scale(1.005);
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }
            
            /* Enhanced Action Buttons */
            .btn-action {
                width: 32px;
                height: 32px;
                border-radius: 6px;
                padding: 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin: 0 2px;
                transition: all 0.2s ease;
            }
            
            .btn-action:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            }
            
            /* Status Badges */
            .badge {
                border-radius: 12px;
                font-weight: 500;
                font-size: 0.75rem;
                padding: 6px 12px;
            }
            
            /* Enhanced Form Elements */
            .form-label {
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 6px;
            }
            
            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15);
                transform: translateY(-1px);
            }
            
            .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15);
            }
            
            /* Loading States */
            .loading {
                position: relative;
                overflow: hidden;
            }
            
            .loading::after {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
                animation: loading 1.5s infinite;
            }
            
            @keyframes loading {
                0% { left: -100%; }
                100% { left: 100%; }
            }
            
            /* Responsive Enhancements */
            @media (max-width: 768px) {
                .card-body {
                    padding: 15px;
                }
                
                .table-responsive {
                    border-radius: 8px;
                }
                
                .btn-lg {
                    padding: 10px 20px;
                    font-size: 0.9rem;
                }
                
                .dashboard-card .card-body {
                    padding: 15px;
                }
                  .dashboard-card h3 {
                    font-size: 1.5rem;
                }
            }
        </style>
        
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap 4.5.2 CSS (required for AdminLTE 3) -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- AdminLTE 3, FontAwesome 5 via CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css"/>
        <!-- Toastr CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <!-- Custom Styles -->
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
            }
            

            /* Bootstrap 5 utility compatibility in Bootstrap 4 pages */
            .me-1 { margin-right: 0.25rem !important; }
            .me-2 { margin-right: 0.5rem !important; }
            .ms-1 { margin-left: 0.25rem !important; }
            .ms-2 { margin-left: 0.5rem !important; }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f4f6f9;
            }
            
            .navbar-text {
                color: #495057 !important;
                margin-right: 1rem;
                font-weight: 500;
            }
            
            /* Sidebar Styling */
            .main-sidebar {
                background: linear-gradient(180deg, #343a40 0%, #23272b 100%);
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }
            
            .main-sidebar .nav-link {
                color: rgba(255,255,255,.8);
                border-radius: 8px;
                margin: 2px 8px;
                transition: all 0.3s ease;
            }
            
            .main-sidebar .nav-link:hover {
                color: #fff;
                background-color: rgba(255,255,255,.1);
                transform: translateX(3px);
            }
            
            .main-sidebar .nav-link.active {
                color: #fff;
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
                box-shadow: 0 4px 8px rgba(0,123,255,0.3);
            }
            
            .nav-treeview .nav-link {
                margin-left: 20px;
                font-size: 0.9em;
            }
            
            .nav-treeview .nav-link.active {
                background: linear-gradient(135deg, rgba(255,255,255,.9) 0%, rgba(248,249,250,.9) 100%);
                color: var(--dark-color);
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            
            /* Card Enhancements */
            .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.08);
                transition: all 0.3s ease;
            }
            
            .card:hover {
                box-shadow: 0 4px 20px rgba(0,0,0,0.12);
            }
            
            .card-header {
                background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
                border-bottom: 1px solid rgba(0,0,0,0.05);
                font-weight: 600;
            }
            
            /* Dashboard Cards */
            .dashboard-card {
                transition: all 0.3s ease;
                border-radius: 12px !important;
                overflow: hidden;
                position: relative;
            }
            
            .dashboard-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
                pointer-events: none;
            }
            
            .dashboard-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
            }
            
            /* Buttons */
            .btn {
                border-radius: 8px;
                font-weight: 500;
                transition: all 0.2s ease;
            }
            
            .btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            }
            
            /* Tables */
            .table {
                border-radius: 8px;
                overflow: hidden;
            }
            
            .table thead th {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
                border: none;
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.85em;
                letter-spacing: 0.5px;
            }
            
            .table tbody tr {
                transition: all 0.2s ease;
            }
            
            .table tbody tr:hover {
                background-color: rgba(0,123,255,0.05);
                transform: scale(1.01);
            }
            
            /* Forms */
            .form-control {
                border-radius: 8px;
                border: 2px solid #e9ecef;
                transition: all 0.3s ease;
            }
            
            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
            }
            
            /* Modals */
            .modal-content {
                border-radius: 12px;
                border: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            }
            
            .modal-header {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
                color: white;
                border-radius: 12px 12px 0 0;
            }
            
            /* Content wrapper */
            .content-wrapper {
                background: linear-gradient(135deg, #f4f6f9 0%, #e9ecef 100%);
                min-height: calc(100vh - 57px);
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
            
            /* Progress bars */
            .progress {
                border-radius: 8px;
                height: 8px;
            }
            
            .progress-bar {
                border-radius: 8px;
            }
            
            /* Badges */
            .badge {
                border-radius: 6px;
                font-weight: 500;
            }
            
            /* DataTables enhancements */
            .dataTables_wrapper .dataTables_length select,
            .dataTables_wrapper .dataTables_filter input {
                border-radius: 6px;
                border: 1px solid #ddd;
            }
            
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                border-radius: 6px !important;
                margin: 0 2px;
            }
            
            /* Alert enhancements */
            .alert {
                border-radius: 8px;
                border: none;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }
            
            /* Navbar enhancements */
            .main-header {
                box-shadow: 0 2px 4px rgba(0,0,0,0.04);
                border-bottom: 1px solid rgba(0,0,0,0.05);
            }
            
            /* Brand link */
            .brand-link {
                background: linear-gradient(135deg, #343a40 0%, #23272b 100%);
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }
            
            /* Responsive improvements */
            @media (max-width: 768px) {
                .card-body {
                    padding: 1rem;
                }
                
                .dashboard-card .card-body {
                    padding: 0.75rem;
                }
                
                .h3, h3 {
                    font-size: 1.5rem;
                }
            }
        </style>
        @stack('styles')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            @include('includes.navbar')
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            @include('includes.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                @yield('content-header')
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            <footer class="main-footer text-center">
                <strong>&copy; {{ date('Y') }} {{ config('app.name') }}.</strong> All rights reserved.
            </footer>
        </div>
        
        <!-- Toast Notification Container -->
        <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
            <div class="toast-container"></div>
        </div>
        
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
        <!-- Bootstrap 4.5.2 JS (bundle includes Popper) -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE 3 JS -->
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <!-- Custom Scripts -->
        <script>
            $(document).ready(function() {
                // Initialize AdminLTE tree view
                if ($.fn.Treeview) { $('[data-widget="treeview"]').Treeview('init'); }
                
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
                $('.nav-link.active').closest('.has-treeview').addClass('menu-open');
                $('.nav-link.active').closest('.has-treeview').children('a').addClass('active');
                
                // Global toast notification function
                window.showToast = function(message, type = 'success') {
                    const toastHtml = `
                        <div class="toast align-items-center text-white bg-${type}" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="fas fa-${type === 'success' ? 'check-circle' : (type === 'danger' ? 'exclamation-circle' : 'info-circle')} mr-2"></i>
                                    ${message}
                                </div>
                                <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                        </div>
                    `;
                    $('.toast-container').append(toastHtml);
                    $('.toast-container .toast').last().toast('show');
                    
                    // Auto remove after showing
                    setTimeout(() => {
                        $('.toast-container .toast').first().remove();
                    }, 5000);
                };
                
                // Global loading state function
                window.showLoading = function(element) {
                    $(element).addClass('loading').prop('disabled', true);
                };
                
                window.hideLoading = function(element) {
                    $(element).removeClass('loading').prop('disabled', false);
                };
                
                // Enhanced DataTable defaults
                $.extend(true, $.fn.dataTable.defaults, {
                    responsive: true,
                    pageLength: 25,
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>' +
                         '<"row"<"col-sm-12"tr>>' +
                         '<"row"<"col-sm-5"i><"col-sm-7"p>>',
                    language: {
                        search: "Search records:",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "No entries found",
                        infoFiltered: "(filtered from _MAX_ total entries)",
                        emptyTable: "No data available in table",
                        loadingRecords: "Loading...",
                        processing: "Processing...",
                        zeroRecords: "No matching records found"
                    }
                });
            });
        </script>
        @stack('scripts')
    </body>
</html>
