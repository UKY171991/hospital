@extends('layouts.app')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Ledger Report</h1>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body">
            <form id="ledgerFilterForm" class="form-row align-items-end">
                <div class="form-group col-md-3">
                    <label>Report Type<span class="text-danger">*</span></label>
                    <select class="form-control" name="report_type" required>
                        <option value="Doctor Wise">Doctor Wise</option>
                        <option value="Patient Wise">Patient Wise</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Doctor Name<span class="text-danger">*</span></label>
                    <select class="form-control" name="doctor_name" required>
                        <option value="Ayush Raj">Ayush Raj</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>From Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="from_date" required value="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group col-md-2">
                    <label>To Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="to_date" required value="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-success btn-block"><i class="fas fa-search"></i> Search Report</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="ledgerTable">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>Particular</th>
                            <th>Transaction Date</th>
                            <th>Remarks</th>
                            <th>Credit</th>
                            <th>Debit</th>
                            <th>Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Opening Balance</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>400</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Transaction Total</td>
                            <td></td>
                            <td></td>
                            <td>0</td>
                            <td>0</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Closing Balance</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>400</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit (structure only) -->
<div class="modal fade" id="ledgerModal" tabindex="-1" role="dialog" aria-labelledby="ledgerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ledgerModalLabel">Add/Edit Ledger Entry</h5>
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
    var table = $('#ledgerTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/ledgers',
            dataSrc: 'data'
        },
        columns: [
            { data: 'particular' },
            { data: 'transaction_date' },
            { data: 'remarks' },
            { data: 'credit' },
            { data: 'debit' },
            { data: 'balance' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Toastr status
    function showStatus(type, message) {
        toastr.clear();
        if(type === 'success') toastr.success(message);
        else if(type === 'info') toastr.info(message);
        else toastr.error(message);
    }

    // Open modal for add
    $(document).on('click', '#addLedgerBtn', function() {
        $('#ledgerModalLabel').text('Add Ledger Entry');
        $('#ledgerModal .modal-body').html(`
            <form id="ledgerForm">
                @csrf
                <input type="hidden" name="id" id="ledger_id">
                <div class="form-group">
                    <label>Report Type</label>
                    <input type="text" class="form-control" name="report_type" id="report_type" required>
                </div>
                <div class="form-group">
                    <label>Doctor Name</label>
                    <input type="text" class="form-control" name="doctor_name" id="doctor_name" required>
                </div>
                <div class="form-group">
                    <label>Transaction Date</label>
                    <input type="date" class="form-control" name="transaction_date" id="transaction_date" required>
                </div>
                <div class="form-group">
                    <label>Remarks</label>
                    <input type="text" class="form-control" name="remarks" id="remarks">
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
        $('#ledgerModal').modal('show');
    });

    // Open modal for edit
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/ledgers/' + id, function(data) {
            $('#ledgerModalLabel').text('Edit Ledger Entry');
            $('#ledgerModal .modal-body').html(`
                <form id="ledgerForm">
                    @csrf
                    <input type="hidden" name="id" id="ledger_id" value="${data.id}">
                    <div class="form-group">
                        <label>Report Type</label>
                        <input type="text" class="form-control" name="report_type" id="report_type" value="${data.report_type}" required>
                    </div>
                    <div class="form-group">
                        <label>Doctor Name</label>
                        <input type="text" class="form-control" name="doctor_name" id="doctor_name" value="${data.doctor_name}" required>
                    </div>
                    <div class="form-group">
                        <label>Transaction Date</label>
                        <input type="date" class="form-control" name="transaction_date" id="transaction_date" value="${data.transaction_date}" required>
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" class="form-control" name="remarks" id="remarks" value="${data.remarks || ''}">
                    </div>
                    <div class="form-group">
                        <label>Credit</label>
                        <input type="number" step="0.01" class="form-control" name="credit" id="credit" value="${data.credit}">
                    </div>
                    <div class="form-group">
                        <label>Debit</label>
                        <input type="number" step="0.01" class="form-control" name="debit" id="debit" value="${data.debit}">
                    </div>
                    <div class="form-group">
                        <label>Balance</label>
                        <input type="number" step="0.01" class="form-control" name="balance" id="balance" value="${data.balance}">
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            `);
            $('#ledgerModal').modal('show');
        });
    });

    // Save (add or update)
    $(document).on('submit', '#ledgerForm', function(e) {
        e.preventDefault();
        var id = $('#ledger_id').val();
        var url = id ? '/ledgers/' + id : '/ledgers';
        var type = id ? 'PUT' : 'POST';
        var formData = $(this).serialize();
        if (id) formData += '&_method=PUT';
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(res) {
                $('#ledgerModal').modal('hide');
                table.ajax.reload();
                showStatus('success', res.message);
            },
            error: function(xhr) {
                showStatus('danger', 'Failed to save ledger entry.');
            }
        });
    });

    // Delete
    $(document).on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this entry?')) {
            $.ajax({
                url: '/ledgers/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    table.ajax.reload();
                    showStatus('success', res.message);
                },
                error: function() {
                    showStatus('danger', 'Failed to delete ledger entry.');
                }
            });
        }
    });

    // Filter/search form
    $('#ledgerFilterForm').submit(function(e) {
        e.preventDefault();
        // For demo, just reload table. For real use, pass filter params to AJAX.
        table.ajax.reload();
    });
});
</script>
@endpush 