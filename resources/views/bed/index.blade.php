@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title" id="formTitle">Add Bed</h3></div>
                <form id="bedForm">
                    @csrf
                    <input type="hidden" name="id" id="bed_id">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="room_id">Room</label>
                            <select name="room_id" id="room_id" class="form-control" required>
                                <option value="">Select Room</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bed_number">Bed Number</label>
                            <input type="text" name="bed_number" id="bed_number" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                        <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Bed List</h3></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="bedTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Room</th>
                                <th>Bed Number</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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

    // DataTable
    table = $('#bedTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('bed.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'room', name: 'room.name' },
            { data: 'bed_number', name: 'bed_number' },
            { data: 'description', name: 'description' },
            { 
                data: 'status', 
                name: 'status', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row) {
                    const isActive = row.is_active == 1;
                    const statusClass = isActive ? 'success' : 'danger';
                    const statusText = isActive ? 'Available' : 'Occupied';
                    const toggleText = isActive ? 'Mark Occupied' : 'Mark Available';
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
            emptyTable: 'No beds found',
            zeroRecords: 'No matching beds found'
        }
    });

    // Reset form
    $('#resetBtn').click(function() {
        $('#bedForm')[0].reset();
        $('#bed_id').val('');
        $('#formTitle').text('Add Bed');
        $('#saveBtn').text('Save');
    });

    // Add or Update Bed
    $('#bedForm').submit(function(e) {
        e.preventDefault();
        var id = $('#bed_id').val();
        var url = id ? '/bed/' + id : '/bed';
        var type = 'POST';
        var formData = $(this).serialize();
        if (id) formData += '&_method=PUT';
        
        $.ajax({
            url: url,
            type: type,
            data: formData,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                table.ajax.reload();
                $('#bedForm')[0].reset();
                $('#bed_id').val('');
                $('#formTitle').text('Add Bed');
                $('#saveBtn').text('Save');
                // Show success message
                if(response.message) {
                    alert('Success: ' + response.message);
                } else {
                    alert('Bed saved successfully!');
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
        $.get('/bed/' + id)
        .done(function(data) {
            $('#bed_id').val(data.id || '');
            $('#room_id').val(data.room_id || '');
            $('#bed_number').val(data.bed_number || '');
            $('#description').val(data.description || '');
            $('#formTitle').text('Edit Bed');
            $('#saveBtn').text('Update');
        })
        .fail(function() {
            alert('Failed to load bed data. Please try again.');
        });
    });

    // Delete button
    $(document).on('click', '.deleteBtn', function() {
        if(confirm('Are you sure you want to delete this bed?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '/bed/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    table.ajax.reload();
                    if(response.message) {
                        alert('Success: ' + response.message);
                    } else {
                        alert('Bed deleted successfully!');
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
            url: '/bed/toggle-status/' + id,
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
                    alert('Bed status updated successfully!');
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