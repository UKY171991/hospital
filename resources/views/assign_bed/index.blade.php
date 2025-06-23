@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-bed mr-2"></i>Bed Assignment</h1>
            <p class="text-muted">Assign beds to patients</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Bed Assignment</li>
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
                <div class="card-header"><h3 class="card-title" id="formTitle">Assign Bed</h3></div>
                <form id="assignBedForm">
                    @csrf
                    <input type="hidden" name="id" id="assign_bed_id">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="bed_id">Bed</label>
                            <select name="bed_id" id="bed_id" class="form-control" required>
                                <option value="">Select Bed</option>
                                @foreach($beds as $bed)
                                    <option value="{{ $bed->id }}">{{ $bed->bed_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="patient_name">Patient Name</label>
                            <input type="text" name="patient_name" id="patient_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="assign_date">Assign Date</label>
                            <input type="date" name="assign_date" id="assign_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="release_date">Release Date</label>
                            <input type="date" name="release_date" id="release_date" class="form-control">
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
                <div class="card-header"><h3 class="card-title">Assigned Beds List</h3></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="assignBedTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bed</th>
                                <th>Patient Name</th>
                                <th>Assign Date</th>
                                <th>Release Date</th>
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
    var table = $('#assignBedTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('assign_bed.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'bed', name: 'bed.bed_number' },
            { data: 'patient_name', name: 'patient_name' },
            { data: 'assign_date', name: 'assign_date' },
            { data: 'release_date', name: 'release_date' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Reset form
    $('#resetBtn').click(function() {
        $('#assignBedForm')[0].reset();
        $('#assign_bed_id').val('');
        $('#formTitle').text('Assign Bed');
        $('#saveBtn').text('Save');
    });

    // Add or Update Assign Bed
    $('#assignBedForm').submit(function(e) {
        e.preventDefault();
        var id = $('#assign_bed_id').val();
        var url = id ? '/assign_bed/' + id : '/assign_bed';
        var type = id ? 'PUT' : 'POST';
        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(res) {
                table.ajax.reload();
                $('#assignBedForm')[0].reset();
                $('#assign_bed_id').val('');
                $('#formTitle').text('Assign Bed');
                $('#saveBtn').text('Save');
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });

    // Edit button
    $('#assignBedTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/assign_bed/' + id, function(data) {
            $('#assign_bed_id').val(data.id);
            $('#bed_id').val(data.bed_id);
            $('#patient_name').val(data.patient_name);
            $('#assign_date').val(data.assign_date);
            $('#release_date').val(data.release_date);
            $('#formTitle').text('Edit Assignment');
            $('#saveBtn').text('Update');
        });
    });

    // Delete button
    $('#assignBedTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this assignment?')) {
            $.ajax({
                url: '/assign_bed/' + id,
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
    $('#assignBedTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '/assign_bed/' + id,
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