@extends('layouts.app')

@section('content-header')
    <h1>Main Test Categories</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b>Manage Main Test Categories</b>
                <button type="button" class="btn btn-success btn-sm" id="openMainCategoryModalBtn">
                    <i class="fas fa-plus"></i> Add Main Test Category
                </button>
            </div>
            <div class="card-body">
                <table id="mainCategoryTable" class="table table-bordered table-striped">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>S.No.</th>
                            <th>Main Category Name</th>
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

<div class="modal fade" id="mainCategoryModal" tabindex="-1" role="dialog" aria-labelledby="mainCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="mainCategoryModalLabel">Create Main Test Category</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="mainCategoryForm">
                    <input type="hidden" id="main_category_id" name="main_category_id">

                    <div class="form-group">
                        <label for="name">Main Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Main Category Name" required>
                    </div>

                    <div class="form-group mb-0">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="resetFormBtn" class="btn btn-secondary">Reset</button>
                <button type="submit" form="mainCategoryForm" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    const table = $('#mainCategoryTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ route('pathology.main-test-categories.data') }}',
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
        $('#mainCategoryForm')[0].reset();
        $('#main_category_id').val('');
        $('#mainCategoryModalLabel').text('Create Main Test Category');
    }

    $('#openMainCategoryModalBtn').on('click', function() {
        resetForm();
        $('#mainCategoryModal').modal('show');
    });

    $('#resetFormBtn').on('click', resetForm);

    $('#mainCategoryForm').submit(function(e) {
        e.preventDefault();

        const id = $('#main_category_id').val();
        const url = id
            ? `{{ url('pathology/main-test-categories/update') }}/${id}`
            : `{{ route('pathology.main-test-categories.store') }}`;

        $.ajax({
            url: url,
            method: 'POST',
            data: $(this).serialize() + `&_token=${csrfToken}`,
            success: function() {
                toastr.success('Saved successfully');
                table.ajax.reload();
                resetForm();
                $('#mainCategoryModal').modal('hide');
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Error occurred';
                toastr.error(message);
            }
        });
    });

    $('#mainCategoryTable').on('click', '.editBtn', function() {
        $('#main_category_id').val($(this).data('id'));
        $('#name').val($(this).data('name'));
        $('#description').val($(this).data('description'));
        $('#mainCategoryModalLabel').text('Edit Main Test Category');
        $('#mainCategoryModal').modal('show');
    });

    $('#mainCategoryTable').on('click', '.deleteBtn', function() {
        const id = $(this).data('id');

        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                url: `{{ url('pathology/main-test-categories') }}/${id}`,
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
