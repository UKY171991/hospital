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
                            <th>S.No</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Doctor ID</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Joining Date</th>
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
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="doctorModalLabel">
          <i class="fas fa-user-md me-2"></i>Add/Update Doctor
        </h5>
        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="doctorForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="doctor_id">
        <div class="modal-body">
          <div class="row">
            <!-- Column 1: Basic Information -->
            <div class="col-md-4">
              <h6 class="text-primary border-bottom pb-2 mb-3">
                <i class="fas fa-user me-2"></i>Basic Information
              </h6>
              <div class="form-group mb-3">
                <label class="fw-semibold">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" required>
              </div>
              <div class="form-group mb-3">
                <label class="fw-semibold">Contact No <span class="text-danger">*</span></label>
                <input type="text" name="mobile" id="mobile" class="form-control" required>
              </div>
              <div class="form-group mb-3">
                <label class="fw-semibold">Email</label>
                <input type="email" name="email" id="email" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="fw-semibold">Date of Birth</label>
                <input type="date" name="dob" id="dob" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="fw-semibold">Joining Date</label>
                <input type="date" name="joining_date" id="joining_date" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="fw-semibold">Gender <span class="text-danger">*</span></label>
                <select name="gender" id="gender" class="form-control" required>
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>
            
            <!-- Column 2: Professional Information -->
            <div class="col-md-4">
              <h6 class="text-primary border-bottom pb-2 mb-3">
                <i class="fas fa-stethoscope me-2"></i>Professional Details
              </h6>
              <div class="form-group mb-3">
                <label class="fw-semibold">Qualification</label>
                <input type="text" name="qualification" id="qualification" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="fw-semibold">Experience</label>
                <input type="text" name="experience" id="experience" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="fw-semibold">Address</label>
                <textarea name="address" id="address" class="form-control" rows="2"></textarea>
              </div>
              <div class="form-group mb-3">
                <label class="fw-semibold">Aadhar No</label>
                <input type="text" name="aadhar_no" id="aadhar_no" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="fw-semibold">Pan No</label>
                <input type="text" name="pan_no" id="pan_no" class="form-control">
              </div>
            </div>
            
            <!-- Column 3: Financial & Photo -->
            <div class="col-md-4">
              <h6 class="text-primary border-bottom pb-2 mb-3">
                <i class="fas fa-university me-2"></i>Financial Details
              </h6>
              <div class="form-group mb-3">
                <label class="fw-semibold">Account No</label>
                <input type="text" name="account_no" id="account_no" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="fw-semibold">IFSC Code</label>
                <input type="text" name="ifsc_code" id="ifsc_code" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="fw-semibold">Bank Name</label>
                <input type="text" name="bank_name" id="bank_name" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="fw-semibold">Opening Balance <span class="text-danger">*</span></label>
                <input type="number" name="opening_balance" id="opening_balance" class="form-control" required>
              </div>
              <div class="form-group mb-3">
                <label class="fw-semibold">Doctor Photo</label>
                <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                <div class="mt-2">
                  <img id="photo_preview" src="" alt="Photo Preview" class="img-thumbnail" style="max-width:120px; max-height:120px; display:none;">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times me-2"></i>Close
          </button>
          <button type="button" class="btn btn-outline-warning" onclick="$('#doctorForm')[0].reset(); $('#photo_preview').hide();">
            <i class="fas fa-undo me-2"></i>Reset
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-2"></i>Save Doctor
          </button>
        </div>
      </form>
    </div>
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
            alert('Your session has expired. The page will be refreshed to continue.');
            location.reload();
        }
    });

    // DataTable
    table = $('#doctorTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/doctor',
            type: 'GET',
            data: function(d) {
                d._cacheBust = Date.now(); // Prevent caching
                return d;
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { 
                data: 'photo', 
                name: 'photo', 
                orderable: false, 
                searchable: false,
                render: function(data) { 
                    return data ? `<img src="/storage/doctor_photos/${data}" height="40" class="rounded">` : '<span class="text-muted">No Photo</span>';
                }
            },
            { data: 'name', name: 'name' },
            { data: 'doctor_id', name: 'doctor_id' },
            { data: 'mobile', name: 'mobile' },
            { data: 'email', name: 'email' },
            { data: 'joining_date', name: 'joining_date' },
            { data: 'address', name: 'address' },
            { data: 'opening_balance', name: 'opening_balance' },
            { 
                data: 'status', 
                name: 'status', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row) {
                    const isActive = row.is_active == 1;
                    const statusClass = isActive ? 'success' : 'danger';
                    const statusText = isActive ? 'Active' : 'Inactive';
                    const toggleText = isActive ? 'Deactivate' : 'Activate';
                    const toggleStatus = isActive ? 0 : 1;
                    
                    return `
                        <div class="btn-group" role="group">
                            <span class="badge badge-${statusClass}">${statusText}</span>
                            <button type="button" class="btn btn-sm btn-outline-${statusClass} toggleStatus ms-1" 
                                    data-id="${row.id}" data-status="${toggleStatus}" title="${toggleText}">
                                <i class="fas fa-toggle-${isActive ? 'on' : 'off'}"></i>
                            </button>
                        </div>
                    `;
                }
            },
            { 
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row) {
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
            emptyTable: 'No doctors found',
            zeroRecords: 'No matching doctors found'
        }
    });    
    // Open modal for add
    $('#addDoctorBtn').click(function() {
        $('#doctorForm')[0].reset();
        $('#doctor_id').val('');
        $('#photo_preview').attr('src', '').hide();
        $('#doctorModalLabel').text('Add Doctor');
        $('#doctorModal').modal('show');
    });

    // Photo preview
    $('#photo').change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#photo_preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            $('#photo_preview').attr('src', '').hide();
        }
    });

    // Submit form (add/update)
    $('#doctorForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var id = $('#doctor_id').val();
        var url = id ? '/doctor/' + id : '/doctor';
        var type = 'POST';
        if (id) formData.append('_method', 'PUT');
        
        $.ajax({
            url: url,
            type: type,
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                $('#doctorModal').modal('hide');
                table.ajax.reload();
                // Show success message
                if(response.message) {
                    alert('Success: ' + response.message);
                } else {
                    alert('Doctor saved successfully!');
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

    // Edit button
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/doctor/' + id)
        .done(function(data) {
            $('#doctorForm')[0].reset();
            $('#doctor_id').val(data.id || '');
            $('#name').val(data.name || '');
            $('#mobile').val(data.mobile || '');
            $('#email').val(data.email || '');
            $('#dob').val(data.dob || '');
            $('#joining_date').val(data.joining_date || '');
            $('#gender').val(data.gender || '');
            $('#qualification').val(data.qualification || '');
            $('#experience').val(data.experience || '');
            $('#address').val(data.address || '');
            $('#aadhar_no').val(data.aadhar_no || '');
            $('#pan_no').val(data.pan_no || '');
            $('#account_no').val(data.account_no || '');
            $('#ifsc_code').val(data.ifsc_code || '');
            $('#bank_name').val(data.bank_name || '');
            $('#opening_balance').val(data.opening_balance || '');
            
            if (data.photo) {
                $('#photo_preview').attr('src', '/storage/doctor_photos/' + data.photo).show();
            } else {
                $('#photo_preview').attr('src', '').hide();
            }
            $('#doctorModalLabel').text('Update Doctor');
            $('#doctorModal').modal('show');
        })
        .fail(function() {
            alert('Failed to load doctor data. Please try again.');
        });
    });

    // Delete button
    $(document).on('click', '.deleteBtn', function() {
        if(confirm('Are you sure you want to delete this doctor?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '/doctor/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    table.ajax.reload();
                    if(response.message) {
                        alert('Success: ' + response.message);
                    } else {
                        alert('Doctor deleted successfully!');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Delete failed.'));
                }
            });
        }
    });

    // Status toggle
    $(document).on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        var button = $(this);
        
        // Disable button during request
        button.prop('disabled', true);
        
        $.ajax({
            url: '/doctor/toggle-status/' + id,
            type: 'POST',
            data: { 
                status: status
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                table.ajax.reload();
                if(response.message) {
                    alert('Success: ' + response.message);
                } else {
                    alert('Doctor status updated successfully!');
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
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    });
});
</script>
@endpush