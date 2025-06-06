@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Create Quick Receipt:</h3>
                </div>
                <div class="card-body">
                    @include('receipt.form')
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Manage Quick Receipt:</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="receiptTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Sr No</th>
                                <th>Date</th>
                                <th>Patient Name</th>
                                <th>Phone No</th>
                                <th>Amount</th>
                                <th>Check Number</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit -->
<div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="receiptModalLabel">Add/Edit Receipt</h5>
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
    var table = $('#receiptTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ route('receipt.index') }}',
            dataSrc: 'data'
        },
        columns: [
            { data: 'sno' },
            { data: 'date' },
            { data: 'patient_name' },
            { data: 'phone_no' },
            { data: 'receipt_amount' },
            { data: 'check_number' },
            { data: 'remark' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Show toastr status message
    function showStatus(type, message) {
        toastr.clear();
        if(type === 'success') toastr.success(message);
        else if(type === 'info') toastr.info(message);
        else toastr.error(message);
    }

    // Edit button handler
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/receipt/' + id, function(data) {
            $('#receipt_id').val(data.id);
            $('#select_type').val(data.select_type);
            $('#patient_name').val(data.patient_name);
            $('#date').val(data.date);
            $('#receipt_ref_no').val(data.receipt_ref_no);
            $('#before_due_amount').val(data.before_due_amount);
            $('#discount').val(data.discount);
            $('#receipt_amount').val(data.receipt_amount);
            $('#after_due_amount').val(data.after_due_amount);
            $('#transaction_ref_no').val(data.transaction_ref_no);
            $('#receipt_mode').val(data.receipt_mode);
            $('#receiver_bank').val(data.receiver_bank);
            $('#bank_account_number').val(data.bank_account_number);
            $('#ifsc_code').val(data.ifsc_code);
            $('#narration').val(data.narration);
            showStatus('info', 'Loaded for editing. Make changes and click Save.');
        }).fail(function() {
            showStatus('danger', 'Failed to load data for editing.');
        });
    });

    // Delete button handler
    $(document).on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this receipt?')) {
            $.ajax({
                url: '/receipt/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function() {
                    table.ajax.reload();
                    showStatus('success', 'Receipt deleted successfully.');
                },
                error: function() {
                    showStatus('danger', 'Failed to delete receipt.');
                }
            });
        }
    });

    // Handle form submit (add or update)
    $(document).on('submit', '#receiptForm', function(e) {
        e.preventDefault();
        var id = $('#receipt_id').val();
        var url = id ? '/receipt/' + id : '/receipt';
        var type = id ? 'PUT' : 'POST';
        var formData = $(this).serialize();
        if (id) formData += '&_method=PUT';
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(res) {
                $('#receiptForm')[0].reset();
                $('#receipt_id').val('');
                table.ajax.reload();
                showStatus('success', id ? 'Receipt updated successfully.' : 'Receipt created successfully.');
            },
            error: function(xhr) {
                showStatus('danger', 'Failed to save receipt.');
            }
        });
    });
});

// Show modal and load form
$('#addReceiptBtn').on('click', function() {
    $.get("{{ url('receipt/create') }}", function(html) {
        $('#receiptModal .modal-body').html(html);
        $('#receiptModal').modal('show');
    });
});
</script>
@endpush 