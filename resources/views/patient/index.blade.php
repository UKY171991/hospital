@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-user-injured mr-2"></i>Patient Management</h1>
            <p class="text-muted">Manage hospital patients and registrations</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Patients</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>Patient Directory
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" id="addPatientBtn">
                            <i class="fas fa-plus mr-2"></i>Add New Patient
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="patientTable" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Sr No</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Patient ID</th>
                                <th>Relation Name</th>
                                <th>Mobile</th>
                                <th>Reg. Date</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('patient.modal')
@endsection

@push('scripts')
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
            toastr.error('Your session has expired. The page will be refreshed to continue.');
            setTimeout(() => location.reload(), 2000);
        }
    });

    // Reset form
    function resetForm() {
        $('#patientForm')[0].reset();
        $('#patient_id').val('');
        $('#photo_preview').attr('src', '').hide();
        $('#patientModalLabel').text('Add Patient');
    }

    // DataTable
    table = $('#patientTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/patients',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { 
                data: 'photo', 
                name: 'photo', 
                orderable: false, 
                searchable: false,
                render: function(data) {
                    return data ? 
                        `<img src="/storage/patient_photos/${data}" height="40" class="rounded img-thumbnail">` : 
                        '<span class="badge badge-secondary">No Photo</span>';
                }
            },
            { data: 'name', name: 'name' },
            { data: 'patient_id', name: 'patient_id' },
            { data: 'relation_name', name: 'relation_name' },
            { data: 'mobile', name: 'mobile' },
            { data: 'reg_date', name: 'reg_date' },
            { data: 'address', name: 'address' },
            { 
                data: 'status', 
                name: 'status', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row) {
                    const isActive = row.status === 'Active' || row.is_active == 1;
                    const statusClass = isActive ? 'success' : 'danger';
                    const statusText = isActive ? 'Active' : 'Inactive';
                    const toggleText = isActive ? 'Deactivate' : 'Activate';
                    const toggleStatus = isActive ? 'Inactive' : 'Active';
                    
                    return `
                        <div class="btn-group" role="group">
                            <span class="badge badge-${statusClass}">${statusText}</span>
                            <button type="button" class="btn btn-sm btn-outline-${statusClass} toggleStatus ml-1" 
                                    data-id="${row.id}" data-status="${toggleStatus}" title="${toggleText}">
                                <i class="fas fa-toggle-${isActive ? 'on' : 'off'}"></i>
                            </button>
                        </div>
                    `;
                }
            },
            { 
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row) {
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
        responsive: true,
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
            emptyTable: 'No patients found',
            zeroRecords: 'No matching patients found'
        }
    });

    // Add patient button
    $('#addPatientBtn').click(function() {
        resetForm();
        $('#patientModal').modal('show');
    });

    // Photo preview
    $('#photo').change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#photo_preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            $('#photo_preview').attr('src', '').hide();
        }
    });

    // Submit form (add/update)
    $('#patientForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var id = $('#patient_id').val();
        var url = id ? '/patients/' + id : '/patients';
        var type = 'POST';
        if (id) formData.append('_method', 'PUT');
        
        toastr.info('Saving patient...');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                $('#patientModal').modal('hide');
                resetForm();
                table.ajax.reload();
                toastr.success(response.message || 'Patient saved successfully!');
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errorMessages = [];
                    for (const key in xhr.responseJSON.errors) {
                        errorMessages.push(xhr.responseJSON.errors[key].join(' '));
                    }
                    toastr.error(errorMessages.join('<br>'));
                } else {
                    toastr.error(xhr.responseJSON?.message || 'An error occurred.');
                }
            }
        });
    });

    // Edit button
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        toastr.info('Loading patient data...');
        $.get('/patients/' + id)
        .done(function(data) {
            $('#patient_id').val(data.id || '');
            $('#patient_type').val(data.patient_type || 'General (OPD)');
            $('#relative_title').val(data.relative_title || 'Mr.');
            $('#name').val(data.name || '');
            $('#relation_name').val(data.relation_name || '');
            $('#relation_of_relative').val(data.relation_of_relative || 'S/O');
            $('#reference_doctor').val(data.reference_doctor || '');
            $('#mobile').val(data.mobile || '');
            $('#reg_date').val(data.reg_date || '');
            $('#gender').val(data.gender || 'Male');
            $('#address').val(data.address || '');
            $('#age').val(data.age || '');
            $('#aadhar_no').val(data.aadhar_no || '');
            $('#card_no').val(data.card_no || '');
            $('#height_cm').val(data.height_cm || '');
            $('#weight_kg').val(data.weight_kg || '');
            $('#blood_group').val(data.blood_group || 'A+');
            $('#color_vision').val(data.color_vision || 'Normal');
            
            if (data.photo) {
                $('#photo_preview').attr('src', '/storage/patient_photos/' + data.photo).show();
            } else {
                $('#photo_preview').attr('src', '').hide();
            }
            $('#patientModalLabel').text('Update Patient');
            $('#patientModal').modal('show');
            toastr.success('Patient data loaded successfully!');
        })
        .fail(function() {
            toastr.error('Failed to load patient data. Please try again.');
        });
    });

    // Delete button
    $(document).on('click', '.deleteBtn', function() {
        toastr.warning('Are you sure you want to delete this patient?<br><br><button type="button" class="btn btn-sm btn-light" onclick="toastr.clear()">Cancel</button>&nbsp;<button type="button" class="btn btn-sm btn-danger" onclick="confirmDeletePatient(' + $(this).data('id') + ')">Delete</button>', 'Confirm Delete', {
            allowHtml: true,
            closeButton: false,
            timeOut: 0,
            extendedTimeOut: 0
        });
    });

    // Confirm delete function
    function confirmDeletePatient(id) {
        toastr.clear();
        toastr.info('Deleting patient...');
        $.ajax({
            url: '/patients/' + id,
            type: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                table.ajax.reload();
                toastr.success(response.message || 'Patient deleted successfully!');
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Delete failed.');
            }
        });
    }

    // Make confirmDeletePatient function global
    window.confirmDeletePatient = confirmDeletePatient;

    // Status toggle
    $(document).on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        var button = $(this);
        
        // Disable button during request
        button.prop('disabled', true);
        
        toastr.info('Updating patient status...');
        
        $.ajax({
            url: '/patients/toggle-status/' + id,
            type: 'POST',
            data: { 
                status: status
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                table.ajax.reload();
                toastr.success(response.message || 'Patient status updated successfully!');
            },
            error: function(xhr) {
                console.error('Status toggle error:', xhr.status, xhr.responseText);
                if (xhr.status === 419) {
                    toastr.error('Your session has expired. The page will be refreshed to continue.');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Status update failed.');
                }
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    });
});
</script>
@endpush