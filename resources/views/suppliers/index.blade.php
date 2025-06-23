@extends('layouts.app')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 fw-bold">
                    <i class="fas fa-truck text-primary me-2"></i>
                    Supplier Management
                </h1>
                <p class="text-muted">Manage hospital suppliers and vendors</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Suppliers</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Action Bar -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-list me-2"></i>Supplier Directory
                            </h5>
                        </div>
                        <button class="btn btn-primary btn-lg" id="addSupplierBtn">
                            <i class="fas fa-plus me-2"></i>Add New Supplier
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Suppliers Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h6 class="mb-0 text-dark">
                <i class="fas fa-table me-2"></i>Supplier Records
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="supplierTable" style="width:100%">
                    <thead class="table-primary">
                        <tr>
                            <th>S.No.</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Contact No</th>
                            <th>Email</th>
                            <th>DOB</th>
                            <th>Qualification</th>
                            <th>Address</th>
                            <th>Opening Balance</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@include('suppliers.modal')
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css"/>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
<script>
let table;
$(function() {
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
    });

    table = $('#supplierTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/suppliers',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'photo', name: 'photo', orderable: false },
            { data: 'name', name: 'name' },
            { data: 'contact_no', name: 'contact_no' },
            { data: 'email', name: 'email' },
            { data: 'dob', name: 'dob' },
            { data: 'qualification', name: 'qualification' },
            { data: 'address', name: 'address' },
            { data: 'opening_balance', name: 'opening_balance' },
            { 
                data: 'status', 
                name: 'status', 
                render: function(data, type, row){
                    let icon = data === 'Active' ? 'fa-eye text-success' : 'fa-eye-slash text-warning';
                    let nextStatus = data === 'Active' ? 'Inactive' : 'Active';
                    return `<a href="#" class="toggleStatus" data-id="${row.id}" data-status="${nextStatus}" title="Click to toggle status">
                                <i class="fas ${icon}"></i>
                            </a>`;
                }
            },
            { 
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row){
                    return `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-info editBtn" data-id="${row.id}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary viewBtn" data-id="${row.id}" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${row.id}" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn-success'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn-danger'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn-info'
            },
            {
                extend: 'colvis',
                text: '<i class="fas fa-columns"></i> Columns',
                className: 'btn-secondary'
            }
        ],
        responsive: true,
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
            emptyTable: 'No suppliers found',
            zeroRecords: 'No matching suppliers found'
        }
    });

    // Add Supplier Button
    $('#addSupplierBtn').click(function(){
        $('#supplierForm')[0].reset();
        $('#supplierId').val('');
        $('#photoPreview').attr('src', '').hide();
        $('#supplierModalLabel').text('Add Supplier');
        $('#supplierModal').modal('show');
    });

    // Edit Supplier
    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');
        $.get('/suppliers/' + id)
        .done(function(supplier){
            $('#supplierId').val(supplier.id || '');
            if(supplier.photo) {
                $('#photoPreview').attr('src', '/storage/supplier_photos/' + supplier.photo).show();
            } else {
                $('#photoPreview').attr('src', '').hide();
            }
            $('#name').val(supplier.name || '');
            $('#gender').val(supplier.gender || '');
            $('#contact_no').val(supplier.contact_no || '');
            $('#email').val(supplier.email || '');
            $('#dob').val(supplier.dob || '');
            $('#qualification').val(supplier.qualification || '');
            $('#address').val(supplier.address || '');
            $('#pan_no').val(supplier.pan_no || '');
            $('#aadhar_no').val(supplier.aadhar_no || '');
            $('#bank_name').val(supplier.bank_name || '');
            $('#account_no').val(supplier.account_no || '');
            $('#account_holder_name').val(supplier.account_holder_name || '');
            $('#ifsc_code').val(supplier.ifsc_code || '');
            $('#opening_balance').val(supplier.opening_balance || '');
            $('#status').val(supplier.status || 'Active');
            $('#supplierModalLabel').text('Edit Supplier');
            $('#supplierModal').modal('show');
        })
        .fail(function(){
            alert('Failed to load supplier data. Please try again.');
        });
    });

    // View Supplier
    $(document).on('click', '.viewBtn', function(){
        let id = $(this).data('id');
        $.get('/suppliers/' + id)
        .done(function(supplier){
            $('#viewSupplierId').val(supplier.id);
            if(supplier.photo) {
                $('#view_photoPreview').attr('src', '/storage/supplier_photos/' + supplier.photo).show();
            } else {
                $('#view_photoPreview').attr('src', '').hide();
            }
            $('#view_name').val(supplier.name);
            $('#view_gender').val(supplier.gender);
            $('#view_contact_no').val(supplier.contact_no);
            $('#view_email').val(supplier.email);
            $('#view_dob').val(supplier.dob);
            $('#view_qualification').val(supplier.qualification);
            $('#view_address').val(supplier.address);
            $('#view_pan_no').val(supplier.pan_no);
            $('#view_aadhar_no').val(supplier.aadhar_no);
            $('#view_bank_name').val(supplier.bank_name);
            $('#view_account_no').val(supplier.account_no);
            $('#view_account_holder_name').val(supplier.account_holder_name);
            $('#view_ifsc_code').val(supplier.ifsc_code);
            $('#view_opening_balance').val(supplier.opening_balance);
            $('#view_status').val(supplier.status);
            $('#viewSupplierModal').modal('show');
        })
        .fail(function(){
            alert('Failed to load supplier data. Please try again.');
        });
    });

    // Delete Supplier
    $(document).on('click', '.deleteBtn', function(){
        if(confirm('Are you sure you want to delete this supplier?')){
            let id = $(this).data('id');
            $.ajax({
                url: '/suppliers/' + id,
                type: 'DELETE',
                success: function(response){
                    table.ajax.reload();
                    if(typeof toastr !== 'undefined') {
                        toastr.success(response.message || 'Supplier deleted successfully!');
                    }
                },
                error: function(xhr) {
                    if (xhr.status !== 419) {
                        let message = xhr.responseJSON?.message || 'An error occurred while deleting.';
                        alert('Error: ' + message);
                    }
                }
            });
        }
    });

    // Toggle Status
    $(document).on('click', '.toggleStatus', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        let status = $(this).data('status');
        
        $.ajax({
            url: `/suppliers/${id}`,
            type: 'PUT',
            data: { 
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                table.ajax.reload();
                if(typeof toastr !== 'undefined') {
                    toastr.success(`Supplier status updated to ${status}`);
                }
            },
            error: function(xhr) {
                if (xhr.status !== 419) {
                    console.error('Status update error:', xhr.responseJSON?.message || 'An error occurred during status update.');
                }
            }
        });
    });

    // Form Submission
    $('#supplierForm').submit(function(e){
        e.preventDefault();
        let id = $('#supplierId').val();
        let url = id ? '/suppliers/' + id : '/suppliers';
        let type = 'POST';
        let formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');
        
        $.ajax({
            url: url,
            type: type,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                $('#supplierModal').modal('hide');
                table.ajax.reload();
                if(typeof toastr !== 'undefined') {
                    toastr.success(response.message || 'Supplier saved successfully!');
                } else {
                    alert(response.message || 'Supplier saved successfully!');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let msg = 'Please correct the following errors:\n';
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        msg += `• ${value.join(', ')}\n`;
                    });
                    alert(msg);
                } else if (xhr.status !== 419) {
                    let msg = xhr.responseJSON?.message || 'An unexpected error occurred.';
                    alert('Error: ' + msg);
                }
            }
        });
    });

    // Reset Button
    $(document).on('click', '#resetButton', function(){
        $('#supplierForm')[0].reset();
        $('#photoPreview').attr('src', '').hide();
        $('#supplierId').val('');
    });

    // Photo Preview
    $(document).on('change', 'input[name="photo"]', function() {
        let input = this;
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#photoPreview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#photoPreview').attr('src', '').hide();
        }
    });
});
</script>
@endpush