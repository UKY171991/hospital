@extends('layouts.app')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 fw-bold">
                    <i class="fas fa-hospital text-primary me-2"></i>
                    Hospital Management
                </h1>
                <p class="text-muted">Manage hospital information and settings</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Hospitals</li>
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
                                <i class="fas fa-list me-2"></i>Hospital Directory
                            </h5>
                        </div>
                        <button class="btn btn-primary btn-lg" id="addHospitalBtn">
                            <i class="fas fa-plus me-2"></i>Add New Hospital
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Hospitals Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h6 class="mb-0 text-dark">
                <i class="fas fa-table me-2"></i>Hospital Records
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="hospitalTable" style="width:100%">
                    <thead class="table-primary">
                        <tr>
                            <th>S.No.</th>
                            <th>Logo</th>
                            <th>Login Details</th>
                            <th>Name</th>
                            <th>Contact No</th>
                            <th>PAN No</th>
                            <th>Address</th>
                            <th>Actions</th>
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
    // Global AJAX setup for CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Global AJAX error handler for session expiry
    $(document).ajaxError(function(event, xhr, settings, thrownError) {
        if (xhr.status === 419) {
            alert('Your session has expired. The page will be refreshed to continue.');
            location.reload();
        }
    });

    table = $('#hospitalTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/hospitals',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { 
                data: 'logo', 
                name: 'logo', 
                orderable: false,
                render: function(data){ 
                    return data ? `<img src="/storage/hospital_logos/${data}" height="40" class="rounded">` : '<span class="text-muted">No Logo</span>'; 
                } 
            },
            { data: 'login_details', name: 'login_details', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'contact_no', name: 'contact_no' },
            { data: 'pan_no', name: 'pan_no' },
            { data: 'address', name: 'address' },
            { 
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row){
                    return `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-info editBtn" data-id="${row.id}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary viewBtn" data-id="${row.id}" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${row.id}" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn-success'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn-danger'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn-info'
            },
            {
                extend: 'colvis',
                text: '<i class="fas fa-columns"></i> Columns',
                className: 'btn-secondary'
            }
        ],
        responsive: true,
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
            emptyTable: 'No hospitals found',
            zeroRecords: 'No matching hospitals found'
        }
    });    $('#addHospitalBtn').click(function(){
        $('#hospitalForm')[0].reset();
        $('#hospitalId').val('');
        // Clear all preview images
        $('#logoPreview').attr('src', '').hide();
        $('#signaturePreview').attr('src', '').hide();
        $('#stampPreview').attr('src', '').hide();
        $('#paymentQrPreview').attr('src', '').hide();
        $('#letterHeadPreview').attr('src', '').hide();
        $('#idcardDesignPreview').attr('src', '').hide();
        $('#hospitalModalLabel').text('Add Hospital');
        $('#hospitalModal').modal('show');
    });

    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');
        $.get('/hospitals/' + id)
        .done(function(hospital){
            $('#hospitalId').val(hospital.id || '');
            if(hospital.logo) {
                $('#logoPreview').attr('src', '/storage/hospital_logos/' + hospital.logo).show();
            } else {
                $('#logoPreview').attr('src', '').hide();
            }
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
            
            if(hospital.signature) {
                $('#signaturePreview').attr('src', '/storage/hospital_logos/' + hospital.signature).show();
            } else {
                $('#signaturePreview').attr('src', '').hide();
            }
            if(hospital.stamp) {
                $('#stampPreview').attr('src', '/storage/hospital_logos/' + hospital.stamp).show();
            } else {
                $('#stampPreview').attr('src', '').hide();
            }
            if(hospital.payment_qr) {
                $('#paymentQrPreview').attr('src', '/storage/hospital_logos/' + hospital.payment_qr).show();
            } else {
                $('#paymentQrPreview').attr('src', '').hide();
            }
            if(hospital.letter_head) {
                $('#letterHeadPreview').attr('src', '/storage/hospital_logos/' + hospital.letter_head).show();
            } else {
                $('#letterHeadPreview').attr('src', '').hide();
            }
            if(hospital.idcard_design) {
                $('#idcardDesignPreview').attr('src', '/storage/hospital_logos/' + hospital.idcard_design).show();
            } else {
                $('#idcardDesignPreview').attr('src', '').hide();
            }
            
            $('#hospitalModalLabel').text('Edit Hospital');
            $('#hospitalModal').modal('show');
        })
        .fail(function(){
            alert('Failed to load hospital data. Please try again.');
        });
    });

    $(document).on('click', '.viewBtn', function(){
        let id = $(this).data('id');
        $.get('/hospitals/' + id, function(hospital){
            $('#viewHospitalId').val(hospital.id);
            $('#view_logoPreview').attr('src', hospital.logo ? '/storage/hospital_logos/' + hospital.logo : '');
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
            $('#view_signaturePreview').attr('src', hospital.signature ? '/storage/hospital_logos/' + hospital.signature : '');
            $('#view_stampPreview').attr('src', hospital.stamp ? '/storage/hospital_logos/' + hospital.stamp : '');
            $('#view_paymentQrPreview').attr('src', hospital.payment_qr ? '/storage/hospital_logos/' + hospital.payment_qr : '');
            $('#view_letterHeadPreview').attr('src', hospital.letter_head ? '/storage/hospital_logos/' + hospital.letter_head : '');
            $('#view_idcardDesignPreview').attr('src', hospital.idcard_design ? '/storage/hospital_logos/' + hospital.idcard_design : '');
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
        let type = 'POST';        let formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');
        
        $.ajax({
            url: url,
            type: type,
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },            success: function(response){
                $('#hospitalModal').modal('hide');
                table.ajax.reload();
                // Show success message
                if(response.message) {
                    alert('Success: ' + response.message);
                } else {
                    alert('Hospital saved successfully!');
                }
            },            error: function(xhr) {
                let msg = 'Error: ';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // Laravel validation errors
                    for (const key in xhr.responseJSON.errors) {
                        msg += `\n${xhr.responseJSON.errors[key].join(' ')}`;
                    }
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg += xhr.responseJSON.message;
                } else {
                    msg += 'An error occurred.';
                }
                alert(msg);
            }
        });
    });

    // Live preview for image fields in add/edit modal
    $('#hospitalForm input[type="file"]').on('change', function() {
        const input = this;
        const previewId = '#' + $(input).attr('name') + 'Preview';
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $(previewId).attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            $(previewId).attr('src', '');
        }
    });
});
</script>
@endpush
