@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Manage Employee</h3>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-2">
                        <a href="/employee/create" class="btn btn-success">+ Create Employee</a>
                    </div>
                    <button class="btn btn-success mb-3" id="addEmployeeBtn">+ Add Employee</button>
                    <table class="table table-hover align-middle shadow-sm">
                        <thead class="table-danger">
                            <tr class="align-middle text-center">
                                <th>#</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Hospital</th>
                                <th>Salary</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $index => $employee)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($employee->photo)
                                        <img src="{{ asset('storage/' . $employee->photo) }}" alt="Photo" width="40" height="40" class="rounded-circle border">
                                    @else
                                        <span class="badge bg-secondary">No Photo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $employee->name }}</div>
                                    <div class="text-muted small">{{ $employee->position }}</div>
                                </td>
                                <td>{{ $employee->department }}</td>
                                <td>{{ $employee->mobile_no }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->hospital->name ?? '-' }}</td>
                                <td><span class="badge bg-success">{{ $employee->salary }}</span></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info me-1 view-employee-btn" data-id="{{ $employee->id }}" title="View"><i class="fa fa-eye"></i></button>
                                    <button type="button" class="btn btn-sm btn-primary me-1 edit-employee-btn" data-id="{{ $employee->id }}" title="Edit"><i class="fa fa-edit"></i></button>
<!-- Employee Form Modal -->
<div class="modal fade" id="employeeFormModal" tabindex="-1" aria-labelledby="employeeFormModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="employeeFormModalLabel">Employee Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="employeeFormModalBody">
        <!-- Form will be loaded here via AJAX -->
      </div>
    </div>
  </div>
</div>
                                    <form action="{{ route('employee.destroy', $employee->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Employee View Modal -->
<div class="modal fade" id="employeeViewModal" tabindex="-1" aria-labelledby="employeeViewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="employeeViewModalLabel">Employee Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-3 text-center mb-3">
            <img id="emp-photo" src="" alt="Photo" class="img-thumbnail rounded-circle mb-2" style="width:100px;height:100px;object-fit:cover;">
            <div id="emp-name" class="fw-bold fs-5"></div>
            <div id="emp-position" class="text-muted"></div>
          </div>
          <div class="col-md-9">
            <table class="table table-bordered table-sm">
              <tbody>
                <tr><th>Department</th><td id="emp-department"></td><th>Hospital</th><td id="emp-hospital"></td></tr>
                <tr><th>Mobile</th><td id="emp-mobile_no"></td><th>Email</th><td id="emp-email"></td></tr>
                <tr><th>Phone</th><td id="emp-phone"></td><th>Alternate Mobile</th><td id="emp-alternate_mobile_no"></td></tr>
                <tr><th>Address</th><td id="emp-current_address"></td><th>Permanent Address</th><td id="emp-permanent_address"></td></tr>
                <tr><th>Gender</th><td id="emp-gender"></td><th>DOB</th><td id="emp-dob"></td></tr>
                <tr><th>Marital Status</th><td id="emp-marital_status"></td><th>Blood Group</th><td id="emp-blood_group"></td></tr>
                <tr><th>Education</th><td id="emp-education"></td><th>Experience Year</th><td id="emp-experience_year"></td></tr>
                <tr><th>Joining Date</th><td id="emp-joining_date"></td><th>Leaving Date</th><td id="emp-leaving_date"></td></tr>
                <tr><th>Role</th><td id="emp-role"></td><th>Salary</th><td id="emp-salary"></td></tr>
                <tr><th>Bank Name</th><td id="emp-bank_name"></td><th>Branch Name</th><td id="emp-branch_name"></td></tr>
                <tr><th>Account No</th><td id="emp-account_no"></td><th>Account Holder</th><td id="emp-account_holder_name"></td></tr>
                <tr><th>IFSC Code</th><td id="emp-ifsc_code"></td><th>Opening Balance</th><td id="emp-opening_balance"></td></tr>
                <tr><th>Aadhar No</th><td id="emp-aadhar_no"></td><th>PAN No</th><td id="emp-pan_no"></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // View Modal AJAX
    $('.view-employee-btn').on('click', function() {
        var id = $(this).data('id');
        $.get('/employee/' + id, function(emp) {
            // Set photo
            if(emp.photo) {
                $('#emp-photo').attr('src', '/storage/' + emp.photo);
            } else {
                $('#emp-photo').attr('src', 'https://ui-avatars.com/api/?name=' + encodeURIComponent(emp.name));
            }
            $('#emp-name').text(emp.name || '');
            $('#emp-position').text(emp.position || '');
            $('#emp-department').text(emp.department || '');
            $('#emp-hospital').text(emp.hospital ? emp.hospital.name : (emp.hospital_id || ''));
            $('#emp-mobile_no').text(emp.mobile_no || '');
            $('#emp-email').text(emp.email || '');
            $('#emp-phone').text(emp.phone || '');
            $('#emp-alternate_mobile_no').text(emp.alternate_mobile_no || '');
            $('#emp-current_address').text(emp.current_address || '');
            $('#emp-permanent_address').text(emp.permanent_address || '');
            $('#emp-gender').text(emp.gender || '');
            $('#emp-dob').text(emp.dob || '');
            $('#emp-marital_status').text(emp.marital_status || '');
            $('#emp-blood_group').text(emp.blood_group || '');
            $('#emp-education').text(emp.education || '');
            $('#emp-experience_year').text(emp.experience_year || '');
            $('#emp-joining_date').text(emp.joining_date || '');
            $('#emp-leaving_date').text(emp.leaving_date || '');
            $('#emp-role').text(emp.role || '');
            $('#emp-salary').text(emp.salary || '');
            $('#emp-bank_name').text(emp.bank_name || '');
            $('#emp-branch_name').text(emp.branch_name || '');
            $('#emp-account_no').text(emp.account_no || '');
            $('#emp-account_holder_name').text(emp.account_holder_name || '');
            $('#emp-ifsc_code').text(emp.ifsc_code || '');
            $('#emp-opening_balance').text(emp.opening_balance || '');
            $('#emp-aadhar_no').text(emp.aadhar_no || '');
            $('#emp-pan_no').text(emp.pan_no || '');
            var modal = new bootstrap.Modal(document.getElementById('employeeViewModal'));
            modal.show();
        });
    });

    // Add Employee Modal
    $('#addEmployeeBtn').on('click', function() {
        $.get('/employee/create', function(html) {
            $('#employeeFormModalLabel').text('Add Employee');
            $('#employeeFormModalBody').html($(html).find('form').parent().html());
            var modal = new bootstrap.Modal(document.getElementById('employeeFormModal'));
            modal.show();
        });
    });

    // Edit Employee Modal
    $('.edit-employee-btn').on('click', function() {
        var id = $(this).data('id');
        $.get('/employee/edit/' + id, function(html) {
            $('#employeeFormModalLabel').text('Edit Employee');
            $('#employeeFormModalBody').html($(html).find('form').parent().html());
            var modal = new bootstrap.Modal(document.getElementById('employeeFormModal'));
            modal.show();
        });
    });
});
</script>
@endsection
@endsection
