@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title" id="formTitle">Add Fee Assignment</h3></div>
                <form id="feeAssignForm">
                    @csrf
                    <input type="hidden" name="id" id="fee_assign_id">
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
                            <label for="item_name">Item/Service Name</label>
                            <input type="text" name="item_name" id="item_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
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
                <div class="card-header"><h3 class="card-title">Fee Assign List</h3></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="feeAssignTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Department</th>
                                <th>Item/Service</th>
                                <th>Amount</th>
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
    var table = $('#feeAssignTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('fee_assign.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'department', name: 'department.department' },
            { data: 'item_name', name: 'item_name' },
            { data: 'amount', name: 'amount' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Reset form
    $('#resetBtn').click(function() {
        $('#feeAssignForm')[0].reset();
        $('#fee_assign_id').val('');
        $('#formTitle').text('Add Fee Assignment');
        $('#saveBtn').text('Save');
    });

    // Add or Update Fee Assign
    $('#feeAssignForm').submit(function(e) {
        e.preventDefault();
        var id = $('#fee_assign_id').val();
        var url = id ? '/fee_assign/' + id : '/fee_assign';
        var type = id ? 'PUT' : 'POST';
        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(res) {
                table.ajax.reload();
                $('#feeAssignForm')[0].reset();
                $('#fee_assign_id').val('');
                $('#formTitle').text('Add Fee Assignment');
                $('#saveBtn').text('Save');
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });

    // Edit button
    $('#feeAssignTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/fee_assign/' + id, function(data) {
            $('#fee_assign_id').val(data.id);
            $('#department_id').val(data.department_id);
            $('#item_name').val(data.item_name);
            $('#amount').val(data.amount);
            $('#formTitle').text('Edit Fee Assignment');
            $('#saveBtn').text('Update');
        });
    });

    // Delete button
    $('#feeAssignTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this fee assignment?')) {
            $.ajax({
                url: '/fee_assign/' + id,
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
    $('#feeAssignTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '/fee_assign/' + id,
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