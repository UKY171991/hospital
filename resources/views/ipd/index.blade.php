@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-bed mr-2"></i>IPD Management</h1>
            <p class="text-muted">Manage inpatient department admissions and discharges</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">IPD</li>
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
            <div class="card shadow-sm">
                <div class="card-body py-2">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-list mr-2"></i>IPD Patient List
                        </h5>
                        <div class="btn-group" role="group">
                            <button class="btn btn-primary" id="addIpdBtn">
                                <i class="fas fa-plus mr-1"></i>Add IPD Patient
                            </button>
                            <button class="btn btn-warning" id="dischargedBtn">
                                <i class="fas fa-sign-out-alt mr-1"></i>Discharged Patients
                            </button>
                            <button class="btn btn-success" id="newReceiptBtn">
                                <i class="fas fa-receipt mr-1"></i>New Receipt
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-filter mr-2"></i>Filter Options</h6>
        </div>
        <div class="card-body">
            <form id="filterForm" class="row align-items-end">
                <div class="col-md-4 mb-2">
                    <label for="from_date"><i class="fas fa-calendar mr-1"></i>From Date</label>
                    <input type="datetime-local" name="from_date" id="from_date" class="form-control" value="{{ date('Y-m-d\TH:i') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="to_date"><i class="fas fa-calendar mr-1"></i>To Date</label>
                    <input type="datetime-local" name="to_date" id="to_date" class="form-control" value="{{ date('Y-m-d\TH:i') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-search mr-1"></i>Search Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- IPD Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0"><i class="fas fa-table mr-2"></i>IPD Patients</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="ipdTable" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th><i class="fas fa-cogs"></i> Action</th>
                            <th>S.No</th>
                            <th>IPD No</th>
                            <th>UHID No</th>
                            <th><i class="fas fa-user"></i> Patient Name</th>
                            <th><i class="fas fa-user-friends"></i> Attendant Name</th>
                            <th><i class="fas fa-phone"></i> Attendant Mobile</th>
                            <th>Second Attendant Name</th>
                            <th>Second Attendant Mobile</th>
                            <th><i class="fas fa-calendar-plus"></i> Admission Date</th>
                            <th><i class="fas fa-calendar-minus"></i> Discharge Date</th>
                            <th><i class="fas fa-user-md"></i> Doctor Name</th>
                            <th><i class="fas fa-disease"></i> Disease</th>
                            <th><i class="fas fa-building"></i> Department</th>
                            <th><i class="fas fa-door-open"></i> Ward Name</th>
                            <th><i class="fas fa-hashtag"></i> Room No</th>
                            <th><i class="fas fa-bed"></i> Bed No</th>
                        <th>Employee</th>
                        <th>Bill No</th>
                        <th>Insurance</th>
                        <th>Insurance Name</th>
                        <th>Policy Id</th>
                        <th>Policy Holder Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit IPD Modal -->
<div class="modal fade" id="ipdModal" tabindex="-1" role="dialog" aria-labelledby="ipdModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ipdModalLabel">Add/Update IPD Patient</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="ipdForm">
        @csrf
        <input type="hidden" name="id" id="ipd_id">
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label>IPD No</label>
              <input type="text" name="ipd_no" id="ipd_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>UHID No</label>
              <input type="text" name="uhid_no" id="uhid_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Patient Name <span class="text-danger">*</span></label>
              <input type="text" name="patient_name" id="patient_name" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Attendant Name</label>
              <input type="text" name="attendant_name" id="attendant_name" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Attendant Mobile</label>
              <input type="text" name="attendant_mobile" id="attendant_mobile" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Second Attendant Name</label>
              <input type="text" name="second_attendant_name" id="second_attendant_name" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Second Attendant Mobile</label>
              <input type="text" name="second_attendant_mobile" id="second_attendant_mobile" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Admission Date <span class="text-danger">*</span></label>
              <input type="datetime-local" name="admission_date" id="admission_date" class="form-control" required value="{{ date('Y-m-d\TH:i') }}">
            </div>
            <div class="form-group col-md-3">
              <label>Discharge Date</label>
              <input type="datetime-local" name="discharge_date" id="discharge_date" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Doctor Name <span class="text-danger">*</span></label>
              <input type="text" name="doctor_name" id="doctor_name" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Disease <span class="text-danger">*</span></label>
              <input type="text" name="disease" id="disease" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Department <span class="text-danger">*</span></label>
              <input type="text" name="department" id="department" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Ward Name <span class="text-danger">*</span></label>
              <input type="text" name="ward_name" id="ward_name" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Room No</label>
              <input type="text" name="room_no" id="room_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Bed No</label>
              <input type="text" name="bed_no" id="bed_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Employee</label>
              <input type="text" name="employee" id="employee" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Bill No</label>
              <input type="text" name="bill_no" id="bill_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Insurance</label>
              <input type="text" name="insurance" id="insurance" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Insurance Name</label>
              <input type="text" name="insurance_name" id="insurance_name" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Policy Id</label>
              <input type="text" name="policy_id" id="policy_id" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Policy Holder Name</label>
              <input type="text" name="policy_holder_name" id="policy_holder_name" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('#ipdTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/ipd',
            data: function(d) {
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },
        columns: [
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'ipd_no', name: 'ipd_no' },
            { data: 'uhid_no', name: 'uhid_no' },
            { data: 'patient_name', name: 'patient_name' },
            { data: 'attendant_name', name: 'attendant_name' },
            { data: 'attendant_mobile', name: 'attendant_mobile' },
            { data: 'second_attendant_name', name: 'second_attendant_name' },
            { data: 'second_attendant_mobile', name: 'second_attendant_mobile' },
            { data: 'admission_date', name: 'admission_date' },
            { data: 'discharge_date', name: 'discharge_date' },
            { data: 'doctor_name', name: 'doctor_name' },
            { data: 'disease', name: 'disease' },
            { data: 'department', name: 'department' },
            { data: 'ward_name', name: 'ward_name' },
            { data: 'room_no', name: 'room_no' },
            { data: 'bed_no', name: 'bed_no' },
            { data: 'employee', name: 'employee' },
            { data: 'bill_no', name: 'bill_no' },
            { data: 'insurance', name: 'insurance' },
            { data: 'insurance_name', name: 'insurance_name' },
            { data: 'policy_id', name: 'policy_id' },
            { data: 'policy_holder_name', name: 'policy_holder_name' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
        ],
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print', 'colvis']
    });
    $('#filterForm').submit(function(e) {
        e.preventDefault();
        table.ajax.reload();
    });
    $('#addIpdBtn').click(function() {
        $('#ipdForm')[0].reset();
        $('#ipd_id').val('');
        $('#ipdModal').modal('show');
    });
    // Submit form (add/update)
    $('#ipdForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $('#ipd_id').val();
        var url = id ? '/ipd/' + id : '/ipd';
        var type = id ? 'POST' : 'POST';
        if (id) formData += '&_method=PUT';
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function(res) {
                $('#ipdModal').modal('hide');
                table.ajax.reload();
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });
    // Edit button
    $('#ipdTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/ipd/' + id, function(data) {
            $('#ipd_id').val(data.id);
            $('#ipd_no').val(data.ipd_no);
            $('#uhid_no').val(data.uhid_no);
            $('#patient_name').val(data.patient_name);
            $('#attendant_name').val(data.attendant_name);
            $('#attendant_mobile').val(data.attendant_mobile);
            $('#second_attendant_name').val(data.second_attendant_name);
            $('#second_attendant_mobile').val(data.second_attendant_mobile);
            $('#admission_date').val(data.admission_date ? data.admission_date.replace(' ', 'T') : '');
            $('#discharge_date').val(data.discharge_date ? data.discharge_date.replace(' ', 'T') : '');
            $('#doctor_name').val(data.doctor_name);
            $('#disease').val(data.disease);
            $('#department').val(data.department);
            $('#ward_name').val(data.ward_name);
            $('#room_no').val(data.room_no);
            $('#bed_no').val(data.bed_no);
            $('#employee').val(data.employee);
            $('#bill_no').val(data.bill_no);
            $('#insurance').val(data.insurance);
            $('#insurance_name').val(data.insurance_name);
            $('#policy_id').val(data.policy_id);
            $('#policy_holder_name').val(data.policy_holder_name);
            $('#ipdModal').modal('show');
        });
    });
});
</script>
@endpush 