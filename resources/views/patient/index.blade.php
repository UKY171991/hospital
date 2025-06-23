@extends('layouts.app')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 fw-bold">
                    <i class="fas fa-user-injured text-primary me-2"></i>
                    Patient Management
                </h1>
                <p class="text-muted">Manage hospital patients and registrations</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Patients</li>
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
                                <i class="fas fa-list me-2"></i>Patient Directory
                            </h5>
                        </div>
                        <button class="btn btn-primary btn-lg" id="addPatientBtn">
                            <i class="fas fa-plus me-2"></i>Add New Patient
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light border-0">
            <h6 class="mb-0 text-dark">
                <i class="fas fa-filter me-2"></i>Filter Options
            </h6>
        </div>
        <div class="card-body">
            <form id="filterForm" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">From Registration Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">To Registration Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-search me-2"></i>Search Patients
                    </button>
                    <button type="button" class="btn btn-outline-secondary ms-2" id="resetFilterBtn">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Patients Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h6 class="mb-0 text-dark">
                <i class="fas fa-table me-2"></i>Patient Records
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="patientTable" style="width:100%">
                    <thead class="table-primary">
                        <tr>
                            <th>S.No</th>
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
@include('patient.modal')
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

    // DataTable
    table = $('#patientTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/patient',
            data: function(d) {
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { 
                data: 'photo', 
                name: 'photo', 
                orderable: false, 
                searchable: false,
                render: function(data) {
                    return data ? `<img src="/storage/patient_photos/${data}" height="40" class="rounded">` : '<span class="text-muted">No Photo</span>';
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
                    const isActive = row.is_active == 1;
                    const statusClass = isActive ? 'success' : 'danger';
                    const statusText = isActive ? 'Active' : 'Inactive';
                    const toggleText = isActive ? 'Deactivate' : 'Activate';
                    const toggleStatus = isActive ? 0 : 1;
                    
                    return `
                        <div class="btn-group" role="group">
                            <span class="badge badge-${statusClass}">${statusText}</span>
                            <button type="button" class="btn btn-sm btn-outline-${statusClass} toggleStatus ms-1" 
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
            emptyTable: 'No patients found',
            zeroRecords: 'No matching patients found'
        }
    });

    // Filter form submission
    $('#filterForm').submit(function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    // Reset filter
    $('#resetFilterBtn').click(function() {
        $('#from_date').val('{{ date('Y-m-d') }}');
        $('#to_date').val('{{ date('Y-m-d') }}');
        table.ajax.reload();
    });

    // Add patient button
    $('#addPatientBtn').click(function() {
        $('#patientForm')[0].reset();
        $('#patient_id').val('');
        $('#photo_preview').attr('src', '').hide();
        $('#patientModalLabel').text('Add Patient');
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
        var url = id ? '/patient/' + id : '/patient';
        var type = 'POST';
        if (id) formData.append('_method', 'PUT');
        
        $.ajax({
            url: url,
            type: type,
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                $('#patientModal').modal('hide');
                table.ajax.reload();
                // Show success message
                if(response.message) {
                    alert('Success: ' + response.message);
                } else {
                    alert('Patient saved successfully!');
                }
            },
            error: function(xhr) {
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

    // Edit button
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/patient/' + id)
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
        })
        .fail(function() {
            alert('Failed to load patient data. Please try again.');
        });
    });

    // Delete button
    $(document).on('click', '.deleteBtn', function() {
        if(confirm('Are you sure you want to delete this patient?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '/patient/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    table.ajax.reload();
                    if(response.message) {
                        alert('Success: ' + response.message);
                    } else {
                        alert('Patient deleted successfully!');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Delete failed.'));
                }
            });
        }
    });

    // Status toggle
    $(document).on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        var button = $(this);
        
        // Disable button during request
        button.prop('disabled', true);
        
        $.ajax({
            url: '/patient/toggle-status/' + id,
            type: 'POST',
            data: { 
                status: status
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                table.ajax.reload();
                if(response.message) {
                    alert('Success: ' + response.message);
                } else {
                    alert('Patient status updated successfully!');
                }
            },
            error: function(xhr) {
                console.error('Status toggle error:', xhr.status, xhr.responseText);
                if (xhr.status === 419) {
                    alert('Your session has expired. The page will be refreshed to continue.');
                    location.reload();
                } else {
                    let msg = 'Error: ';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg += xhr.responseJSON.message;
                    } else {
                        msg += 'Status update failed.';
                    }
                    alert(msg);
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