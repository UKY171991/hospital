@extends('layouts.app')

@section('content-header')
    <h1>Manage Complaint</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header"><b>Create Complaint</b></div>
            <div class="card-body">
                <form id="complaintForm">
                    <input type="hidden" id="complaint_id" name="complaint_id">
                    <div class="form-group">
                        <label for="name">Complaint Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Complaint Name" required>
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
                <b>Manage Complaint</b>
                <button class="btn btn-primary btn-sm" id="addNewBtn"><i class="fas fa-plus"></i> Complaint</button>
            </div>
            <div class="card-body">
                <table id="complaintTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>Complaint Name</th>
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
    let table = $('#complaintTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ url('complaint') }}',
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
        $('#complaintForm')[0].reset();
        $('#complaint_id').val('');
    });

    // Save or update
    $('#complaintForm').submit(function(e) {
        e.preventDefault();
        let id = $('#complaint_id').val();
        let url = id ? `{{ url('complaint/update') }}/${id}` : `{{ url('complaint/store') }}`;
        let method = 'POST';
        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize(),
            success: function(res) {
                toastr.success('Saved successfully');
                table.ajax.reload();
                $('#complaintForm')[0].reset();
                $('#complaint_id').val('');
            },
            error: function(xhr) {
                toastr.error('Error occurred');
            }
        });
    });

    // Edit
    $('#complaintTable').on('click', '.editBtn', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let description = $(this).data('description');
        $('#complaint_id').val(id);
        $('#name').val(name);
        $('#description').val(description);
    });

    // Toggle status
    $('#complaintTable').on('click', '.toggle-status', function() {
        let id = $(this).data('id');
        $.post(`{{ url('complaint/toggle-status') }}/${id}`, {_token: '{{ csrf_token() }}'}, function(res) {
            toastr.success('Status updated');
            table.ajax.reload();
        });
    });
});
</script>
@endpush 