@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-chart-bar mr-2"></i>Patient Report</h1>
            <p class="text-muted">View and analyze patient data reports</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Patient Report</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Filter Section -->
    <div class="card card-primary card-outline mb-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter mr-2"></i>Report Filters
            </h3>
        </div>
        <div class="card-body">
            <form id="patientFilterForm" class="row align-items-end">
                <div class="col-md-3">
                    <label class="font-weight-bold">Report Type<span class="text-danger">*</span></label>
                    <select class="form-control" name="report_type" required>
                        <option value="OPD">OPD (Out Patient Dept.)</option>
                        <option value="IPD">IPD (In Patient Dept.)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold">Report Type<span class="text-danger">*</span></label>
                    <select class="form-control" name="report_type2" required>
                        <option value="Today-Report">Today-Report</option>
                        <option value="All">All</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold">From Date</label>
                    <input type="date" class="form-control" name="from_date" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-search mr-2"></i>Search Report
                    </button>
                    <button type="button" class="btn btn-outline-secondary ml-2" id="resetFilter">
                        <i class="fas fa-undo mr-2"></i>Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-table mr-2"></i>Patient Report Data
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm" id="addPatientBtn">
                    <i class="fas fa-plus mr-2"></i>Add New Entry
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="patientTable" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Patient Name</th>
                            <th>Patient Id</th>
                            <th>Relation Name</th>
                            <th>Mobile</th>
                            <th>Reg. Date</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit -->
<div class="modal fade" id="patientModal" tabindex="-1" role="dialog" aria-labelledby="patientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="patientModalLabel">
          <i class="fas fa-user-injured mr-2"></i>Add/Edit Patient Entry
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form will be loaded here dynamically -->
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
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

    // DataTable
    var table = $('#patientTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/patients',
            data: function(d) {
                d.report_type = $('select[name="report_type"]').val();
                d.report_type2 = $('select[name="report_type2"]').val();
                d.from_date = $('input[name="from_date"]').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'patient_id', name: 'patient_id' },
            { data: 'relation_name', name: 'relation_name' },
            { data: 'mobile', name: 'mobile' },
            { data: 'reg_date', name: 'reg_date' },
            { data: 'address', name: 'address' },
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
            emptyTable: 'No patient records found',
            zeroRecords: 'No matching patient records found'
        }
    });

    // Open modal for add
    $('#addPatientBtn').click(function() {
        $('#patientModalLabel').html('<i class="fas fa-user-injured mr-2"></i>Add Patient Entry');
        $('#patientModal .modal-body').html(`
            <form id="patientForm">
                @csrf
                <input type="hidden" name="id" id="patient_id">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Patient Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Patient ID</label>
                            <input type="text" class="form-control" name="patient_id" id="patient_id_field">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Gender <span class="text-danger">*</span></label>
                            <select class="form-control" name="gender" id="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Blood Group <span class="text-danger">*</span></label>
                            <select class="form-control" name="blood_group" id="blood_group" required>
                                <option value="">Select Blood Group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Color Vision <span class="text-danger">*</span></label>
                            <select class="form-control" name="color_vision" id="color_vision" required>
                                <option value="">Select Color Vision</option>
                                <option value="Normal">Normal</option>
                                <option value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Mobile</label>
                            <input type="text" class="form-control" name="mobile" id="mobile">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Relation Name</label>
                            <input type="text" class="form-control" name="relation_name" id="relation_name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Registration Date</label>
                            <input type="date" class="form-control" name="reg_date" id="reg_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Address</label>
                    <textarea class="form-control" name="address" id="address" rows="2"></textarea>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Close
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-2"></i>Save Patient
                    </button>
                </div>
            </form>
        `);
        $('#patientModal').modal('show');
    });

    // Open modal for edit
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        toastr.info('Loading patient data...');
        $.get('/patients/' + id, function(data) {
            $('#patientModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Patient Entry');
            $('#patientModal .modal-body').html(`
                <form id="patientForm">
                    @csrf
                    <input type="hidden" name="id" id="patient_id" value="${data.id}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Patient Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="${data.name || ''}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Patient ID</label>
                                <input type="text" class="form-control" name="patient_id" id="patient_id_field" value="${data.patient_id || ''}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Gender <span class="text-danger">*</span></label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" ${data.gender === 'Male' ? 'selected' : ''}>Male</option>
                                    <option value="Female" ${data.gender === 'Female' ? 'selected' : ''}>Female</option>
                                    <option value="Other" ${data.gender === 'Other' ? 'selected' : ''}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Blood Group <span class="text-danger">*</span></label>
                                <select class="form-control" name="blood_group" id="blood_group" required>
                                    <option value="">Select Blood Group</option>
                                    <option value="A+" ${data.blood_group === 'A+' ? 'selected' : ''}>A+</option>
                                    <option value="A-" ${data.blood_group === 'A-' ? 'selected' : ''}>A-</option>
                                    <option value="B+" ${data.blood_group === 'B+' ? 'selected' : ''}>B+</option>
                                    <option value="B-" ${data.blood_group === 'B-' ? 'selected' : ''}>B-</option>
                                    <option value="O+" ${data.blood_group === 'O+' ? 'selected' : ''}>O+</option>
                                    <option value="O-" ${data.blood_group === 'O-' ? 'selected' : ''}>O-</option>
                                    <option value="AB+" ${data.blood_group === 'AB+' ? 'selected' : ''}>AB+</option>
                                    <option value="AB-" ${data.blood_group === 'AB-' ? 'selected' : ''}>AB-</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Color Vision <span class="text-danger">*</span></label>
                                <select class="form-control" name="color_vision" id="color_vision" required>
                                    <option value="">Select Color Vision</option>
                                    <option value="Normal" ${data.color_vision === 'Normal' ? 'selected' : ''}>Normal</option>
                                    <option value="Abnormal" ${data.color_vision === 'Abnormal' ? 'selected' : ''}>Abnormal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Mobile</label>
                                <input type="text" class="form-control" name="mobile" id="mobile" value="${data.mobile || ''}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Relation Name</label>
                                <input type="text" class="form-control" name="relation_name" id="relation_name" value="${data.relation_name || ''}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Registration Date</label>
                                <input type="date" class="form-control" name="reg_date" id="reg_date" value="${data.reg_date || ''}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Address</label>
                        <textarea class="form-control" name="address" id="address" rows="2">${data.address || ''}</textarea>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i>Close
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-2"></i>Update Patient
                        </button>
                    </div>
                </form>
            `);
            $('#patientModal').modal('show');
            toastr.success('Patient data loaded successfully!');
        }).fail(function() {
            toastr.error('Failed to load patient data. Please try again.');
        });
    });

    // Save (add or update)
    $(document).on('submit', '#patientForm', function(e) {
        e.preventDefault();
        var id = $('#patient_id').val();
        var url = id ? '/patients/' + id : '/patients';
        var formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');
        
        toastr.info('Saving patient...');
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                $('#patientModal').modal('hide');
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
                    toastr.error(xhr.responseJSON?.message || 'Failed to save patient entry.');
                }
            }
        });
    });

    // Delete
    $(document).on('click', '.deleteBtn', function() {
        toastr.warning('Are you sure you want to delete this patient?<br><br><button type="button" class="btn btn-sm btn-light" onclick="toastr.clear()">Cancel</button>&nbsp;<button type="button" class="btn btn-sm btn-danger" onclick="confirmDeletePatientReport(' + $(this).data('id') + ')">Delete</button>', 'Confirm Delete', {
            allowHtml: true,
            closeButton: false,
            timeOut: 0,
            extendedTimeOut: 0
        });
    });

    // Confirm delete function
    function confirmDeletePatientReport(id) {
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
                toastr.error(xhr.responseJSON?.message || 'Failed to delete patient entry.');
            }
        });
    }

    // Make function global
    window.confirmDeletePatientReport = confirmDeletePatientReport;

    // Filter/search form
    $('#patientFilterForm').submit(function(e) {
        e.preventDefault();
        table.ajax.reload();
        toastr.info('Applying filters...');
    });

    // Reset filter
    $('#resetFilter').click(function() {
        $('#patientFilterForm')[0].reset();
        $('input[name="from_date"]').val('{{ date('Y-m-d') }}');
        table.ajax.reload();
        toastr.info('Filters reset');
    });
});
</script>
@endpush