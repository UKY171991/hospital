@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12 text-right">
            <button class="btn btn-primary" id="addOpdBtn">+ Add OPD Patient</button>
            <button class="btn btn-success" id="newReceiptBtn">+ New Receipt</button>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <form id="filterForm" class="form-row align-items-end">
                <div class="form-group col-md-3">
                    <label>OPD Type</label>
                    <select name="opd_type" id="opd_type" class="form-control">
                        <option value="">--All Type--</option>
                        <option value="General">General</option>
                        <option value="Emergency">Emergency</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group col-md-3">
                    <label>To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-success mt-4"><i class="fas fa-search"></i> Search Report</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="opdTable" style="width:100%">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>Action</th>
                        <th>S.No</th>
                        <th>OPD Type</th>
                        <th>OPD No</th>
                        <th>Admission Date</th>
                        <th>Patient Id</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Doctor Name</th>
                        <th>Disease</th>
                        <th>Doctor Fee</th>
                        <th>Discount</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                        <th>Prepared By</th>
                        <th>Payment Mode</th>
                        <th>Reference Doctor</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit OPD Modal -->
<div class="modal fade" id="opdModal" tabindex="-1" role="dialog" aria-labelledby="opdModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="opdModalLabel">Add/Update OPD Patient</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="opdForm">
        @csrf
        <input type="hidden" name="id" id="opd_id">
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label>OPD Type <span class="text-danger">*</span></label>
              <select name="opd_type" id="modal_opd_type" class="form-control" required>
                <option value="General">General</option>
                <option value="Emergency">Emergency</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>OPD No</label>
              <input type="text" name="opd_no" id="opd_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Admission Date <span class="text-danger">*</span></label>
              <input type="date" name="admission_date" id="admission_date" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
            <div class="form-group col-md-3">
              <label>Patient Id</label>
              <input type="text" name="patient_id" id="patient_id" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Address</label>
              <input type="text" name="address" id="address" class="form-control">
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
              <label>Doctor Fee <span class="text-danger">*</span></label>
              <input type="number" name="doctor_fee" id="doctor_fee" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Discount</label>
              <input type="number" name="discount" id="discount" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Paid Amount <span class="text-danger">*</span></label>
              <input type="number" name="paid_amount" id="paid_amount" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Due Amount</label>
              <input type="number" name="due_amount" id="due_amount" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Prepared By <span class="text-danger">*</span></label>
              <input type="text" name="prepared_by" id="prepared_by" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Payment Mode <span class="text-danger">*</span></label>
              <select name="payment_mode" id="payment_mode" class="form-control" required>
                <option value="CASH">CASH</option>
                <option value="CARD">CARD</option>
                <option value="UPI">UPI</option>
                <option value="BANK">BANK</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Reference Doctor</label>
              <input type="text" name="reference_doctor" id="reference_doctor" class="form-control">
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
    var table = $('#opdTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/opd',
            data: function(d) {
                d.opd_type = $('#opd_type').val();
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },
        columns: [
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'opd_type', name: 'opd_type' },
            { data: 'opd_no', name: 'opd_no' },
            { data: 'admission_date', name: 'admission_date' },
            { data: 'patient_id', name: 'patient_id' },
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
            { data: 'doctor_name', name: 'doctor_name' },
            { data: 'disease', name: 'disease' },
            { data: 'doctor_fee', name: 'doctor_fee' },
            { data: 'discount', name: 'discount' },
            { data: 'paid_amount', name: 'paid_amount' },
            { data: 'due_amount', name: 'due_amount' },
            { data: 'prepared_by', name: 'prepared_by' },
            { data: 'payment_mode', name: 'payment_mode' },
            { data: 'reference_doctor', name: 'reference_doctor' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
        ],
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print', 'colvis']
    });
    $('#filterForm').submit(function(e) {
        e.preventDefault();
        table.ajax.reload();
    });
    $('#addOpdBtn').click(function() {
        $('#opdForm')[0].reset();
        $('#opd_id').val('');
        $('#opdModal').modal('show');
    });
    // Submit form (add/update)
    $('#opdForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $('#opd_id').val();
        var url = id ? '/opd/' + id : '/opd';
        var type = id ? 'POST' : 'POST';
        if (id) formData += '&_method=PUT';
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function(res) {
                $('#opdModal').modal('hide');
                table.ajax.reload();
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });
    // Edit button
    $('#opdTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/opd/' + id, function(data) {
            $('#opd_id').val(data.id);
            $('#modal_opd_type').val(data.opd_type);
            $('#opd_no').val(data.opd_no);
            $('#admission_date').val(data.admission_date);
            $('#patient_id').val(data.patient_id);
            $('#name').val(data.name);
            $('#address').val(data.address);
            $('#doctor_name').val(data.doctor_name);
            $('#disease').val(data.disease);
            $('#doctor_fee').val(data.doctor_fee);
            $('#discount').val(data.discount);
            $('#paid_amount').val(data.paid_amount);
            $('#due_amount').val(data.due_amount);
            $('#prepared_by').val(data.prepared_by);
            $('#payment_mode').val(data.payment_mode);
            $('#reference_doctor').val(data.reference_doctor);
            $('#opdModal').modal('show');
        });
    });
});
</script>
@endpush 