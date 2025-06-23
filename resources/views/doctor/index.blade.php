@extends('layouts.app')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 fw-bold">
                    <i class="fas fa-user-md text-primary me-2"></i>
                    Doctor Management
                </h1>
                <p class="text-muted">Manage hospital doctors and medical staff</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Doctors</li>
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
                                <i class="fas fa-list me-2"></i>Doctor Directory
                            </h5>
                        </div>
                        <button class="btn btn-primary btn-lg" id="addDoctorBtn">
                            <i class="fas fa-plus me-2"></i>Add New Doctor
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Doctors Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h6 class="mb-0 text-dark">
                <i class="fas fa-table me-2"></i>Doctor Records
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="doctorTable" style="width:100%">
                    <thead class="table-primary">
                        <tr>
                            <th>S.No.</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Doctor ID</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Qualification</th>
                            <th>Experience</th>
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

<!-- Doctor Modal -->
<div class="modal fade" id="doctorModal" tabindex="-1" role="dialog" aria-labelledby="doctorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <form id="doctorForm" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" id="doctorId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="doctorModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-3">
              <label>Doctor Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Doctor ID <span class="text-danger">*</span></label>
              <input type="text" name="doctor_id" id="doctor_id" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Mobile Number <span class="text-danger">*</span></label>
              <input type="text" name="mobile" id="mobile" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Email</label>
              <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Date Of Birth</label>
              <input type="date" name="dob" id="dob" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Gender <span class="text-danger">*</span></label>
              <select name="gender" id="gender" class="form-control" required>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Qualification <span class="text-danger">*</span></label>
              <input type="text" name="qualification" id="qualification" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Experience (Years)</label>
              <input type="text" name="experience" id="experience" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Joining Date</label>
              <input type="date" name="joining_date" id="joining_date" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Address <span class="text-danger">*</span></label>
              <input type="text" name="address" id="address" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Aadhar Number</label>
              <input type="text" name="aadhar_no" id="aadhar_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Pan Number</label>
              <input type="text" name="pan_no" id="pan_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Bank Name</label>
              <input type="text" name="bank_name" id="bank_name" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Account Number</label>
              <input type="text" name="account_no" id="account_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>IFSC Code</label>
              <input type="text" name="ifsc_code" id="ifsc_code" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Opening Balance</label>
              <input type="number" name="opening_balance" id="opening_balance" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Status</label>
              <select name="status" id="status" class="form-control">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Doctor Photo</label>
              <input type="file" name="photo" class="form-control">
              <img id="photoPreview" src="" style="max-height:40px; margin-top:5px;">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewDoctorModal" tabindex="-1" role="dialog" aria-labelledby="viewDoctorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <form>
      <input type="hidden" id="viewDoctorId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewDoctorModalLabel">View Doctor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-3">
              <label>Doctor Name</label>
              <input type="text" id="view_name" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Doctor ID</label>
              <input type="text" id="view_doctor_id" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Mobile Number</label>
              <input type="text" id="view_mobile" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Email</label>
              <input type="text" id="view_email" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Date Of Birth</label>
              <input type="text" id="view_dob" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Gender</label>
              <input type="text" id="view_gender" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Qualification</label>
              <input type="text" id="view_qualification" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Experience</label>
              <input type="text" id="view_experience" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Joining Date</label>
              <input type="text" id="view_joining_date" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Address</label>
              <input type="text" id="view_address" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Aadhar Number</label>
              <input type="text" id="view_aadhar_no" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Pan Number</label>
              <input type="text" id="view_pan_no" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Bank Name</label>
              <input type="text" id="view_bank_name" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Account Number</label>
              <input type="text" id="view_account_no" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>IFSC Code</label>
              <input type="text" id="view_ifsc_code" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Opening Balance</label>
              <input type="text" id="view_opening_balance" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Status</label>
              <input type="text" id="view_status" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Doctor Photo</label>
              <img id="view_photoPreview" src="" style="max-height:100px; margin-top:5px;">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>
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
            toastr.error('Your session has expired. The page will be refreshed to continue.');
            setTimeout(() => location.reload(), 2000);
        }
    });    table = $('#doctorTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/doctor',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { 
                data: 'photo', 
                name: 'photo', 
                orderable: false,
                searchable: false
            },
            { data: 'name', name: 'name' },
            { data: 'doctor_id', name: 'doctor_id' },
            { data: 'mobile', name: 'mobile' },
            { data: 'email', name: 'email' },
            { data: 'qualification', name: 'qualification' },
            { data: 'experience', name: 'experience' },
            { data: 'address', name: 'address' },
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
            emptyTable: 'No doctors found',
            zeroRecords: 'No matching doctors found'
        }
    });

    // Add Doctor Button
    $('#addDoctorBtn').click(function(){
        $('#doctorForm')[0].reset();
        $('#doctorId').val('');
        $('#photoPreview').attr('src', '').hide();
        $('#doctorModalLabel').text('Add Doctor');
        $('#doctorModal').modal('show');
        toastr.info('Adding new doctor');
    });    // Edit Doctor
    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');
        toastr.info('Loading doctor data...');
        $.get('/doctor/' + id)
        .done(function(doctor){
            $('#doctorId').val(doctor.id || '');
            if(doctor.photo) {
                $('#photoPreview').attr('src', '/storage/doctor_photos/' + doctor.photo).show();
            } else {
                $('#photoPreview').attr('src', '').hide();
            }
            $('#name').val(doctor.name || '');
            $('#doctor_id').val(doctor.doctor_id || '');
            $('#mobile').val(doctor.mobile || '');
            $('#email').val(doctor.email || '');
            $('#dob').val(doctor.dob || '');
            $('#gender').val(doctor.gender || '');
            $('#qualification').val(doctor.qualification || '');
            $('#experience').val(doctor.experience || '');
            $('#joining_date').val(doctor.joining_date || '');
            $('#address').val(doctor.address || '');
            $('#aadhar_no').val(doctor.aadhar_no || '');
            $('#pan_no').val(doctor.pan_no || '');
            $('#bank_name').val(doctor.bank_name || '');
            $('#account_no').val(doctor.account_no || '');
            $('#ifsc_code').val(doctor.ifsc_code || '');
            $('#opening_balance').val(doctor.opening_balance || '');
            $('#status').val(doctor.status || 'Active');
            $('#doctorModalLabel').text('Edit Doctor');
            $('#doctorModal').modal('show');
            toastr.success('Doctor data loaded successfully!');
        })
        .fail(function(){
            toastr.error('Failed to load doctor data. Please try again.');
        });
    });    // View Doctor
    $(document).on('click', '.viewBtn', function(){
        let id = $(this).data('id');
        toastr.info('Loading doctor details...');
        $.get('/doctor/' + id)
        .done(function(doctor){
            $('#viewDoctorId').val(doctor.id);
            if(doctor.photo) {
                $('#view_photoPreview').attr('src', '/storage/doctor_photos/' + doctor.photo).show();
            } else {
                $('#view_photoPreview').attr('src', '').hide();
            }
            $('#view_name').val(doctor.name);
            $('#view_doctor_id').val(doctor.doctor_id);
            $('#view_mobile').val(doctor.mobile);
            $('#view_email').val(doctor.email);
            $('#view_dob').val(doctor.dob);
            $('#view_gender').val(doctor.gender);
            $('#view_qualification').val(doctor.qualification);
            $('#view_experience').val(doctor.experience);
            $('#view_joining_date').val(doctor.joining_date);
            $('#view_address').val(doctor.address);
            $('#view_aadhar_no').val(doctor.aadhar_no);
            $('#view_pan_no').val(doctor.pan_no);
            $('#view_bank_name').val(doctor.bank_name);
            $('#view_account_no').val(doctor.account_no);
            $('#view_ifsc_code').val(doctor.ifsc_code);
            $('#view_opening_balance').val(doctor.opening_balance);
            $('#view_status').val(doctor.status);
            $('#viewDoctorModal').modal('show');
            toastr.success('Doctor details loaded successfully!');
        })
        .fail(function(){
            toastr.error('Failed to load doctor data. Please try again.');
        });
    });    // Delete Doctor
    $(document).on('click', '.deleteBtn', function(){
        toastr.warning('Are you sure you want to delete this doctor?<br><br><button type="button" class="btn btn-sm btn-light" onclick="toastr.clear()">Cancel</button>&nbsp;<button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteDoctor(' + $(this).data('id') + ')">Delete</button>', 'Confirm Delete', {
            allowHtml: true,
            closeButton: false,
            timeOut: 0,
            extendedTimeOut: 0
        });
    });

    // Confirm delete doctor function
    function confirmDeleteDoctor(id) {
        toastr.clear();
        toastr.info('Deleting doctor...');
        $.ajax({
            url: '/doctor/' + id,
            type: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response){
                table.ajax.reload();
                toastr.success(response.message || 'Doctor deleted successfully!');
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Delete failed.');
            }
        });
    }

    // Toggle Status
    $('#doctorTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let status = $(this).data('status');
        let $this = $(this);
        
        toastr.info('Updating doctor status...');        $.ajax({
            url: `/doctor/toggle-status/${id}`,
            type: 'POST',
            data: {
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                table.ajax.reload();
                toastr.success(response.message || 'Doctor status updated successfully!');
            },
            error: function(xhr) {
                console.error('Status toggle error:', xhr.status, xhr.responseText);
                if (xhr.status === 419) {
                    toastr.error('Your session has expired. The page will be refreshed to continue.');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Status update failed.');
                }
            }
        });
    });

    // Form Submission
    $('#doctorForm').submit(function(e){
        e.preventDefault();
        let id = $('#doctorId').val();
        let url = id ? '/doctor/' + id : '/doctor';
        let type = 'POST';
        let formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');
        
        toastr.info('Saving doctor data...');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response){
                $('#doctorModal').modal('hide');
                table.ajax.reload();
                toastr.success(response.message || 'Doctor saved successfully!');
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errorMessages = [];
                    for (const key in xhr.responseJSON.errors) {
                        errorMessages.push(xhr.responseJSON.errors[key].join(' '));
                    }
                    toastr.error(errorMessages.join('<br>'));
                } else {
                    toastr.error(xhr.responseJSON?.message || 'An error occurred.');
                }
            }
        });
    });

    // Reset Button
    $(document).on('click', '#resetButton', function(){
        $('#doctorForm')[0].reset();
        $('#photoPreview').attr('src', '').hide();
        $('#doctorId').val('');
        toastr.info('Form reset successfully!');
    });

    // Photo Preview
    $(document).on('change', 'input[name="photo"]', function() {
        let input = this;
        let preview = $('#photoPreview');
        
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result).show();
                toastr.success('Photo uploaded successfully!');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.attr('src', '').hide();
        }
    });
});
</script>
@endpush
