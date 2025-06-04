@extends('layouts.app')

@section('content-header')
    <h1>Manage Enquiry</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header"><b>Create Enquiry</b></div>
            <div class="card-body">
                <form id="enquiryForm">
                    <input type="hidden" id="enquiry_id" name="enquiry_id">
                    <div class="form-group">
                        <label for="name">Enquiry Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enquiry Name" required>
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
                <b>Manage Enquiry</b>
                <button class="btn btn-primary btn-sm" id="addNewBtn"><i class="fas fa-plus"></i> Enquiry</button>
            </div>
            <div class="card-body">
                <table id="enquiryTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>Enquiry Name</th>
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
    let table = $('#enquiryTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ route('enquiry.index') }}',
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'name' },
            { data: 'description' },
            { data: 'status', render: function(data, type, row) {
                return `<button class="btn btn-link toggle-status" data-id="${row.id}">${data ? '<i class="fa fa-eye text-success"></i>' : '<i class="fa fa-eye-slash text-danger"></i>'}</button>`;
            }},
            { data: null, render: function(data, type, row) {
                return `<button class="btn btn-info btn-sm editBtn" data-id="${row.id}" data-name="${row.name}" data-description="${row.description}"><i class="fa fa-edit"></i></button> ` +
                       `<button class="btn btn-danger btn-sm deleteBtn" data-id="${row.id}"><i class="fa fa-trash"></i></button>`;
            }}
        ],
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print', 'colvis'
        ]
    });

    // Reset form
    $('#addNewBtn').click(function() {
        $('#enquiryForm')[0].reset();
        $('#enquiry_id').val('');
    });

    // Save or update
    $('#enquiryForm').submit(function(e) {
        e.preventDefault();
        let id = $('#enquiry_id').val();
        let url = id ? `{{ url('enquiry/update') }}/${id}` : `{{ url('enquiry/store') }}`;
        let method = 'POST';
        let formData = $(this).serializeArray();
        formData.push({ name: '_token', value: $('meta[name="csrf-token"]').attr('content') });
        $.ajax({
            url: url,
            method: method,
            data: $.param(formData),
            success: function(res) {
                toastr.success('Saved successfully');
                table.ajax.reload();
                $('#enquiryForm')[0].reset();
                $('#enquiry_id').val('');
                $('#name').focus();
            },
            error: function(xhr) {
                toastr.error('Error occurred');
            }
        });
    });

    // Edit
    $('#enquiryTable').on('click', '.editBtn', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let description = $(this).data('description');
        $('#enquiry_id').val(id);
        $('#name').val(name);
        $('#description').val(description);
    });

    // Toggle status
    $('#enquiryTable').on('click', '.toggle-status', function() {
        let id = $(this).data('id');
        $.post(`{{ url('enquiry/toggle-status') }}/${id}`, {_token: '{{ csrf_token() }}'}, function(res) {
            toastr.success('Status updated');
            table.ajax.reload();
        });
    });

    // Delete
    $('#enquiryTable').on('click', '.deleteBtn', function() {
        let id = $(this).data('id');
        if(confirm('Are you sure you want to delete this enquiry?')) {
            $.ajax({
                url: `{{ url('enquiry/delete') }}/${id}`,
                method: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    toastr.success('Deleted successfully');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    toastr.error('Delete failed');
                }
            });
        }
    });
});
</script>
@endpush 