@extends('layouts.app')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 fw-bold">
                    <i class="fas fa-users text-primary me-2"></i>
                    Employee Management
                </h1>
                <p class="text-muted">Manage hospital staff and employees</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Employees</li>
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
                                <i class="fas fa-list me-2"></i>Employee Directory
                            </h5>
                        </div>
                        <button class="btn btn-primary btn-lg" id="addEmployeeBtn">
                            <i class="fas fa-plus me-2"></i>Add New Employee
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Employees Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h6 class="mb-0 text-dark">
                <i class="fas fa-table me-2"></i>Employee Records
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="employeeTable" style="width:100%">
                    <thead class="table-primary">
                        <tr>
                            <th>S.No.</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Employee ID</th>
                            <th>Department</th>
                            <th>Address</th>
                            <th>Mobile No</th>
                            <th>PAN No</th>
                            <th>Account No</th>
                            <th>IFSC Code</th>
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
@include('employee.modal')
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

    table = $('#employeeTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/employees',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { 
                data: 'photo', 
                name: 'photo', 
                orderable: false,
                searchable: false
            },
            { data: 'name', name: 'name' },
            { data: 'employee_id', name: 'employee_id' },
            { data: 'department', name: 'department' },
            { data: 'current_address', name: 'current_address' },
            { data: 'mobile_no', name: 'mobile_no' },
            { data: 'pan_no', name: 'pan_no' },
            { data: 'account_no', name: 'account_no' },
            { data: 'ifsc_code', name: 'ifsc_code' },
            { data: 'opening_balance', name: 'opening_balance' },
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
            emptyTable: 'No employees found',
            zeroRecords: 'No matching employees found'
        }
    });

    // Add Employee Button
    $('#addEmployeeBtn').click(function(){
        $('#employeeForm')[0].reset();
        $('#employeeId').val('');
        $('#photoPreview').attr('src', '').hide();
        $('#employeeModalLabel').text('Add Employee');
        $('#employeeModal').modal('show');
    });

    // Edit Employee
    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');
        $.get('/employees/' + id)
        .done(function(employee){
            $('#employeeId').val(employee.id || '');
            if(employee.photo) {
                $('#photoPreview').attr('src', '/storage/employee_photos/' + employee.photo).show();
            } else {
                $('#photoPreview').attr('src', '').hide();
            }
            $('#name').val(employee.name || '');
            $('#employee_id').val(employee.employee_id || '');
            $('#relative_name').val(employee.relative_name || '');
            $('#mobile_no').val(employee.mobile_no || '');
            $('#alternate_mobile_no').val(employee.alternate_mobile_no || '');
            $('#email').val(employee.email || '');
            $('#dob').val(employee.dob || '');
            $('#gender').val(employee.gender || '');
            $('#aadhar_no').val(employee.aadhar_no || '');
            $('#pan_no').val(employee.pan_no || '');
            $('#current_address').val(employee.current_address || '');
            $('#permanent_address').val(employee.permanent_address || '');
            $('#marital_status').val(employee.marital_status || '');
            $('#blood_group').val(employee.blood_group || '');
            $('#education').val(employee.education || '');
            $('#joining_date').val(employee.joining_date || '');
            $('#leaving_date').val(employee.leaving_date || '');
            $('#experience_year').val(employee.experience_year || '');
            $('#role').val(employee.role || '');
            $('#department').val(employee.department || '');
            $('#bank_name').val(employee.bank_name || '');
            $('#account_no').val(employee.account_no || '');
            $('#account_holder_name').val(employee.account_holder_name || '');
            $('#ifsc_code').val(employee.ifsc_code || '');
            $('#salary_per_day').val(employee.salary_per_day || '');
            $('#opening_balance').val(employee.opening_balance || '');
            $('#status').val(employee.status || 'Active');
            $('#employeeModalLabel').text('Edit Employee');
            $('#employeeModal').modal('show');
        })
        .fail(function(){
            alert('Failed to load employee data. Please try again.');
        });
    });

    // View Employee
    $(document).on('click', '.viewBtn', function(){
        let id = $(this).data('id');
        $.get('/employees/' + id)
        .done(function(employee){
            $('#viewEmployeeId').val(employee.id);
            if(employee.photo) {
                $('#view_photoPreview').attr('src', '/storage/employee_photos/' + employee.photo).show();
            } else {
                $('#view_photoPreview').attr('src', '').hide();
            }
            $('#view_name').val(employee.name);
            $('#view_employee_id').val(employee.employee_id);
            $('#view_relative_name').val(employee.relative_name);
            $('#view_mobile_no').val(employee.mobile_no);
            $('#view_alternate_mobile_no').val(employee.alternate_mobile_no);
            $('#view_email').val(employee.email);
            $('#view_dob').val(employee.dob);
            $('#view_gender').val(employee.gender);
            $('#view_aadhar_no').val(employee.aadhar_no);
            $('#view_pan_no').val(employee.pan_no);
            $('#view_current_address').val(employee.current_address);
            $('#view_permanent_address').val(employee.permanent_address);
            $('#view_marital_status').val(employee.marital_status);
            $('#view_blood_group').val(employee.blood_group);
            $('#view_education').val(employee.education);
            $('#view_joining_date').val(employee.joining_date);
            $('#view_leaving_date').val(employee.leaving_date);
            $('#view_experience_year').val(employee.experience_year);
            $('#view_role').val(employee.role);
            $('#view_department').val(employee.department);
            $('#view_bank_name').val(employee.bank_name);
            $('#view_account_no').val(employee.account_no);
            $('#view_account_holder_name').val(employee.account_holder_name);
            $('#view_ifsc_code').val(employee.ifsc_code);
            $('#view_salary_per_day').val(employee.salary_per_day);
            $('#view_opening_balance').val(employee.opening_balance);
            $('#view_status').val(employee.status);
            $('#viewEmployeeModal').modal('show');
        })
        .fail(function(){
            alert('Failed to load employee data. Please try again.');
        });
    });

    // Delete Employee
    $(document).on('click', '.deleteBtn', function(){
        if(confirm('Are you sure you want to delete this employee?')){
            let id = $(this).data('id');
            $.ajax({
                url: '/employees/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response){
                    table.ajax.reload();
                    if(response.message) {
                        alert('Success: ' + response.message);
                    } else {
                        alert('Employee deleted successfully!');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Delete failed.'));
                }
            });
        }
    });

    // Toggle Status
    $('#employeeTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let status = $(this).data('status');
        let $this = $(this);
        
        $.ajax({
            url: `/employees/toggle-status/${id}`,
            type: 'POST',
            data: {
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                table.ajax.reload();
                if(response.message) {
                    alert('Success: ' + response.message);
                } else {
                    alert('Employee status updated successfully!');
                }
            },
            error: function(xhr) {
                console.error('Status toggle error:', xhr.status, xhr.responseText);
                if (xhr.status === 419) {
                    alert('Your session has expired. The page will be refreshed to continue.');
                    location.reload();
                } else {
                    let msg = 'Error: ';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg += xhr.responseJSON.message;
                    } else {
                        msg += 'Status update failed.';
                    }
                    alert(msg);
                }
            }
        });
    });

    // Form Submission
    $('#employeeForm').submit(function(e){
        e.preventDefault();
        let id = $('#employeeId').val();
        let url = id ? '/employees/' + id : '/employees';
        let type = 'POST';
        let formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');
        
        $.ajax({
            url: url,
            type: type,
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response){
                $('#employeeModal').modal('hide');
                table.ajax.reload();
                // Show success message
                if(response.message) {
                    alert('Success: ' + response.message);
                } else {
                    alert('Employee saved successfully!');
                }
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
                alert(msg);
            }
        });
    });

    // Reset Button
    $(document).on('click', '#resetButton', function(){
        $('#employeeForm')[0].reset();
        $('#photoPreview').attr('src', '').hide();
        $('#employeeId').val('');
    });

    // Photo Preview
    $(document).on('change', 'input[name="photo"]', function() {
        let input = this;
        let preview = $('#photoPreview');
        
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result).show();
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.attr('src', '').hide();
        }
    });
});
</script>
@endpush