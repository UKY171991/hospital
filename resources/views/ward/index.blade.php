@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title" id="formTitle">Add Ward</h3></div>
                <form id="wardForm">
                    @csrf
                    <input type="hidden" name="id" id="ward_id">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Ward Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
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
                <div class="card-header"><h3 class="card-title">Ward List</h3></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="wardTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
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
</div>
@endsection

@push('scripts')
<script>
$(function() {
    // DataTable
    var table = $('#wardTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('ward.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Reset form
    $('#resetBtn').click(function() {
        $('#wardForm')[0].reset();
        $('#ward_id').val('');
        $('#formTitle').text('Add Ward');
        $('#saveBtn').text('Save');
    });

    // Add or Update Ward
    $('#wardForm').submit(function(e) {
        e.preventDefault();
        var id = $('#ward_id').val();
        var url = id ? '/ward/' + id : '/ward';
        var type = id ? 'PUT' : 'POST';
        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(res) {
                table.ajax.reload();
                $('#wardForm')[0].reset();
                $('#ward_id').val('');
                $('#formTitle').text('Add Ward');
                $('#saveBtn').text('Save');
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });

    // Edit button
    $('#wardTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/ward/' + id, function(data) {
            $('#ward_id').val(data.id);
            $('#name').val(data.name);
            $('#description').val(data.description);
            $('#formTitle').text('Edit Ward');
            $('#saveBtn').text('Update');
        });
    });

    // Delete button
    $('#wardTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this ward?')) {
            $.ajax({
                url: '/ward/' + id,
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
    $('#wardTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '/ward/' + id,
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