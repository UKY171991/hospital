@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12 text-right">
            <button class="btn btn-success" id="addAttendanceBtn"><i class="fas fa-plus"></i> Add New</button>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <form id="filterForm" class="form-row align-items-end">
                <div class="form-group col-md-3">
                    <label>Attendance Type<span class="text-danger">*</span></label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="Employee Wise">Employee Wise</option>
                        <option value="Doctor Wise">Doctor Wise</option>
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
                    <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Search Data</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="attendanceTable" style="width:100%">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>S.No.</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Duty Type</th>
                        <th>Duty Chart No</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Add Attendance Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="attendanceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="attendanceModalLabel">Add Attendance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="attendanceForm">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label>Attendance Type<span class="text-danger">*</span></label>
            <select name="type" id="modal_type" class="form-control" required>
              <option value="Employee Wise">Employee Wise</option>
              <option value="Doctor Wise">Doctor Wise</option>
            </select>
          </div>
          <div class="form-group">
            <label>Duty Type<span class="text-danger">*</span></label>
            <select name="duty_type" id="duty_type" class="form-control" required>
              <option value="Day">Day</option>
              <option value="Night">Night</option>
            </select>
          </div>
          <div class="form-group">
            <label>Attendance Date<span class="text-danger">*</span></label>
            <input type="date" name="date" id="modal_date" class="form-control" required value="{{ date('Y-m-d') }}">
          </div>
          <div class="form-group">
            <label id="employee_name_label">Employee Name<span class="text-danger">*</span></label>
            <select name="reference_id" id="employee_name" class="form-control" required>
              <option value="">Select Name</option>
            </select>
          </div>
          <div class="form-group">
            <label>Amount<span class="text-danger">*</span></label>
            <input type="number" name="amount" id="amount" class="form-control" required placeholder="Enter Amount">
          </div>
          <div class="form-group">
            <label>Duty Chart Number<span class="text-danger">*</span></label>
            <input type="text" name="duty_chart_no" id="duty_chart_no" class="form-control" required placeholder="Enter Duty Chart Number">
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
    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // DataTable
    var table = $('#attendanceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/attendance',
            data: function(d) {
                d.type = $('#type').val();
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'date', name: 'date' },
            { data: 'name', name: 'name' },
            { data: 'amount', name: 'amount' },
            { data: 'duty_type', name: 'duty_type' },
            { data: 'duty_chart_no', name: 'duty_chart_no' },
        ],
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print', 'colvis']
    });

    // Filter form
    $('#filterForm').submit(function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    // Load names for modal dropdown
    function loadNames(type) {
        let url = type === 'Doctor Wise' ? '/attendance/doctors' : '/attendance/employees';
        let label = type === 'Doctor Wise' ? 'Doctor Name' : 'Employee Name';
        $('#employee_name_label').text(label + '*');
        $.get(url, function(data) {
            let options = '<option value="">Select Name</option>';
            data.forEach(function(item) {
                options += `<option value="${item.id}">${item.name}</option>`;
            });
            $('#employee_name').html(options);
        });
    }

    // Open modal
    $('#addAttendanceBtn').click(function() {
        $('#attendanceForm')[0].reset();
        loadNames($('#modal_type').val());
        $('#attendanceModal').modal('show');
    });

    // Change type in modal
    $('#modal_type').change(function() {
        loadNames($(this).val());
    });

    // Robust AJAX form submit
    $('#attendanceForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $saveBtn = $form.find('button[type="submit"]');
        $saveBtn.prop('disabled', true).text('Saving...');
        $.ajax({
            url: '/attendance',
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            success: function(res) {
                $('#attendanceModal').modal('hide');
                table.ajax.reload();
                $form[0].reset();
                toastr.success(res.message || 'Attendance added successfully!');
            },
            error: function(xhr) {
                let msg = 'Validation error.';
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                toastr.error(msg);
            },
            complete: function() {
                $saveBtn.prop('disabled', false).text('Save');
            }
        });
    });
});
</script>
@endpush 