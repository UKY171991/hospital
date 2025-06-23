@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-building mr-2"></i>Department Management</h1>
            <p class="text-muted">Manage hospital departments and organizational units</p>
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
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title" id="formTitle">Add Department</h3></div>
                <form id="departmentForm">
                    @csrf
                    <input type="hidden" name="id" id="department_id">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="department">Department Name</label>
                            <input type="text" name="department" id="department" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                        <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Department List</h3></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="departmentTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Department</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Department</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="editDepartmentForm">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id" id="edit_department_id">
                <div class="form-group">
                    <label for="edit_department">Department Name</label>
                    <input type="text" name="department" id="edit_department" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea name="description" id="edit_description" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    // DataTable
    var table = $('#departmentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('department.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'department', name: 'department' },
            { data: 'description', name: 'description' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Reset form
    $('#resetBtn').click(function() {
        $('#departmentForm')[0].reset();
        $('#department_id').val('');
        $('#formTitle').text('Add Department');
        $('#saveBtn').text('Save');
    });

    // Add or Update Department
    $('#departmentForm').submit(function(e) {
        e.preventDefault();
        var id = $('#department_id').val();
        var url = id ? '/department/' + id : '/department';
        var type = id ? 'PUT' : 'POST';
        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(res) {
                table.ajax.reload();
                $('#departmentForm')[0].reset();
                $('#department_id').val('');
                $('#formTitle').text('Add Department');
                $('#saveBtn').text('Save');
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });

    // Edit button (main form)
    $('#departmentTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/department/' + id, function(data) {
            // Populate main form for editing
            $('#department_id').val(data.id);
            $('#department').val(data.department);
            $('#description').val(data.description);
            $('#formTitle').text('Edit Department');
            $('#saveBtn').text('Update');
        });
    });

    // Delete button
    $('#departmentTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this department?')) {
            $.ajax({
                url: '/department/' + id,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(res) {
                    table.ajax.reload();
                    toastr.success(res.message);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Delete failed.');
                }
            });
        }
    });

    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Update Department (modal)
    $('#editDepartmentForm').submit(function(e) {
        e.preventDefault();
        var id = $('#edit_department_id').val();
        $.ajax({
            url: '/department/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function(res) {
                table.ajax.reload();
                $('#editModal').modal('hide');
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });

    // Status toggle
    $('#departmentTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '/department/' + id,
            type: 'PUT',
            data: { status: status, _token: '{{ csrf_token() }}' },
            success: function(res) {
                table.ajax.reload();
                toastr.success(res.message);
            }
        });
    });
});
</script>
@endpush
