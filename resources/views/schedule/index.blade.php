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

    // Load doctor dropdown
    function loadDoctors(selectedId = null) {
        $.get('/schedule/doctors', function(doctors) {
            let options = '<option value="">Select Any One</option>';
            if (doctors.length === 0) {
                options += '<option value="" disabled>No doctors found. Please add a doctor first.</option>';
            } else {
                doctors.forEach(function(doc) {
                    options += `<option value="${doc.id}" ${selectedId == doc.id ? 'selected' : ''}>${doc.name}</option>`;
                });
            }
            $('#doctor_id').html(options);
        })
        .fail(function() {
            $('#doctor_id').html('<option value="">Failed to load doctors</option>');
        });
    }
    loadDoctors();

    // DataTable
    table = $('#scheduleTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/schedule',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'doctor', name: 'doctor' },
            { data: 'available_days', name: 'available_days' },
            { data: 'timing', name: 'timing' },
            { 
                data: 'status', 
                name: 'status', 
                orderable: false, 
                searchable: false, 
                render: function(data, type, row) {
                    const isActive = data === 'Active';
                    const statusClass = isActive ? 'success' : 'danger';
                    const statusText = isActive ? 'Active' : 'Inactive';
                    const toggleText = isActive ? 'Deactivate' : 'Activate';
                    const toggleStatus = isActive ? 'Inactive' : 'Active';
                    
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
            emptyTable: 'No schedules found',
            zeroRecords: 'No matching schedules found'
        }
    });

    // Reset form
    function resetForm() {
        $('#scheduleForm')[0].reset();
        $('#schedule_id').val('');
        $('#doctor_id').val('');
        $('#available_days').val([]).trigger('change');
        $('#start_time').val('');
        $('#end_time').val('');
        loadDoctors();
    }

    // Submit form (add/update)
    $('#scheduleForm').submit(function(e) {
        e.preventDefault();
        var id = $('#schedule_id').val();
        var url = id ? '/schedule/' + id : '/schedule';
        var type = 'POST';
        var formData = $(this).serializeArray();
        if (id) formData.push({name: '_method', value: 'PUT'});
        
        $.ajax({
            url: url,
            type: type,
            data: formData,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                resetForm();
                table.ajax.reload();
                // Show success message
                if(response.message) {
                    alert('Success: ' + response.message);
                } else {
                    alert('Schedule saved successfully!');
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
        $.get('/schedule/' + id)
        .done(function(data) {
            $('#schedule_id').val(data.id || '');
            loadDoctors(data.doctor_id);
            $('#available_days').val(data.available_days ? data.available_days.split(',') : []).trigger('change');
            $('#start_time').val(data.start_time || '');
            $('#end_time').val(data.end_time || '');
        })
        .fail(function() {
            alert('Failed to load schedule data. Please try again.');
        });
    });

    // Delete button
    $(document).on('click', '.deleteBtn', function() {
        if(confirm('Are you sure you want to delete this schedule?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '/schedule/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    table.ajax.reload();
                    if(response.message) {
                        alert('Success: ' + response.message);
                    } else {
                        alert('Schedule deleted successfully!');
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
            url: '/schedule/toggle-status/' + id,
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
                    alert('Schedule status updated successfully!');
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