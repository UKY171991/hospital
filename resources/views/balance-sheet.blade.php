@push('scripts')
<script>
$(function() {
    var table = $('#balanceSheetTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/reports/balance-sheet',
        columns: [
            { data: 'report_type', name: 'report_type' },
            { data: 'month_year', name: 'month_year' },
            { data: 'credit', name: 'credit' },
            { data: 'debit', name: 'debit' },
            { data: 'balance', name: 'balance' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Add Entry button handler
    $(document).on('click', '#addBalanceSheetBtn', function() {
        $('#balanceSheetModalLabel').text('Add Balance Sheet Entry');
        $('#balanceSheetModal .modal-body').html(`
            <form id="balanceSheetForm">
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
                    <input type="number" step="0.01" class="form-control" name="credit" id="credit" required>
                </div>
                <div class="form-group">
                    <label>Debit</label>
                    <input type="number" step="0.01" class="form-control" name="debit" id="debit" required>
                </div>
                <div class="form-group">
                    <label>Balance</label>
                    <input type="number" step="0.01" class="form-control" name="balance" id="balance" required>
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        `);
        $('#balanceSheetModal').modal('show');
    });

    // Edit button handler
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/balance-sheet/' + id + '/edit', function(data) {
            $('#addBalanceSheetBtn').trigger('click');
            setTimeout(function() {
                $('#balanceSheetModalLabel').text('Edit Balance Sheet Entry');
                $('#balance_sheet_id').val(data.id);
                $('#report_type').val(data.report_type);
                $('#month_year').val(data.month_year);
                $('#credit').val(data.credit);
                $('#debit').val(data.debit);
                $('#balance').val(data.balance);
            }, 300);
        });
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