@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Receipt Management</h1>
        </div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-primary" id="addReceiptBtn">Add Receipt</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="receiptTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Ref No</th>
                        <th>Before Due</th>
                        <th>Discount</th>
                        <th>Amount</th>
                        <th>After Due</th>
                        <th>Mode</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Placeholder -->
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
            { data: 'select_type' },
            { data: 'patient_name' },
            { data: 'date' },
            { data: 'receipt_ref_no' },
            { data: 'before_due_amount' },
            { data: 'discount' },
            { data: 'receipt_amount' },
            { data: 'after_due_amount' },
            { data: 'receipt_mode' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    // Add/Edit/Delete JS handlers will go here
    // ...
});

// Show modal and load form
$('#addReceiptBtn').on('click', function() {
    $.get("{{ url('receipt/create') }}", function(html) {
        $('#receiptModal .modal-body').html(html);
        $('#receiptModal').modal('show');
    });
});

// Handle form submit
$(document).on('submit', '#receiptForm', function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: "{{ route('receipt.store') }}",
        method: "POST",
        data: formData,
        success: function(res) {
            $('#receiptModal').modal('hide');
            $('#receiptTable').DataTable().ajax.reload();
        },
        error: function(xhr) {
            alert('Error: ' + (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Unknown error'));
        }
    });
});
</script>
@endpush 