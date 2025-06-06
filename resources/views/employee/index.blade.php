@extends('layouts.app')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Manage Employee</h1>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Manage Employee</h3>
            <button class="btn btn-primary btn-sm" id="addEmployeeBtn"><i class="fas fa-plus"></i> Create Employee</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="employeeTable" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>S.No.</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>EmployeeId</th>
                            <th>Department</th>
                            <th>Address</th>
                            <th>Mobile No</th>
                            <th>Pan No</th>
                            <th>Account No</th>
                            <th>Ifsc Code</th>
                            <th>Opening Bal</th>
                            <th>Status</th>
                            <th>Action</th>
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
    table = $('#employeeTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/employee',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'photo', name: 'photo', render: function(data){ return data ? `<img src="/storage/employee_photos/${data}" height="40">` : ''; } },
            { data: 'name', name: 'name' },
            { data: 'employee_id', name: 'employee_id' },
            { data: 'department', name: 'department' },
            { data: 'current_address', name: 'current_address' },
            { data: 'mobile_no', name: 'mobile_no' },
            { data: 'pan_no', name: 'pan_no' },
            { data: 'account_no', name: 'account_no' },
            { data: 'ifsc_code', name: 'ifsc_code' },
            { data: 'opening_balance', name: 'opening_balance' },
            { data: 'status', name: 'status', render: function(data, type, row){
                let icon = data === 'Active' ? 'fa-eye text-info' : 'fa-eye-slash text-warning';
                let nextStatus = data === 'Active' ? 'Inactive' : 'Active';
                return `<a href="#" class="toggleStatus" data-id="${row.id}" data-status="${nextStatus}"><i class="fas ${icon}"></i></a>`;
            } },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print', 'colvis']
    });

    $('#addEmployeeBtn').click(function(){
        $('#employeeForm')[0].reset();
        $('#employeeId').val('');
        $('#photoPreview').attr('src', '');
        $('#employeeModalLabel').text('Add Employee');
        $('#employeeModal').modal('show');
    });

    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');
        $.get('/employee/' + id, function(employee){
            $('#employeeId').val(employee.id || '');
            $('#photoPreview').attr('src', employee.photo ? '/storage/employee_photos/' + employee.photo : '');
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
        });
    });

    $(document).on('click', '.viewBtn', function(){
        let id = $(this).data('id');
        $.get('/employee/' + id, function(employee){
            $('#viewEmployeeId').val(employee.id);
            $('#view_photoPreview').attr('src', employee.photo ? '/storage/employee_photos/' + employee.photo : '');
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
        });
    });

    $(document).on('click', '.deleteBtn', function(){
        if(confirm('Are you sure you want to delete this employee?')){
            let id = $(this).data('id');
            $.ajax({
                url: '/employee/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(){
                    table.ajax.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON.message || 'An error occurred.'));
                }
            });
        }
    });

    $(document).on('click', '.toggleStatus', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        let status = $(this).data('status');
        $.ajax({
            url: `/employee/${id}`,
            type: 'PUT',
            data: { status: status, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(){
                table.ajax.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON.message || 'An error occurred.'));
            }
        });
    });

    $('#employeeForm').submit(function(e){
        e.preventDefault();
        let id = $('#employeeId').val();
        let url = id ? '/employee/' + id : '/employee';
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
            success: function(){
                $('#employeeModal').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON.message || 'An error occurred.'));
            }
        });
    });
});
</script>
@endpush 