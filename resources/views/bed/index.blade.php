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
$(function() {
    // DataTable
    var table = $('#bedTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('bed.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'room', name: 'room.name' },
            { data: 'bed_number', name: 'bed_number' },
            { data: 'description', name: 'description' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
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
        var type = id ? 'PUT' : 'POST';
        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(res) {
                table.ajax.reload();
                $('#bedForm')[0].reset();
                $('#bed_id').val('');
                $('#formTitle').text('Add Bed');
                $('#saveBtn').text('Save');
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });

    // Edit button
    $('#bedTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/bed/' + id, function(data) {
            $('#bed_id').val(data.id);
            $('#room_id').val(data.room_id);
            $('#bed_number').val(data.bed_number);
            $('#description').val(data.description);
            $('#formTitle').text('Edit Bed');
            $('#saveBtn').text('Update');
        });
    });

    // Delete button
    $('#bedTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this bed?')) {
            $.ajax({
                url: '/bed/' + id,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(res) {
                    table.ajax.reload();
                    toastr.success(res.message);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Delete failed.');
                }
            });
        }
    });

    // Status toggle
    $('#bedTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '/bed/' + id,
            type: 'PUT',
            data: { status: status, _token: '{{ csrf_token() }}' },
            success: function(res) {
                table.ajax.reload();
                toastr.success(res.message);
            }
        });
    });

    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
</script>
@endpush 