@extends('layouts.app')

@section('content-header')
    <h1>Income/Expenses Item</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header"><b>Create Income/Expenses Item:</b></div>
            <div class="card-body">
                <form id="incomeItemForm">
                    <input type="hidden" id="item_id" name="item_id">
                    <!-- Category removed to match screenshot -->
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" id="type" name="type">
                            <option value="Income">Income</option>
                            <option value="Expenses">Expenses</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Item Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Item Name">
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter Item Price">
                    </div>
                    <div class="form-group">
                        <label for="unit">Item Unit</label>
                        <select class="form-control" id="unit" name="unit">
                            <option value="PCS">PCS</option>
                            <option value="PKT">PKT</option>
                            <option value="BOX">BOX</option>
                            <option value="BOTTLE">BOTTLE</option>
                            <option value="TAB">TAB</option>
                            <option value="ML">ML</option>
                            <option value="LTR">LTR</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b>Manage Income/Expenses Item:</b>
                <a href="#" class="btn btn-outline-primary btn-sm"><i class="fas fa-list"></i> Income/Expenses</a>
            </div>
            <div class="card-body">
                <table id="incomeItemTable" class="table table-bordered table-striped">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>S.No.</th>
                            <th>Type</th>
                            <th>Item Name</th>
                            <th>Item Price</th>
                            <th>Income Unit</th>
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
    // Populate category dropdown
    function loadCategories(selectedId = null) {
        $.getJSON('{{ url('income_category') }}', function(res) {
            let options = '<option value="">Select Category</option>';
            if(res.data) {
                res.data.forEach(function(cat) {
                    options += `<option value="${cat.id}" ${selectedId == cat.id ? 'selected' : ''}>${cat.name}</option>`;
                });
            }
            $('#category_id').html(options);
        });
    }
    loadCategories();

    let table = $('#incomeItemTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ url('income_item') }}',
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'type' },
            { data: 'name' },
            { data: 'price' },
            { data: 'unit' },
            { data: null, render: function(data, type, row) {
                return `<button class="btn btn-info btn-sm editBtn" data-id="${row.id}" data-name="${row.name}" data-type="${row.type}" data-price="${row.price}" data-unit="${row.unit}"><i class="fa fa-edit"></i></button> ` +
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
        $('#incomeItemForm')[0].reset();
        $('#item_id').val('');
        loadCategories();
    });

    // Save or update
    $('#incomeItemForm').submit(function(e) {
        e.preventDefault();
        let id = $('#item_id').val();
        let url = id ? `{{ url('income_item') }}/${id}` : `{{ url('income_item') }}`;
        let method = id ? 'POST' : 'POST';
        let formData = $(this).serializeArray();
        formData.push({ name: '_token', value: $('meta[name="csrf-token"]').attr('content') });
        if (id) {
            formData.push({ name: '_method', value: 'PUT' });
        }
        $.ajax({
            url: url,
            method: method,
            data: $.param(formData),
            success: function(res) {
                toastr.success('Saved successfully');
                table.ajax.reload();
                $('#incomeItemForm')[0].reset();
                $('#item_id').val('');
                loadCategories();
            },
            error: function(xhr) {
                toastr.error('Error occurred');
            }
        });
    });

    // Edit
    $('#incomeItemTable').on('click', '.editBtn', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let type = $(this).data('type');
        let price = $(this).data('price');
        let unit = $(this).data('unit');
        $('#item_id').val(id);
        $('#name').val(name);
        $('#type').val(type);
        $('#price').val(price);
        $('#unit').val(unit);
    });

    // Delete
    $('#incomeItemTable').on('click', '.deleteBtn', function() {
        let id = $(this).data('id');
        if(confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: `{{ url('income_item') }}/${id}`,
                method: 'POST',
                data: { _token: $('meta[name="csrf-token"]').attr('content'), _method: 'DELETE' },
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