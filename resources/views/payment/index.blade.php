@extends('layouts.app')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 fw-bold">
                    <i class="fas fa-credit-card text-primary me-2"></i>
                    Payment Management
                </h1>
                <p class="text-muted">Manage hospital payments and financial transactions</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Payments</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Action Bar -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-list me-2"></i>Payment Records
                            </h5>
                        </div>
                        <button class="btn btn-primary btn-lg" id="addPaymentBtn">
                            <i class="fas fa-plus me-2"></i>Create New Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Payments Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h6 class="mb-0 text-dark">
                <i class="fas fa-table me-2"></i>Payment Transactions
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="paymentTable" style="width:100%">
                    <thead class="table-primary">
                        <tr>
                            <th>S No</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Ref No</th>
                            <th>Total Amount</th>
                            <th>Discount</th>
                            <th>Paid Amount</th>
                            <th>Due Amount</th>
                            <th>Narration</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@include('payment.modal')
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
let table;
$(function() {
    table = $('#paymentTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/payment',
            dataSrc: 'data'
        },
        columns: [
            { data: 'sno', name: 'sno', orderable: false, searchable: false },
            { data: 'doctor_name', name: 'doctor_name' },
            { data: 'date', name: 'date' },
            { data: 'payment_ref_no', name: 'payment_ref_no' },
            { data: 'before_due_amount', name: 'before_due_amount' },
            { data: 'discount', name: 'discount' },
            { data: 'paid_amount', name: 'paid_amount' },
            { data: 'after_due_amount', name: 'after_due_amount' },
            { data: 'narration', name: 'narration' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print', 'colvis'
        ]
    });

    $('#addPaymentBtn').click(function(){
        $('#paymentForm')[0].reset();
        $('#paymentId').val('');
        $('#paymentModalLabel').text('Add Payment');
        $('#paymentModal').modal('show');
    });

    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');
        $.get('/payment/' + id, function(payment){
            $('#paymentId').val(payment.id);
            $('#select_type').val(payment.select_type);
            $('#doctor_name').val(payment.doctor_name);
            $('#date').val(payment.date);
            $('#payment_ref_no').val(payment.payment_ref_no);
            $('#before_due_amount').val(payment.before_due_amount);
            $('#discount').val(payment.discount);
            $('#paid_amount').val(payment.paid_amount);
            $('#after_due_amount').val(payment.after_due_amount);
            $('#transaction_ref_no').val(payment.transaction_ref_no);
            $('#payment_mode').val(payment.payment_mode);
            $('#payer_bank').val(payment.payer_bank);
            $('#bank_account_number').val(payment.bank_account_number);
            $('#ifsc_code').val(payment.ifsc_code);
            $('#narration').val(payment.narration);
            $('#paymentModalLabel').text('Edit Payment');
            $('#paymentModal').modal('show');
        });
    });

    $('#paymentForm').submit(function(e){
        e.preventDefault();
        let id = $('#paymentId').val();
        let url = id ? '/payment/' + id : '/payment';
        let type = id ? 'PUT' : 'POST';
        let data = $(this).serialize();
        if (id) {
            data += '&_method=PUT';
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(){
                $('#paymentModal').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr) {
                if(xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    let msg = '';
                    Object.keys(errors).forEach(function(key){
                        msg += errors[key].join(' ') + '\n';
                    });
                    alert(msg);
                } else {
                    alert('An error occurred.');
                }
            }
        });
    });

    $(document).on('click', '.deleteBtn', function(){
        if(confirm('Delete this payment?')){
            let id = $(this).data('id');
            $.ajax({
                url: '/payment/' + id,
                type: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                success: function(){
                    table.ajax.reload();
                }
            });
        }
    });
});
</script>
@endpush 