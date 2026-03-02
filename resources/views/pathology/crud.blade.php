@extends('layouts.app')

@section('content-header')
    <h1>{{ $title }}</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header"><b>Create {{ $title }} Record</b></div>
            <div class="card-body">
                <form id="pathologyCrudForm">
                    <input type="hidden" id="record_id" name="record_id">

                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
                    <button type="button" id="resetFormBtn" class="btn btn-secondary">Reset</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b>Manage {{ $title }}</b>
            </div>
            <div class="card-body">
                <table id="pathologyCrudTable" class="table table-bordered table-striped">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>S.No.</th>
                            <th>Name</th>
                            <th>Description</th>
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
    const section = @json($section);
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    const table = $('#pathologyCrudTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: `/pathology/${section}/data`,
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'name' },
            { data: 'description', defaultContent: '-' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    const safeDescription = (row.description ?? '').replace(/"/g, '&quot;');
                    return `<button class="btn btn-info btn-sm editBtn" data-id="${row.id}" data-name="${row.name}" data-description="${safeDescription}"><i class="fa fa-edit"></i></button> ` +
                        `<button class="btn btn-danger btn-sm deleteBtn" data-id="${row.id}"><i class="fa fa-trash"></i></button>`;
                }
            }
        ],
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print', 'colvis']
    });

    function resetForm() {
        $('#pathologyCrudForm')[0].reset();
        $('#record_id').val('');
    }

    $('#resetFormBtn').on('click', resetForm);

    $('#pathologyCrudForm').submit(function(e) {
        e.preventDefault();

        const id = $('#record_id').val();
        const url = id
            ? `/pathology/${section}/update/${id}`
            : `/pathology/${section}/store`;

        $.ajax({
            url: url,
            method: 'POST',
            data: $(this).serialize() + `&_token=${csrfToken}`,
            success: function() {
                toastr.success('Saved successfully');
                table.ajax.reload();
                resetForm();
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Error occurred';
                toastr.error(message);
            }
        });
    });

    $('#pathologyCrudTable').on('click', '.editBtn', function() {
        $('#record_id').val($(this).data('id'));
        $('#name').val($(this).data('name'));
        $('#description').val($(this).data('description'));
    });

    $('#pathologyCrudTable').on('click', '.deleteBtn', function() {
        const id = $(this).data('id');

        if (confirm('Are you sure you want to delete this record?')) {
            $.ajax({
                url: `/pathology/${section}/${id}`,
                method: 'DELETE',
                data: { _token: csrfToken },
                success: function() {
                    toastr.success('Deleted successfully');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Delete failed';
                    toastr.error(message);
                }
            });
        }
    });
});
</script>
@endpush
