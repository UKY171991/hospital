@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12 text-right">
            <button class="btn btn-primary" id="addPatientBtn">+ Add Patient</button>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <form id="filterForm" class="form-row align-items-end">
                <div class="form-group col-md-4">
                    <label>From Reg. Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group col-md-4">
                    <label>To Reg. Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group col-md-4">
                    <button type="submit" class="btn btn-success mt-4"><i class="fas fa-search"></i> Search</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="patientTable" style="width:100%">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>S.No</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Patient Id</th>
                        <th>Relation Name</th>
                        <th>Mobile</th>
                        <th>Reg. Date</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Patient Modal -->
<div class="modal fade" id="patientModal" tabindex="-1" role="dialog" aria-labelledby="patientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="patientModalLabel">Add/Update Patient</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="patientForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="patient_id">
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label>Patient Type</label>
              <select name="patient_type" id="patient_type" class="form-control">
                <option value="General (OPD)">General (OPD)</option>
                <option value="IPD">IPD</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Title</label>
              <select name="relative_title" id="relative_title" class="form-control">
                <option value="Mr.">Mr.</option>
                <option value="Mrs.">Mrs.</option>
                <option value="Miss">Miss</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Patient Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Relative Name</label>
              <input type="text" name="relation_name" id="relation_name" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Relation of Relative</label>
              <select name="relation_of_relative" id="relation_of_relative" class="form-control">
                <option value="S/O">S/O</option>
                <option value="D/O">D/O</option>
                <option value="W/O">W/O</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Reference Doctor/Hospital Name</label>
              <input type="text" name="reference_doctor" id="reference_doctor" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Contact No</label>
              <input type="text" name="mobile" id="mobile" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Registration Date</label>
              <input type="date" name="reg_date" id="reg_date" class="form-control" value="{{ date('Y-m-d') }}">
            </div>
            <div class="form-group col-md-3">
              <label>Gender <span class="text-danger">*</span></label>
              <select name="gender" id="gender" class="form-control" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Address</label>
              <input type="text" name="address" id="address" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Age</label>
              <input type="number" name="age" id="age" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Aadhar No</label>
              <input type="text" name="aadhar_no" id="aadhar_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Card No</label>
              <input type="text" name="card_no" id="card_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Height(in CM)</label>
              <input type="number" name="height_cm" id="height_cm" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Weight(in KG)</label>
              <input type="number" name="weight_kg" id="weight_kg" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Blood Group <span class="text-danger">*</span></label>
              <select name="blood_group" id="blood_group" class="form-control" required>
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
            <div class="form-group col-md-3">
              <label>Color Vision <span class="text-danger">*</span></label>
              <select name="color_vision" id="color_vision" class="form-control" required>
                <option value="Normal">Normal</option>
                <option value="Abnormal">Abnormal</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Patient Photo</label>
              <input type="file" name="photo" id="photo" class="form-control">
              <img id="photo_preview" src="#" alt="" style="max-width:80px;max-height:80px;display:none;"/>
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
    var table = $('#patientTable').DataTable({
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
            { data: 'photo', name: 'photo', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'patient_id', name: 'patient_id' },
            { data: 'relation_name', name: 'relation_name' },
            { data: 'mobile', name: 'mobile' },
            { data: 'reg_date', name: 'reg_date' },
            { data: 'address', name: 'address' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print', 'colvis']
    });
    $('#filterForm').submit(function(e) {
        e.preventDefault();
        table.ajax.reload();
    });
    $('#addPatientBtn').click(function() {
        $('#patientForm')[0].reset();
        $('#patient_id').val('');
        $('#photo_preview').hide();
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
        }
    });
    // Submit form (add/update)
    $('#patientForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var id = $('#patient_id').val();
        var url = id ? '/patient/' + id : '/patient';
        var type = id ? 'POST' : 'POST';
        if (id) formData.append('_method', 'PUT');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                $('#patientModal').modal('hide');
                table.ajax.reload();
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });
    // Edit button
    $('#patientTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/patient/' + id, function(data) {
            $('#patient_id').val(data.id);
            $('#name').val(data.name);
            $('#relation_name').val(data.relation_name);
            $('#relation_of_relative').val(data.relation_of_relative);
            $('#relative_title').val(data.relative_title);
            $('#mobile').val(data.mobile);
            $('#reg_date').val(data.reg_date);
            $('#gender').val(data.gender);
            $('#address').val(data.address);
            $('#age').val(data.age);
            $('#aadhar_no').val(data.aadhar_no);
            $('#card_no').val(data.card_no);
            $('#height_cm').val(data.height_cm);
            $('#weight_kg').val(data.weight_kg);
            $('#blood_group').val(data.blood_group);
            $('#color_vision').val(data.color_vision);
            $('#reference_doctor').val(data.reference_doctor);
            if (data.photo) {
                $('#photo_preview').attr('src', '/storage/patient_photos/' + data.photo).show();
            } else {
                $('#photo_preview').hide();
            }
            $('#patientModal').modal('show');
        });
    });
});
</script>
@endpush 