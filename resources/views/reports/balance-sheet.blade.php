    // Edit
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/balance-sheet/' + id + '/edit', function(data) {
            $('#balanceSheetModalLabel').text('Edit Balance Sheet Entry');
            // Ensure the modal form is loaded before setting values
            $('#addBalanceSheetBtn').trigger('click');
            setTimeout(function() {
                $('#balance_sheet_id').val(data.id);
                $('#report_type').val(data.report_type);
                $('#month_year').val(data.month_year);
                $('#credit').val(data.credit);
                $('#debit').val(data.debit);
                $('#balance').val(data.balance);
            }, 300);
        });
    });
@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Balance Sheet</h1>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Balance Sheet</h3>
        <button id="addBalanceSheetBtn" class="btn btn-primary float-right">Add Entry</button>
    </div>
    <div class="card-body">
        <table id="balanceSheetTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Report Type</th>
                    <th>Month-Year</th>
                    <th>Credit</th>
                    <th>Debit</th>
                    <th>Balance</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded via AJAX -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Add/Edit -->
<div class="modal fade" id="balanceSheetModal" tabindex="-1" role="dialog" aria-labelledby="balanceSheetModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="balanceSheetModalLabel">Add/Edit Balance Sheet Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form will be loaded here by AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    // DataTable
    var table = $('#balanceSheetTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/reports/balance-sheet',
            dataSrc: 'data'
        },
        columns: [
            { data: 'report_type' },
            { data: 'month_year' },
            { data: 'credit' },
            { data: 'debit' },
            { data: 'balance' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Open modal for add
    $(document).on('click', '#addBalanceSheetBtn', function() {
        $('#balanceSheetModalLabel').text('Add Balance Sheet Entry');
        $('#balanceSheetModal .modal-body').html(`
            <form id="balanceSheetForm">
                @csrf
                <input type="hidden" name="id" id="balance_sheet_id">
                <div class="form-group">
                    <label>Report Type</label>
                    <input type="text" class="form-control" name="report_type" id="report_type" required>
                </div>
                <div class="form-group">
                    <label>Month-Year</label>
                    <input type="month" class="form-control" name="month_year" id="month_year" required>
                </div>
                <div class="form-group">
                    <label>Credit</label>
                    <input type="number" step="0.01" class="form-control" name="credit" id="credit">
                </div>
                <div class="form-group">
                    <label>Debit</label>
                    <input type="number" step="0.01" class="form-control" name="debit" id="debit">
                </div>
                <div class="form-group">
                    <label>Balance</label>
                    <input type="number" step="0.01" class="form-control" name="balance" id="balance">
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        `);
        $('#balanceSheetModal').modal('show');
    });

    // Save (add or update)
    $(document).on('submit', '#balanceSheetForm', function(e) {
        e.preventDefault();
        var id = $('#balance_sheet_id').val();
        var url = id ? '/balance-sheet/' + id : '/balance-sheet';
        var type = id ? 'PUT' : 'POST';
        var formData = $(this).serialize();
        if (id) formData += '&_method=PUT';
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(res) {
                $('#balanceSheetModal').modal('hide');
                table.ajax.reload();
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error('Failed to save balance sheet entry.');
            }
        });
    });

    // Delete
    $(document).on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this entry?')) {
            $.ajax({
                url: '/balance-sheet/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    table.ajax.reload();
                    toastr.success(res.message);
                },
                error: function() {
                    toastr.error('Failed to delete balance sheet entry.');
                }
            });
        }
    });
});
</script>
@endpush
