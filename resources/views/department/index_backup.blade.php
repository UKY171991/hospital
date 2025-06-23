@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-building mr-2"></i>Department Management</h1>
            <p class="text-muted">Manage hospital departments and their details</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Departments</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Form Section -->
        <div class="col-lg-4 col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus mr-2"></i>Create Department
                    </h5>
                </div>
                <div class="card-body">
                    <form id="departmentForm">
                        @csrf
                        <input type="hidden" name="id" id="departmentId">
                        <div class="form-group">
                            <label for="department"><i class="fas fa-building mr-1"></i>Department Name <span class="text-danger">*</span></label>
                            <input type="text" name="department" id="department" class="form-control" 
                                   placeholder="Enter department name" required>
                        </div>
                        <div class="form-group">
                            <label for="description"><i class="fas fa-align-left mr-1"></i>Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" 
                                      placeholder="Enter department description..."></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save mr-1"></i>Save Department
                            </button>
                            <button type="button" class="btn btn-secondary ml-2" id="resetBtn">
                                <i class="fas fa-undo mr-1"></i>Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="col-lg-8 col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list mr-2"></i>Manage Departments
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="departmentTable" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sr No</th>
                                    <th><i class="fas fa-building mr-1"></i>Department</th>
                                    <th><i class="fas fa-align-left mr-1"></i>Description</th>
                                    <th><i class="fas fa-toggle-on mr-1"></i>Status</th>
                                    <th><i class="fas fa-cogs mr-1"></i>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>
let table;
$(function() {
    console.log('Document ready - starting department page initialization...');
    console.log('jQuery version:', $.fn.jquery);
    console.log('CSRF token:', $('meta[name="csrf-token"]').attr('content'));
    
    // Global AJAX setup for CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Global AJAX error handler for session expiry
    $(document).ajaxError(function(event, xhr, settings, thrownError) {
        if (xhr.status === 419) {
            alert('Your session has expired. The page will be refreshed to continue.');
            location.reload();
        }
    });    console.log('Initializing DataTable for departments...');
    console.log('Table element found:', $('#departmentTable').length > 0);
    
    // Test AJAX endpoint before DataTable
    $.ajax({
        url: '/department',
        type: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            draw: 1,
            start: 0,
            length: 10
        },
        success: function(response) {
            console.log('Direct AJAX test successful:', response);
        },
        error: function(xhr, status, error) {
            console.error('Direct AJAX test failed:', xhr.status, error);
        }
    });    table = $('#departmentTable').DataTable({
        processing: true,
        serverSide: true,
        destroy: true, // Allow re-initialization
        ajax: {
            url: '/department',
            type: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                console.log('DataTable AJAX request starting...');
            },
            error: function(xhr, status, error) {
                console.error('DataTable AJAX Error:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText,
                    error: error
                });
                alert('Error loading data: ' + xhr.status + ' - ' + xhr.statusText);
            },
            success: function(data) {
                console.log('DataTable AJAX Success:', data);
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'department', name: 'department' },
            { data: 'description', name: 'description' },
            { 
                data: 'status', 
                name: 'status', 
                orderable: false, 
                searchable: false
            },
            { 
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            }        ],
        responsive: true,
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
            emptyTable: 'No departments found',
            zeroRecords: 'No matching departments found'
        },
        initComplete: function() {
            console.log('DataTable initialization complete');
            console.log('Number of rows:', this.api().rows().count());
        },
        drawCallback: function() {
            console.log('DataTable draw callback called');
            console.log('Visible rows:', this.api().rows({page:'current'}).count());
        }
    });$('#departmentForm').submit(function(e){
        e.preventDefault();
        let id = $('#departmentId').val();
        let url = id ? '/department/' + id : '/department';
        let type = 'POST';
        let formData = $(this).serialize();
        if (id) formData += '&_method=PUT';
        
        // Show loading state
        let submitBtn = $(this).find('button[type="submit"]');
        let originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Saving...');
        
        $.ajax({
            url: url,
            type: type,
            data: formData,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response){
                $('#departmentForm')[0].reset();
                $('#departmentId').val('');
                table.ajax.reload();
                
                // Show success notification
                showNotification('success', response.message || 'Department saved successfully!');
            },
            error: function(xhr) {
                let msg = 'Error: ';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // Laravel validation errors
                    for (const key in xhr.responseJSON.errors) {
                        msg += `\n${xhr.responseJSON.errors[key].join(' ')}`;
                    }
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg += xhr.responseJSON.message;
                } else {
                    msg += 'An error occurred.';
                }
                showNotification('error', msg);
            },
            complete: function() {
                // Restore button
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');
        let button = $(this);
        
        // Show loading state
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        $.get('/department/' + id)
        .done(function(dept){
            $('#departmentId').val(dept.id || '');
            $('#department').val(dept.department || '');
            $('#description').val(dept.description || '');
            
            // Update form title
            $('.card-title').html('<i class="fas fa-edit mr-2"></i>Edit Department');
            
            // Scroll to form
            $('html, body').animate({
                scrollTop: $("#departmentForm").offset().top - 100
            }, 500);
            
            showNotification('info', 'Department loaded for editing');
        })
        .fail(function() {
            showNotification('error', 'Failed to load department data. Please try again.');
        })
        .always(function() {
            button.prop('disabled', false).html('<i class="fas fa-edit"></i>');
        });
    });    $(document).on('click', '.deleteBtn', function() {
        let id = $(this).data('id');
        let button = $(this);
        
        // Use modern confirmation
        if(confirm('Are you sure you want to delete this department?\n\nThis action cannot be undone.')) {
            // Show loading state
            button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            
            $.ajax({
                url: '/department/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    table.ajax.reload();
                    showNotification('success', response.message || 'Department deleted successfully!');
                },
                error: function(xhr) {
                    let msg = 'Error: ';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg += xhr.responseJSON.message;
                    } else {
                        msg += 'Delete failed. Please try again.';
                    }
                    showNotification('error', msg);
                },
                complete: function() {
                    button.prop('disabled', false).html('<i class="fas fa-trash"></i>');
                }            });
        }
    });

    $(document).on('click', '.toggleStatus', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        let status = $(this).data('status');
        let button = $(this);
        let originalText = button.text();
        
        // Show loading state
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: `/department/toggle-status/${id}`,
            type: 'POST',
            data: { status: status },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response){
                table.ajax.reload();
                showNotification('success', response.message || 'Department status updated successfully!');
            },
            error: function(xhr) {
                console.error('Status toggle error:', xhr.status, xhr.responseText);
                if (xhr.status === 419) {
                    showNotification('error', 'Your session has expired. The page will be refreshed.');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    let msg = 'Error: ';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg += xhr.responseJSON.message;
                    } else {
                        msg += 'Status update failed.';
                    }
                    showNotification('error', msg);
                }
            },
            complete: function() {
                button.prop('disabled', false).text(originalText);
            }
        });
    });    $('#resetBtn').click(function() {
        $('#departmentForm')[0].reset();
        $('#departmentId').val('');
        
        // Reset form title
        $('.card-title').html('<i class="fas fa-plus mr-2"></i>Create Department');
        
        showNotification('info', 'Form reset successfully');
    });

    // Notification system
    function showNotification(type, message) {
        // Remove existing notifications
        $('.alert-notification').remove();
        
        let alertClass = 'alert-success';
        if (type === 'error') alertClass = 'alert-danger';
        if (type === 'warning') alertClass = 'alert-warning';
        if (type === 'info') alertClass = 'alert-info';
        
        let notification = `
            <div class="alert ${alertClass} alert-dismissible fade show alert-notification" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <strong>${type.charAt(0).toUpperCase() + type.slice(1)}!</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        
        $('body').append(notification);
        
        // Auto remove after 5 seconds
        setTimeout(function() {
            $('.alert-notification').fadeOut();
        }, 5000);
    }
});
</script>
@endpush