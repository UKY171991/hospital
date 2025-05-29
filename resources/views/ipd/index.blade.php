@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12 text-right">
            <button class="btn btn-primary" id="addIpdBtn">+ Add IPD Patient</button>
            <button class="btn btn-success" id="dischargedBtn">Discharged Patients</button>
            <button class="btn btn-info" id="newReceiptBtn">+ New Receipt</button>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <form id="filterForm" class="form-row align-items-end">
                <div class="form-group col-md-4">
                    <label>From Date</label>
                    <input type="datetime-local" name="from_date" id="from_date" class="form-control" value="{{ date('Y-m-d\TH:i') }}">
                </div>
                <div class="form-group col-md-4">
                    <label>To Date</label>
                    <input type="datetime-local" name="to_date" id="to_date" class="form-control" value="{{ date('Y-m-d\TH:i') }}">
                </div>
                <div class="form-group col-md-4">
                    <button type="submit" class="btn btn-success mt-4"><i class="fas fa-search"></i> Search Report</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="ipdTable" style="width:100%">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>Action</th>
                        <th>S.No</th>
                        <th>IPD No</th>
                        <th>UHID No</th>
                        <th>Patient Name</th>
                        <th>Attendant Name</th>
                        <th>Attendant Mobile</th>
                        <th>Second Attendant Name</th>
                        <th>Second Attendant Mobile</th>
                        <th>Admission Date</th>
                        <th>Discharge Date</th>
                        <th>Doctor Name</th>
                        <th>Disease</th>
                        <th>Department</th>
                        <th>Ward Name</th>
                        <th>Room No</th>
                        <th>Bed No</th>
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