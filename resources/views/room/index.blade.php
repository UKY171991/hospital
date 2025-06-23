@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-door-open mr-2"></i>Room Management</h1>
            <p class="text-muted">Manage hospital rooms and facilities</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Rooms</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title" id="formTitle">Add Room</h3></div>
                <form id="roomForm">
                    @csrf
                    <input type="hidden" name="id" id="room_id">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="ward_id">Ward</label>
                            <select name="ward_id" id="ward_id" class="form-control" required>
                                <option value="">Select Ward</option>
                                @foreach($wards as $ward)
                                    <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Room Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
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
                <div class="card-header"><h3 class="card-title">Room List</h3></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="roomTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ward</th>
                                <th>Name</th>
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
    var table = $('#roomTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('room.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'ward', name: 'ward.name' },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'status', name: 'status', orderable: false, searchable: false, render: function(data) { return data; } },
            { data: 'action', name: 'action', orderable: false, searchable: false, render: function(data) { return data; } },
        ]
    });

    // Reset form
    $('#resetBtn').click(function() {
        $('#roomForm')[0].reset();
        $('#room_id').val('');
        $('#formTitle').text('Add Room');
        $('#saveBtn').text('Save');
    });

    // Add or Update Room
    $('#roomForm').submit(function(e) {
        e.preventDefault();
        var id = $('#room_id').val();
        var url = id ? '/room/' + id : '/room';
        var type = id ? 'PUT' : 'POST';
        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(res) {
                table.ajax.reload();
                $('#roomForm')[0].reset();
                $('#room_id').val('');
                $('#formTitle').text('Add Room');
                $('#saveBtn').text('Save');
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });

    // Edit button
    $('#roomTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/room/' + id, function(data) {
            $('#room_id').val(data.id);
            $('#ward_id').val(data.ward_id);
            $('#name').val(data.name);
            $('#description').val(data.description);
            $('#formTitle').text('Edit Room');
            $('#saveBtn').text('Update');
        });
    });

    // Delete button
    $('#roomTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this room?')) {
            $.ajax({
                url: '/room/' + id,
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
    $('#roomTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '/room/' + id,
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