@extends('layouts.app')

@section('content-header')
    <h1>Income/Expenses Category</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header"><b>Create Income/Expenses Category:</b></div>
            <div class="card-body">
                <form id="incomeCategoryForm">
                    <input type="hidden" id="category_id" name="category_id">
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="Income">Income</option>
                            <option value="Expenses">Expenses</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Category Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name" required>
                    </div>
                    <div class="form-group">
                        <label for="income_type">Income Type</label>
                        <select class="form-control" id="income_type" name="income_type" required>
                            <option value="Direct">Direct</option>
                            <option value="Indirect">Indirect</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b>Manage Income/Expenses Category:</b>
                <a href="#" class="btn btn-outline-primary btn-sm"><i class="fas fa-list"></i> Income/Expenses</a>
            </div>
            <div class="card-body">
                <table id="incomeCategoryTable" class="table table-bordered table-striped">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>S.No.</th>
                            <th>Type</th>
                            <th>Category Name</th>
                            <th>Income Type</th>
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
    let table = $('#incomeCategoryTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ url('income_category') }}',
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'type' },
            { data: 'name' },
            { data: 'income_type' },
            { data: null, render: function(data, type, row) {
                return `<button class="btn btn-info btn-sm editBtn" data-id="${row.id}" data-type="${row.type}" data-name="${row.name}" data-income_type="${row.income_type}"><i class="fa fa-edit"></i></button> ` +
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
        $('#incomeCategoryForm')[0].reset();
        $('#category_id').val('');
    });

    // Save or update
    $('#incomeCategoryForm').submit(function(e) {
        e.preventDefault();
        let id = $('#category_id').val();
        let url = id ? `{{ url('income_category/update') }}/${id}` : `{{ route('income_category.store') }}`;
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
                $('#incomeCategoryForm')[0].reset();
                $('#category_id').val('');
            },
            error: function(xhr) {
                toastr.error('Error occurred');
            }
        });
    });

    // Edit
    $('#incomeCategoryTable').on('click', '.editBtn', function() {
        let id = $(this).data('id');
        let type = $(this).data('type');
        let name = $(this).data('name');
        let income_type = $(this).data('income_type');
        $('#category_id').val(id);
        $('#type').val(type);
        $('#name').val(name);
        $('#income_type').val(income_type);
    });

    // Delete
    $('#incomeCategoryTable').on('click', '.deleteBtn', function() {
        let id = $(this).data('id');
        if(confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                url: `{{ url('income_category') }}/${id}`,
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