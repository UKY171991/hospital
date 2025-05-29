@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="mb-3">Create Schedule</h5>
                    <form id="scheduleForm">
                        @csrf
                        <input type="hidden" name="id" id="schedule_id">
                        <div class="form-group">
                            <label>Doctor Name</label>
                            <select name="doctor_id" id="doctor_id" class="form-control" required>
                                <option value="">Select Any One</option>
                                <!-- Options will be loaded by AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Available Days</label>
                            <select name="available_days[]" id="available_days" class="form-control" multiple required>
                                <option value="Sunday">Sunday</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Start Time</label>
                            <input type="time" name="start_time" id="start_time" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>End Time</label>
                            <input type="time" name="end_time" id="end_time" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="mb-3">Manage Schedule</h5>
                    <table class="table table-bordered table-striped" id="scheduleTable" style="width:100%">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th>Sr No</th>
                                <th>Doctor</th>
                                <th>Available Days</th>
                                <th>Timing</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    // Load doctor dropdown
    function loadDoctors(selectedId = null) {
        $.get('/schedule/doctors', function(doctors) {
            console.log('Doctors loaded:', doctors); // Debug log
            let options = '<option value="">Select Any One</option>';
            if (doctors.length === 0) {
                options += '<option value="" disabled>No doctors found. Please add a doctor first.</option>';
            } else {
                doctors.forEach(function(doc) {
                    options += `<option value="${doc.id}" ${selectedId == doc.id ? 'selected' : ''}>${doc.name}</option>`;
                });
            }
            $('#doctor_id').html(options);
        });
    }
    loadDoctors();

    // DataTable
    var table = $('#scheduleTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/schedule',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'doctor', name: 'doctor' },
            { data: 'available_days', name: 'available_days' },
            { data: 'timing', name: 'timing' },
            { data: 'status', name: 'status', orderable: false, searchable: false, render: function(data, type, row) {
                let icon = data === 'Active' ? 'fa-eye text-success' : 'fa-eye-slash text-warning';
                let nextStatus = data === 'Active' ? 'Inactive' : 'Active';
                return `<a href="#" class="toggleStatus" data-id="${row.id}" data-status="${nextStatus}"><i class="fas ${icon}"></i></a>`;
            } },
            { data: 'action', name: 'action', orderable: false, searchable: false, render: function(data) { return data; } },
        ]
    });

    // Reset form
    function resetForm() {
        $('#scheduleForm')[0].reset();
        $('#schedule_id').val('');
        $('#doctor_id').val('');
        $('#available_days').val([]).trigger('change');
        $('#start_time').val('');
        $('#end_time').val('');
    }

    // Submit form (add/update)
    $('#scheduleForm').submit(function(e) {
        e.preventDefault();
        var id = $('#schedule_id').val();
        var url = id ? '/schedule/' + id : '/schedule';
        var type = id ? 'POST' : 'POST';
        var formData = $(this).serializeArray();
        if (id) formData.push({name: '_method', value: 'PUT'});
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function(res) {
                resetForm();
                table.ajax.reload();
                toastr && toastr.success(res.message);
            },
            error: function(xhr) {
                toastr && toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });

    // Edit button
    $('#scheduleTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/schedule/' + id, function(data) {
            $('#schedule_id').val(data.id);
            loadDoctors(data.doctor_id);
            $('#available_days').val(data.available_days.split(',')).trigger('change');
            $('#start_time').val(data.start_time);
            $('#end_time').val(data.end_time);
        });
    });

    // Status toggle
    $('#scheduleTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '/schedule/toggle-status/' + id,
            type: 'POST',
            data: { status: status, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                table.ajax.reload();
                toastr && toastr.success(res.message);
            },
            error: function(xhr) {
                toastr && toastr.error(xhr.responseJSON?.message || 'Status update failed.');
            }
        });
    });
});
</script>
@endpush 