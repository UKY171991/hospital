@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title" id="formTitle">Add Investigation</h3></div>
                <form id="investigationForm">
                    @csrf
                    <input type="hidden" name="id" id="investigation_id">
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
                            <label for="name">Investigation Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control" required>
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
                <div class="card-header"><h3 class="card-title">Investigation List</h3></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="investigationTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Department</th>
                                <th>Name</th>
                                <th>Price</th>
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
</div>
@endsection

@push('scripts')
<script>
$(function() {
    // DataTable
    var table = $('#investigationTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('investigation.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'department', name: 'department.department' },
            { data: 'name', name: 'name' },
            { data: 'price', name: 'price' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Reset form
    $('#resetBtn').click(function() {
        $('#investigationForm')[0].reset();
        $('#investigation_id').val('');
        $('#formTitle').text('Add Investigation');
        $('#saveBtn').text('Save');
    });

    // Add or Update Investigation
    $('#investigationForm').submit(function(e) {
        e.preventDefault();
        var id = $('#investigation_id').val();
        var url = id ? '/investigation/' + id : '/investigation';
        var type = id ? 'PUT' : 'POST';
        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(res) {
                table.ajax.reload();
                $('#investigationForm')[0].reset();
                $('#investigation_id').val('');
                $('#formTitle').text('Add Investigation');
                $('#saveBtn').text('Save');
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });

    // Edit button
    $('#investigationTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/investigation/' + id, function(data) {
            $('#investigation_id').val(data.id);
            $('#department_id').val(data.department_id);
            $('#name').val(data.name);
            $('#price').val(data.price);
            $('#formTitle').text('Edit Investigation');
            $('#saveBtn').text('Update');
        });
    });

    // Delete button
    $('#investigationTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this investigation?')) {
            $.ajax({
                url: '/investigation/' + id,
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

    // Status toggle
    $('#investigationTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '/investigation/' + id,
            type: 'PUT',
            data: { status: status, _token: '{{ csrf_token() }}' },
            success: function(res) {
                table.ajax.reload();
                toastr.success(res.message);
            }
        });
    });

    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
</script>
@endpush 