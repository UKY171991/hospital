@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-6">
            <h3 class="font-weight-bold">Doctor List</h3>
        </div>
        <div class="col-6 text-right">
            <button class="btn btn-primary" id="addDoctorBtn"><i class="fas fa-plus"></i> Add Doctor</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="doctorTable" style="width:100%">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>S.No</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>DoctorId</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Joining</th>
                        <th>Address</th>
                        <th>Opening Balance</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Doctor Modal -->
<div class="modal fade" id="doctorModal" tabindex="-1" role="dialog" aria-labelledby="doctorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="doctorModalLabel">Add/Update Doctor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="doctorForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="doctor_id">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="name" id="name" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Contact No *</label>
                <input type="text" name="mobile" id="mobile" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" class="form-control">
              </div>
              <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="dob" id="dob" class="form-control">
              </div>
              <div class="form-group">
                <label>Joining Date</label>
                <input type="date" name="joining_date" id="joining_date" class="form-control">
              </div>
              <div class="form-group">
                <label>Gender *</label>
                <select name="gender" id="gender" class="form-control" required>
                  <option value="">Select</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Qualification</label>
                <input type="text" name="qualification" id="qualification" class="form-control">
              </div>
              <div class="form-group">
                <label>Experience</label>
                <input type="text" name="experience" id="experience" class="form-control">
              </div>
              <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" id="address" class="form-control">
              </div>
              <div class="form-group">
                <label>Aadhar No</label>
                <input type="text" name="aadhar_no" id="aadhar_no" class="form-control">
              </div>
              <div class="form-group">
                <label>Pan No</label>
                <input type="text" name="pan_no" id="pan_no" class="form-control">
              </div>
              <div class="form-group">
                <label>Account No</label>
                <input type="text" name="account_no" id="account_no" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>IFSC Code</label>
                <input type="text" name="ifsc_code" id="ifsc_code" class="form-control">
              </div>
              <div class="form-group">
                <label>Bank Name</label>
                <input type="text" name="bank_name" id="bank_name" class="form-control">
              </div>
              <div class="form-group">
                <label>Opening Balance *</label>
                <input type="number" name="opening_balance" id="opening_balance" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Doctor Photo</label>
                <input type="file" name="photo" id="photo" class="form-control-file">
                <img id="photo_preview" src="" alt="" class="img-thumbnail mt-2" style="max-width:100px; display:none;">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    // DataTable
    var table = $('#doctorTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/doctor',
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'photo', name: 'photo', orderable: false, searchable: false, render: function(data) { return data; } },
            { data: 'name', name: 'name' },
            { data: 'doctor_id', name: 'doctor_id' },
            { data: 'mobile', name: 'mobile' },
            { data: 'email', name: 'email' },
            { data: 'joining_date', name: 'joining_date' },
            { data: 'address', name: 'address' },
            { data: 'opening_balance', name: 'opening_balance' },
            { data: 'status', name: 'status', orderable: false, searchable: false, render: function(data, type, row) {
                let icon = data === 'Active' ? 'fa-eye text-success' : 'fa-eye-slash text-warning';
                let nextStatus = data === 'Active' ? 'Inactive' : 'Active';
                return `<a href="#" class="toggleStatus" data-id="${row.id}" data-status="${nextStatus}"><i class="fas ${icon}"></i></a>`;
            } },
            { data: 'action', name: 'action', orderable: false, searchable: false, render: function(data) { return data; } },
        ]
    });

    // Open modal for add
    $('#addDoctorBtn').click(function() {
        $('#doctorForm')[0].reset();
        $('#doctor_id').val('');
        $('#photo_preview').hide();
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
        }
    });

    // Submit form (add/update)
    $('#doctorForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var id = $('#doctor_id').val();
        var url = id ? '/doctor/' + id : '/doctor';
        var type = id ? 'POST' : 'POST';
        if (id) formData.append('_method', 'PUT');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                $('#doctorModal').modal('hide');
                table.ajax.reload();
                toastr && toastr.success(res.message);
            },
            error: function(xhr) {
                toastr && toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });

    // Edit button
    $('#doctorTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/doctor/' + id, function(data) {
            $('#doctorForm')[0].reset();
            $('#doctor_id').val(data.id);
            $('#name').val(data.name);
            $('#mobile').val(data.mobile);
            $('#email').val(data.email);
            $('#dob').val(data.dob);
            $('#joining_date').val(data.joining_date);
            $('#gender').val(data.gender);
            $('#qualification').val(data.qualification);
            $('#experience').val(data.experience);
            $('#address').val(data.address);
            $('#aadhar_no').val(data.aadhar_no);
            $('#pan_no').val(data.pan_no);
            $('#account_no').val(data.account_no);
            $('#ifsc_code').val(data.ifsc_code);
            $('#bank_name').val(data.bank_name);
            $('#opening_balance').val(data.opening_balance);
            if (data.photo) {
                $('#photo_preview').attr('src', '/storage/doctor_photos/' + data.photo).show();
            } else {
                $('#photo_preview').attr('src', 'https://via.placeholder.com/100x100?text=No+Image').show();
            }
            $('#doctorModalLabel').text('Update Doctor');
            $('#doctorModal').modal('show');
        });
    });

    // Delete button
    $('#doctorTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this doctor?')) {
            $.ajax({
                url: '/doctor/' + id,
                type: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    table.ajax.reload();
                    toastr && toastr.success(res.message);
                },
                error: function(xhr) {
                    toastr && toastr.error(xhr.responseJSON?.message || 'Delete failed.');
                }
            });
        }
    });

    // Status toggle
    $('#doctorTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '/doctor/toggle-status/' + id,
            type: 'POST',
            data: { status: status, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                table.ajax.reload();
                toastr && toastr.success(res.message);
            },
            error: function(xhr) {
                toastr && toastr.error(xhr.responseJSON?.message || 'Status update failed.');
            }
        });
    });
});
</script>
@endpush 