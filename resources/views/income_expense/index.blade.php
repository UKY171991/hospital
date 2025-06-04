@extends('layouts.app')

@section('content-header')
    <h1>Income/Expenses</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b>Income-Expenses List</b>
                <button class="btn btn-primary" id="addIncomeExpenseBtn"><i class="fas fa-plus"></i> Add Income-Expenses</button>
            </div>
            <div class="card-body">
                <table id="incomeExpenseTable" class="table table-bordered table-striped">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>S.No.</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Item</th>
                            <th>Amount</th>
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
@include('income_expense.modal')
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css"/>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
<script>
$(function() {
    let table = $('#incomeExpenseTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ url('income_expense') }}',
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1, orderable: false, searchable: false },
            { data: 'date', name: 'date' },
            { data: 'type', name: 'type' },
            { data: 'category', name: 'category' },
            { data: 'item_name', name: 'item_name' },
            { data: 'amount', name: 'amount' },
            { data: 'description', name: 'description' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print', 'colvis'
        ]
    });

    // Open modal for add
    $('#addIncomeExpenseBtn').click(function() {
        $('#incomeExpenseForm')[0].reset();
        $('#entry_id').val('');
        $('#incomeExpenseModalLabel').text('Add Income-Expenses');
        $('#incomeExpenseModal').modal('show');
        $('#category').val('');
        loadItems();
    });

    // Open modal for edit
    $('#incomeExpenseTable').on('click', '.editBtn', function() {
        let id = $(this).data('id');
        $.get(`/income_expense/${id}`, function(entry) {
            $('#entry_id').val(entry.id);
            $('#date').val(entry.date);
            $('#type').val(entry.type);
            $('#amount').val(entry.amount);
            $('#description').val(entry.description);
            $('#category').val(entry.category);
            loadItems(entry.item_id);
            $('#incomeExpenseModalLabel').text('Edit Income-Expenses');
            $('#incomeExpenseModal').modal('show');
        });
    });

    // Save or update
    $('#incomeExpenseForm').submit(function(e) {
        e.preventDefault();
        let id = $('#entry_id').val();
        let url = id ? `/income_expense/update/${id}` : `/income_expense/store`;
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
                $('#incomeExpenseModal').modal('hide');
            },
            error: function(xhr) {
                toastr.error('Error occurred');
            }
        });
    });

    // Delete
    $('#incomeExpenseTable').on('click', '.deleteBtn', function() {
        let id = $(this).data('id');
        if(confirm('Are you sure you want to delete this entry?')) {
            $.ajax({
                url: `/income_expense/delete/${id}`,
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

    // Only load items for Item dropdown
    function loadItems(selectedId = null) {
        let url = '{{ url('income_item') }}';
        $.getJSON(url, function(res) {
            let options = '<option value="">Select Item</option>';
            if(res.data) {
                res.data.forEach(function(item) {
                    options += `<option value="${item.id}" ${selectedId == item.id ? 'selected' : ''}>${item.name}</option>`;
                });
            }
            $('#item_id').html(options);
        });
    }
});
</script>
@endpush 