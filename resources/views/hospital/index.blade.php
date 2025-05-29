@extends('layouts.app')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Manage Hospital</h1>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-2">
                <button class="btn btn-primary btn-xs" id="addHospitalBtn"><i class="fas fa-plus"></i> Add Hospital</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" id="hospitalTable" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>S.No.</th>
                            <th>Logo</th>
                            <th>Login Details</th>
                            <th>Name</th>
                            <th>Contact No</th>
                            <th>PAN No</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@include('hospital.modal')
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
    table = $('#hospitalTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/hospitals',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'logo', name: 'logo', render: function(data){ return data ? `<img src="/storage/hospital_logos/${data}" height="40">` : ''; } },
            { data: 'login_details', name: 'login_details', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'contact_no', name: 'contact_no' },
            { data: 'pan_no', name: 'pan_no' },
            { data: 'address', name: 'address' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print', 'colvis']
    });

    $('#addHospitalBtn').click(function(){
        $('#hospitalForm')[0].reset();
        $('#hospitalId').val('');
        $('#logoPreview').attr('src', '');
        $('#hospitalModalLabel').text('Add Hospital');
        $('#hospitalModal').modal('show');
    });

    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');
        $.get('/hospitals/' + id, function(hospital){
            $('#hospitalId').val(hospital.id || '');
            $('#logoPreview').attr('src', hospital.logo ? '/storage/' + hospital.logo : '');
            $('#username').val(hospital.username || '');
            $('#password').val('');
            $('#passcode').val(hospital.passcode || '');
            $('#name').val(hospital.name || '');
            $('#contact_no').val(hospital.contact_no || '');
            $('#pan_no').val(hospital.pan_no || '');
            $('#address').val(hospital.address || '');
            $('#email').val(hospital.email || '');
            $('#hospital_tag_line').val(hospital.hospital_tag_line || '');
            $('#bank_name').val(hospital.bank_name || '').trigger('change');
            $('#branch_name').val(hospital.branch_name || '');
            $('#ifsc_code').val(hospital.ifsc_code || '');
            $('#account_no').val(hospital.account_no || '');
            $('#gstin_no').val(hospital.gstin_no || '');
            $('#cin_no').val(hospital.cin_no || '');
            $('#hospital_prefix').val(hospital.hospital_prefix || '');
            $('#signaturePreview').attr('src', hospital.signature ? '/storage/' + hospital.signature : '');
            $('#stampPreview').attr('src', hospital.stamp ? '/storage/' + hospital.stamp : '');
            $('#paymentQrPreview').attr('src', hospital.payment_qr ? '/storage/' + hospital.payment_qr : '');
            $('#letterHeadPreview').attr('src', hospital.letter_head ? '/storage/' + hospital.letter_head : '');
            $('#idcardDesignPreview').attr('src', hospital.idcard_design ? '/storage/' + hospital.idcard_design : '');
            $('#hospitalModalLabel').text('Edit Hospital');
            $('#hospitalModal').modal('show');
        });
    });

    $(document).on('click', '.viewBtn', function(){
        let id = $(this).data('id');
        $.get('/hospitals/' + id, function(hospital){
            $('#viewHospitalId').val(hospital.id);
            $('#view_logoPreview').attr('src', hospital.logo ? '/storage/' + hospital.logo : '');
            $('#view_username').val(hospital.username);
            $('#view_passcode').val(hospital.passcode);
            $('#view_name').val(hospital.name);
            $('#view_contact_no').val(hospital.contact_no);
            $('#view_pan_no').val(hospital.pan_no);
            $('#view_address').val(hospital.address);
            $('#view_email').val(hospital.email);
            $('#view_hospital_tag_line').val(hospital.hospital_tag_line);
            $('#view_bank_name').val(hospital.bank_name);
            $('#view_branch_name').val(hospital.branch_name);
            $('#view_ifsc_code').val(hospital.ifsc_code);
            $('#view_account_no').val(hospital.account_no);
            $('#view_gstin_no').val(hospital.gstin_no);
            $('#view_cin_no').val(hospital.cin_no);
            $('#view_hospital_prefix').val(hospital.hospital_prefix);
            $('#view_signaturePreview').attr('src', hospital.signature ? '/storage/' + hospital.signature : '');
            $('#view_stampPreview').attr('src', hospital.stamp ? '/storage/' + hospital.stamp : '');
            $('#view_paymentQrPreview').attr('src', hospital.payment_qr ? '/storage/' + hospital.payment_qr : '');
            $('#view_letterHeadPreview').attr('src', hospital.letter_head ? '/storage/' + hospital.letter_head : '');
            $('#view_idcardDesignPreview').attr('src', hospital.idcard_design ? '/storage/' + hospital.idcard_design : '');
            $('#viewHospitalModal').modal('show');
        });
    });

    $(document).on('click', '.deleteBtn', function(){
        if(confirm('Are you sure you want to delete this hospital?')){
            let id = $(this).data('id');
            $.ajax({
                url: '/hospitals/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(){
                    table.ajax.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON.message || 'An error occurred.'));
                }
            });
        }
    });

    $('#hospitalForm').submit(function(e){
        e.preventDefault();
        let id = $('#hospitalId').val();
        let url = id ? '/hospitals/' + id : '/hospitals';
        let type = 'POST';
        let formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(){
                $('#hospitalModal').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON.message || 'An error occurred.'));
            }
        });
    });
});
</script>
@endpush
