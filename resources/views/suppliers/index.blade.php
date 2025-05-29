@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Supplier List</h1>
        </div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-primary" id="addSupplierBtn">+ New Supplier</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="supplierTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Contact No</th>
                        <th>Email</th>
                        <th>DOB</th>
                        <th>Qualification</th>
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

<!-- Modal -->
<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="supplierForm" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="supplierModalLabel">Add/Update Supplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="name" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Gender *</label>
                <select name="gender" class="form-control" required>
                  <option value="">Select</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Contact No *</label>
                <input type="text" name="contact_no" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Date of Birth *</label>
                <input type="date" name="dob" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Qualification</label>
                <input type="text" name="qualification" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>PAN No</label>
                <input type="text" name="pan_no" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Aadhar No</label>
                <input type="text" name="aadhar_no" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Bank Name</label>
                <input type="text" name="bank_name" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Account No</label>
                <input type="text" name="account_no" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>IFSC Code</label>
                <input type="text" name="ifsc_code" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Opening Balance *</label>
                <input type="number" name="opening_balance" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Supplier Photo</label>
                <input type="file" name="photo" class="form-control-file" accept="image/*">
                <img id="photoPreview" src="" style="max-width:80px; margin-top:10px; display:none;" />
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
<script>
// Ensure CSRF token is sent with all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(function() {
    var table = $('#supplierTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('suppliers') }}',
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', className: 'btn btn-success btn-sm' },
            { extend: 'pdf', className: 'btn btn-danger btn-sm' },
            { extend: 'print', className: 'btn btn-info btn-sm' },
            { extend: 'colvis', className: 'btn btn-secondary btn-sm', text: 'Column visibility' }
        ],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'photo', name: 'photo', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'contact_no', name: 'contact_no' },
            { data: 'email', name: 'email' },
            { data: 'dob', name: 'dob' },
            { data: 'qualification', name: 'qualification' },
            { data: 'address', name: 'address' },
            { data: 'opening_balance', name: 'opening_balance' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Add Supplier
    $('#addSupplierBtn').click(function() {
        $('#supplierForm')[0].reset();
        $('#photoPreview').hide();
        $('#supplierModalLabel').text('Add Supplier');
        $('#supplierModal').modal('show');
        $('#supplierForm').attr('data-id', '');
    });

    // Photo preview
    $(document).on('change', 'input[name="photo"]', function(e) {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#photoPreview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Edit Supplier
    $('#supplierTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('suppliers/' + id, function(data) {
            $('#supplierForm')[0].reset();
            $('#supplierModalLabel').text('Update Supplier');
            $('#supplierForm').attr('data-id', id);
            $.each(data, function(key, value) {
                if(key === 'photo' && value) {
                    $('#photoPreview')
                        .attr('src', '/storage/supplier_photos/' + value)
                        .attr('onerror', "this.onerror=null;this.src='https://via.placeholder.com/80x80?text=No+Image';")
                        .show();
                } else if(key === 'dob') {
                    $('input[name="dob"]').val(value);
                } else {
                    $('[name="'+key+'"]').val(value);
                }
            });
            $('#supplierModal').modal('show');
        });
    });

    // Delete Supplier
    $('#supplierTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this supplier?')) {
            $.ajax({
                url: 'suppliers/' + id,
                type: 'POST',
                data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                success: function(res) {
                    toastr.success(res.message);
                    table.ajax.reload();
                },
                error: function(xhr) {
                    toastr.error('Failed to delete supplier.');
                }
            });
        }
    });

    // Save Supplier (Add/Edit)
    $('#supplierForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var id = $(this).attr('data-id');
        var method = id ? 'POST' : 'POST';
        var url = id ? 'suppliers/' + id : 'suppliers';
        if(id) formData.append('_method', 'PUT');
        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                $('#supplierModal').modal('hide');
                table.ajax.reload();
                toastr.success(res.message);
            },
            error: function(xhr) {
                var err = xhr.responseJSON;
                toastr.error(err.message || 'Validation error!');
            }
        });
    });

    // Status toggle
    $('#supplierTable').on('change', '.status-toggle', function() {
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 'Active' : 'Inactive';
        $.ajax({
            url: 'suppliers/' + id,
            type: 'POST',
            data: { status: status, _method: 'PUT', _token: '{{ csrf_token() }}' },
            success: function(res) {
                toastr.success(res.message);
                table.ajax.reload(null, false);
            }
        });
    });
});
</script>
@endpush 