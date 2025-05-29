@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title" id="formTitle">Add Disease</h3></div>
                <form id="diseaseForm">
                    @csrf
                    <input type="hidden" name="id" id="disease_id">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="department_id">Department</label>
                            <select name="department_id" id="department_id" class="form-control" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->department }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="disease">Disease Name</label>
                            <input type="text" name="disease" id="disease" class="form-control" required>
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
                <div class="card-header"><h3 class="card-title">Disease List</h3></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="diseaseTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Department</th>
                                <th>Disease</th>
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
            <h5 class="modal-title" id="editModalLabel">Edit Disease</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="editDiseaseForm">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id" id="edit_disease_id">
                <div class="form-group">
                    <label for="edit_department_id">Department</label>
                    <select name="department_id" id="edit_department_id" class="form-control" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_disease">Disease Name</label>
                    <input type="text" name="disease" id="edit_disease" class="form-control" required>
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
    var table = $('#diseaseTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('disease.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'department', name: 'department.department' },
            { data: 'disease', name: 'disease' },
            { data: 'description', name: 'description' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Reset form
    $('#resetBtn').click(function() {
        $('#diseaseForm')[0].reset();
        $('#disease_id').val('');
        $('#formTitle').text('Add Disease');
        $('#saveBtn').text('Save');
    });

    // Add or Update Disease
    $('#diseaseForm').submit(function(e) {
        e.preventDefault();
        var id = $('#disease_id').val();
        var url = id ? '/disease/' + id : '/disease';
        var type = id ? 'PUT' : 'POST';
        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(res) {
                table.ajax.reload();
                $('#diseaseForm')[0].reset();
                $('#disease_id').val('');
                $('#formTitle').text('Add Disease');
                $('#saveBtn').text('Save');
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });

    // Edit button (main form)
    $('#diseaseTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/disease/' + id, function(data) {
            // Populate main form for editing
            $('#disease_id').val(data.id);
            $('#department_id').val(data.department_id);
            $('#disease').val(data.disease);
            $('#description').val(data.description);
            $('#formTitle').text('Edit Disease');
            $('#saveBtn').text('Update');
        });
    });

    // Delete button
    $('#diseaseTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this disease?')) {
            $.ajax({
                url: '/disease/' + id,
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

    // Update Disease (modal)
    $('#editDiseaseForm').submit(function(e) {
        e.preventDefault();
        var id = $('#edit_disease_id').val();
        $.ajax({
            url: '/disease/' + id,
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
    $('#diseaseTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '/disease/' + id,
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