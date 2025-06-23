@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-chart-line mr-2"></i>Balance Sheet Reports</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Reports</li>
                <li class="breadcrumb-item active">Balance Sheet</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="totalCreditAmount">₹0.00</h4>
                            <p class="mb-0">Total Credits</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-plus-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="totalDebitAmount">₹0.00</h4>
                            <p class="mb-0">Total Debits</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-minus-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="netBalance">₹0.00</h4>
                            <p class="mb-0">Net Balance</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-balance-scale fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="totalEntries">0</h4>
                            <p class="mb-0">Total Entries</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Balance Sheet Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-table mr-2"></i>Balance Sheet Entries</h3>
                <button id="addBalanceSheetBtn" class="btn btn-light btn-sm">
                    <i class="fas fa-plus mr-1"></i>Add Entry
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="balanceSheetTable" class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th><i class="fas fa-tag mr-1"></i>Report Type</th>
                            <th><i class="fas fa-calendar mr-1"></i>Month-Year</th>
                            <th class="text-success"><i class="fas fa-plus mr-1"></i>Credit</th>
                            <th class="text-danger"><i class="fas fa-minus mr-1"></i>Debit</th>
                            <th class="text-info"><i class="fas fa-balance-scale mr-1"></i>Balance</th>
                            <th><i class="fas fa-cogs mr-1"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit -->
<div class="modal fade" id="balanceSheetModal" tabindex="-1" role="dialog" aria-labelledby="balanceSheetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="balanceSheetModalLabel">
                    <i class="fas fa-edit mr-2"></i>Add/Edit Balance Sheet Entry
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
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
        responsive: true,
        ajax: {
            url: '/reports/balance-sheet',
            dataSrc: 'data'
        },
        columns: [
            { data: 'report_type' },
            { data: 'month_year' },
            { 
                data: 'credit',
                render: function(data) {
                    return '₹' + parseFloat(data || 0).toFixed(2);
                },
                className: 'text-success font-weight-bold'
            },
            { 
                data: 'debit',
                render: function(data) {
                    return '₹' + parseFloat(data || 0).toFixed(2);
                },
                className: 'text-danger font-weight-bold'
            },
            { 
                data: 'balance',
                render: function(data) {
                    return '₹' + parseFloat(data || 0).toFixed(2);
                },
                className: 'text-info font-weight-bold'
            },
            { 
                data: 'action', 
                orderable: false, 
                searchable: false,
                className: 'text-center'
            }
        ],
        drawCallback: function() {
            updateSummaryCards();
        }
    });

    // Update summary cards
    function updateSummaryCards() {
        var api = table.api();
        var data = api.rows().data();
        
        var totalCredit = 0;
        var totalDebit = 0;
        var totalEntries = data.length;
        
        for (var i = 0; i < data.length; i++) {
            totalCredit += parseFloat(data[i].credit || 0);
            totalDebit += parseFloat(data[i].debit || 0);
        }
        
        var netBalance = totalCredit - totalDebit;
        
        $('#totalCreditAmount').text('₹' + totalCredit.toFixed(2));
        $('#totalDebitAmount').text('₹' + totalDebit.toFixed(2));
        $('#netBalance').text('₹' + netBalance.toFixed(2));
        $('#totalEntries').text(totalEntries);
        
        // Update net balance card color based on positive/negative
        var netBalanceCard = $('#netBalance').closest('.card');
        netBalanceCard.removeClass('bg-info bg-success bg-danger');
        if (netBalance > 0) {
            netBalanceCard.addClass('bg-success');
        } else if (netBalance < 0) {
            netBalanceCard.addClass('bg-danger');
        } else {
            netBalanceCard.addClass('bg-info');
        }
    }

    // Open modal for add
    $(document).on('click', '#addBalanceSheetBtn', function() {
        $('#balanceSheetModalLabel').html('<i class="fas fa-plus mr-2"></i>Add Balance Sheet Entry');
        $('#balanceSheetModal .modal-body').html(`
            <form id="balanceSheetForm">
                @csrf
                <input type="hidden" name="id" id="balance_sheet_id">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="report_type"><i class="fas fa-tag mr-1"></i>Report Type</label>
                            <input type="text" class="form-control" name="report_type" id="report_type" 
                                   placeholder="Enter report type" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="month_year"><i class="fas fa-calendar mr-1"></i>Month-Year</label>
                            <input type="month" class="form-control" name="month_year" id="month_year" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="credit"><i class="fas fa-plus mr-1 text-success"></i>Credit Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₹</span>
                                </div>
                                <input type="number" step="0.01" class="form-control" name="credit" id="credit" 
                                       placeholder="0.00" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="debit"><i class="fas fa-minus mr-1 text-danger"></i>Debit Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₹</span>
                                </div>
                                <input type="number" step="0.01" class="form-control" name="debit" id="debit" 
                                       placeholder="0.00" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="balance"><i class="fas fa-balance-scale mr-1 text-info"></i>Balance</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₹</span>
                                </div>
                                <input type="number" step="0.01" class="form-control" name="balance" id="balance" 
                                       placeholder="0.00" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="text-right">
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                                <i class="fas fa-times mr-1"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save mr-1"></i>Save Entry
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        `);
        $('#balanceSheetModal').modal('show');
        
        // Auto-calculate balance when credit or debit changes
        $('#credit, #debit').on('input', function() {
            var credit = parseFloat($('#credit').val() || 0);
            var debit = parseFloat($('#debit').val() || 0);
            var balance = credit - debit;
            $('#balance').val(balance.toFixed(2));
        });
    });

    // Edit
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/balance-sheet/' + id + '/edit', function(data) {
            $('#balanceSheetModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Balance Sheet Entry');
            // Trigger add button to create form first
            $('#addBalanceSheetBtn').trigger('click');
            // Set values after a short delay to ensure form is rendered
            setTimeout(function() {
                $('#balance_sheet_id').val(data.id);
                $('#report_type').val(data.report_type);
                $('#month_year').val(data.month_year);
                $('#credit').val(data.credit);
                $('#debit').val(data.debit);
                $('#balance').val(data.balance);
            }, 300);
        }).fail(function() {
            toastr.error('Failed to load entry data for editing.');
        });
    });

    // Save (add or update)
    $(document).on('submit', '#balanceSheetForm', function(e) {
        e.preventDefault();
        var id = $('#balance_sheet_id').val();
        var url = id ? '/balance-sheet/' + id : '/balance-sheet';
        var formData = $(this).serialize();
        if (id) formData += '&_method=PUT';
        
        // Show loading state
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i>Saving...').prop('disabled', true);
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(res) {
                $('#balanceSheetModal').modal('hide');
                table.ajax.reload();
                toastr.success(res.message || 'Balance sheet entry saved successfully.');
            },
            error: function(xhr) {
                var message = 'Failed to save balance sheet entry.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                toastr.error(message);
            },
            complete: function() {
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Delete
    $(document).on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        var reportType = $(this).closest('tr').find('td:first').text();
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'Delete balance sheet entry for "' + reportType + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/balance-sheet/' + id,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {
                        table.ajax.reload();
                        toastr.success(res.message || 'Balance sheet entry deleted successfully.');
                    },
                    error: function() {
                        toastr.error('Failed to delete balance sheet entry.');
                    }
                });
            }
        });
    });
});
</script>
@endpush
