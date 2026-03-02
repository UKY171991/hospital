@extends('layouts.app')

@section('content-header')
    <h1>{{ $title }}</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b>Manage {{ $title }}</b>
                <button type="button" class="btn btn-success btn-sm" id="openCreateModalBtn">
                    <i class="fas fa-plus"></i> Add {{ $title }}
                </button>
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

<div class="modal fade" id="pathologyCrudModal" tabindex="-1" role="dialog" aria-labelledby="pathologyCrudModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="pathologyCrudModalLabel">Create {{ $title }} Record</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="pathologyCrudForm">
                    <input type="hidden" id="record_id" name="record_id">

                    @if (in_array($section, ['test-categories', 'tests']))
                        <div class="form-group">
                            <label for="main_test_category_id">Main Test Category <span class="text-danger">*</span></label>
                            <select class="form-control" id="main_test_category_id" name="main_test_category_id" required>
                                <option value="">Select main test category</option>
                            </select>
                        </div>
                    @endif

                    @if ($section === 'tests')
                        <div class="form-group">
                            <label for="test_category_id">Test Category <span class="text-danger">*</span></label>
                            <select class="form-control" id="test_category_id" name="test_category_id" required>
                                <option value="">Select test category</option>
                            </select>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                    </div>

                    <div class="form-group mb-0">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="resetFormBtn" class="btn btn-secondary">Reset</button>
                <button type="submit" form="pathologyCrudForm" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
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
    const needsMainCategory = ['test-categories', 'tests'].includes(section);
    const needsTestCategory = section === 'tests';

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
                    return `<button class="btn btn-info btn-sm editBtn" data-id="${row.id}" data-name="${row.name}" data-description="${safeDescription}" data-main-test-category-id="${row.main_test_category_id ?? ''}" data-test-category-id="${row.test_category_id ?? ''}"><i class="fa fa-edit"></i></button> ` +
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
        $('#pathologyCrudModalLabel').text(`Create {{ $title }} Record`);

        if (needsTestCategory) {
            $('#test_category_id').html('<option value="">Select test category</option>');
        }
    }

    function loadMainCategories(selectedId = '') {
        if (!needsMainCategory) {
            return;
        }

        $.get('/pathology/main-test-categories/data', function(response) {
            const options = (response.data || [])
                .map(category => `<option value="${category.id}">${category.name}</option>`)
                .join('');

            $('#main_test_category_id').html('<option value="">Select main test category</option>' + options);
            if (selectedId) {
                $('#main_test_category_id').val(String(selectedId));
            }
        });
    }

    function loadTestCategories(mainCategoryId, selectedId = '') {
        if (!needsTestCategory) {
            return;
        }

        if (!mainCategoryId) {
            $('#test_category_id').html('<option value="">Select test category</option>');
            return;
        }

        $.get('/pathology/test-categories/data', { main_test_category_id: mainCategoryId }, function(response) {
            const options = (response.data || [])
                .map(category => `<option value="${category.id}">${category.name}</option>`)
                .join('');

            $('#test_category_id').html('<option value="">Select test category</option>' + options);
            if (selectedId) {
                $('#test_category_id').val(String(selectedId));
            }
        });
    }

    if (needsMainCategory) {
        loadMainCategories();
    }

    if (needsTestCategory) {
        $('#main_test_category_id').on('change', function() {
            loadTestCategories($(this).val());
        });
    }

    $('#openCreateModalBtn').on('click', function() {
        resetForm();
        if (needsMainCategory) {
            loadMainCategories();
        }
        $('#pathologyCrudModal').modal('show');
    });

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
                $('#pathologyCrudModal').modal('hide');
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
        $('#pathologyCrudModalLabel').text(`Edit {{ $title }} Record`);

        const mainCategoryId = $(this).data('main-test-category-id');
        const testCategoryId = $(this).data('test-category-id');

        if (needsMainCategory) {
            loadMainCategories(mainCategoryId);
        }

        if (needsTestCategory) {
            loadTestCategories(mainCategoryId, testCategoryId);
        }

        $('#pathologyCrudModal').modal('show');
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
