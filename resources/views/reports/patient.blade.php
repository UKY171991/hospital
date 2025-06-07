@extends('layouts.app')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Patient Report</h1>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body">
            <form id="patientFilterForm" class="form-row align-items-end">
                <div class="form-group col-md-3">
                    <label>Report Type<span class="text-danger">*</span></label>
                    <select class="form-control" name="report_type" required>
                        <option value="OPD">OPD (Out Patient Dept.)</option>
                        <option value="IPD">IPD (In Patient Dept.)</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Report Type<span class="text-danger">*</span></label>
                    <select class="form-control" name="report_type2" required>
                        <option value="Today-Report">Today-Report</option>
                        <option value="All">All</option>
                    </select>
                </div>
                <div class="form-group col-md-2"></div>
                <div class="form-group col-md-2"></div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-success btn-block"><i class="fas fa-search"></i> Search Report</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="patientTable">
                    <thead class="bg-danger text-white">
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
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit (structure only) -->
<div class="modal fade" id="patientModal" tabindex="-1" role="dialog" aria-labelledby="patientModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="patientModalLabel">Add/Edit Patient Entry</h5>
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
    var table = $('#patientTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/patients', // To be implemented
            dataSrc: 'data'
        },
        columns: [
            { data: 'sno' },
            { data: 'patient_name' },
            { data: 'patient_id' },
            { data: 'relation_name' },
            { data: 'mobile' },
            { data: 'reg_date' },
            { data: 'address' },
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
    $(document).on('click', '#addPatientBtn', function() {
        $('#patientModalLabel').text('Add Patient Entry');
        $('#patientModal .modal-body').html(`
            <form id="patientForm">
                @csrf
                <input type="hidden" name="id" id="patient_id">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select class="form-control" name="gender" id="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Blood Group</label>
                    <input type="text" class="form-control" name="blood_group" id="blood_group" required>
                </div>
                <div class="form-group">
                    <label>Color Vision</label>
                    <input type="text" class="form-control" name="color_vision" id="color_vision" required>
                </div>
                <div class="form-group">
                    <label>Patient Name</label>
                    <input type="text" class="form-control" name="patient_name" id="patient_name">
                </div>
                <div class="form-group">
                    <label>Patient Id</label>
                    <input type="text" class="form-control" name="patient_id_field" id="patient_id_field">
                </div>
                <div class="form-group">
                    <label>Relation Name</label>
                    <input type="text" class="form-control" name="relation_name" id="relation_name">
                </div>
                <div class="form-group">
                    <label>Mobile</label>
                    <input type="text" class="form-control" name="mobile" id="mobile">
                </div>
                <div class="form-group">
                    <label>Reg. Date</label>
                    <input type="date" class="form-control" name="reg_date" id="reg_date">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" name="address" id="address">
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        `);
        $('#patientModal').modal('show');
    });

    // Open modal for edit
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/patients/' + id, function(data) {
            $('#patientModalLabel').text('Edit Patient Entry');
            $('#patientModal .modal-body').html(`
                <form id="patientForm">
                    @csrf
                    <input type="hidden" name="id" id="patient_id" value="${data.id}">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="${data.name}" required>
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select class="form-control" name="gender" id="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" ${data.gender === 'Male' ? 'selected' : ''}>Male</option>
                            <option value="Female" ${data.gender === 'Female' ? 'selected' : ''}>Female</option>
                            <option value="Other" ${data.gender === 'Other' ? 'selected' : ''}>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Blood Group</label>
                        <input type="text" class="form-control" name="blood_group" id="blood_group" value="${data.blood_group}" required>
                    </div>
                    <div class="form-group">
                        <label>Color Vision</label>
                        <input type="text" class="form-control" name="color_vision" id="color_vision" value="${data.color_vision}" required>
                    </div>
                    <div class="form-group">
                        <label>Patient Name</label>
                        <input type="text" class="form-control" name="patient_name" id="patient_name" value="${data.patient_name}" required>
                    </div>
                    <div class="form-group">
                        <label>Patient Id</label>
                        <input type="text" class="form-control" name="patient_id_field" id="patient_id_field" value="${data.patient_id}" required>
                    </div>
                    <div class="form-group">
                        <label>Relation Name</label>
                        <input type="text" class="form-control" name="relation_name" id="relation_name" value="${data.relation_name || ''}">
                    </div>
                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" class="form-control" name="mobile" id="mobile" value="${data.mobile}">
                    </div>
                    <div class="form-group">
                        <label>Reg. Date</label>
                        <input type="date" class="form-control" name="reg_date" id="reg_date" value="${data.reg_date}">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" id="address" value="${data.address}">
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            `);
            $('#patientModal').modal('show');
        });
    });

    // Save (add or update)
    $(document).on('submit', '#patientForm', function(e) {
        e.preventDefault();
        var id = $('#patient_id').val();
        var url = id ? '/patients/' + id : '/patients';
        var type = id ? 'PUT' : 'POST';
        var formData = $(this).serialize();
        if (id) formData += '&_method=PUT';
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(res) {
                $('#patientModal').modal('hide');
                table.ajax.reload();
                showStatus('success', res.message);
            },
            error: function(xhr) {
                showStatus('danger', 'Failed to save patient entry.');
            }
        });
    });

    // Delete
    $(document).on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this entry?')) {
            $.ajax({
                url: '/patients/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    table.ajax.reload();
                    showStatus('success', res.message);
                },
                error: function() {
                    showStatus('danger', 'Failed to delete patient entry.');
                }
            });
        }
    });

    // Filter/search form
    $('#patientFilterForm').submit(function(e) {
        e.preventDefault();
        table.ajax.reload();
    });
});
</script>
@endpush 