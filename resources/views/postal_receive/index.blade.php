@extends('layouts.app')

@section('content-header')
    <h1>Manage Postal Receive</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header"><b>Create Postal Receive</b></div>
            <div class="card-body">
                <form id="postalReceiveForm">
                    <input type="hidden" id="postal_receive_id" name="postal_receive_id">
                    <div class="form-group">
                        <label for="name">Receive Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Receive Name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b>Manage Postal Receive</b>
                <button class="btn btn-primary btn-sm" id="addNewBtn"><i class="fas fa-plus"></i> Postal Receive</button>
            </div>
            <div class="card-body">
                <table id="postalReceiveTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>Receive Name</th>
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
@endsection

@push('scripts')
<script>
$(function() {
    let table = $('#postalReceiveTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ url('postal-receive') }}',
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'name' },
            { data: 'description' },
            { data: 'status', render: function(data, type, row) {
                return `<button class=\"btn btn-link toggle-status\" data-id=\"${row.id}\">${data ? '<i class=\\'fa fa-eye text-success\\'></i>' : '<i class=\\'fa fa-eye-slash text-danger\\'></i>'}</button>`;
            }},
            { data: null, render: function(data, type, row) {
                return `<button class=\"btn btn-info btn-sm editBtn\" data-id=\"${row.id}\" data-name=\"${row.name}\" data-description=\"${row.description}\"><i class=\"fa fa-edit\"></i></button>`;
            }}
        ],
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print', 'colvis'
        ]
    });

    // Reset form
    $('#addNewBtn').click(function() {
        $('#postalReceiveForm')[0].reset();
        $('#postal_receive_id').val('');
    });

    // Save or update
    $('#postalReceiveForm').submit(function(e) {
        e.preventDefault();
        let id = $('#postal_receive_id').val();
        let url = id ? `{{ url('postal-receive/update') }}/${id}` : `{{ url('postal-receive/store') }}`;
        let method = 'POST';
        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize(),
            success: function(res) {
                toastr.success('Saved successfully');
                table.ajax.reload();
                $('#postalReceiveForm')[0].reset();
                $('#postal_receive_id').val('');
            },
            error: function(xhr) {
                toastr.error('Error occurred');
            }
        });
    });

    // Edit
    $('#postalReceiveTable').on('click', '.editBtn', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let description = $(this).data('description');
        $('#postal_receive_id').val(id);
        $('#name').val(name);
        $('#description').val(description);
    });

    // Toggle status
    $('#postalReceiveTable').on('click', '.toggle-status', function() {
        let id = $(this).data('id');
        $.post(`{{ url('postal-receive/toggle-status') }}/${id}`, {_token: '{{ csrf_token() }}'}, function(res) {
            toastr.success('Status updated');
            table.ajax.reload();
        });
    });
});
</script>
@endpush 