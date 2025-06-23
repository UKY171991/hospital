@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-microscope mr-2"></i>Investigation Management</h1>
            <p class="text-muted">Manage medical investigations and tests</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Investigations</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Form Section -->
        <div class="col-lg-4 col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0" id="formTitle">
                        <i class="fas fa-plus mr-2"></i>Add Investigation
                    </h5>
                </div>
                <form id="investigationForm">
                    @csrf
                    <input type="hidden" name="id" id="investigation_id">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="department_id"><i class="fas fa-building mr-1"></i>Department</label>
                            <select name="department_id" id="department_id" class="form-control" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->department }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name"><i class="fas fa-flask mr-1"></i>Investigation Name</label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   placeholder="Enter investigation name" required>
                        </div>
                        <div class="form-group">
                            <label for="price"><i class="fas fa-rupee-sign mr-1"></i>Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₹</span>
                                </div>
                                <input type="number" step="0.01" name="price" id="price" class="form-control" 
                                       placeholder="0.00" required min="0">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success" id="saveBtn">
                            <i class="fas fa-save mr-1"></i>Save
                        </button>
                        <button type="button" class="btn btn-secondary ml-2" id="resetBtn">
                            <i class="fas fa-undo mr-1"></i>Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="col-lg-8 col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list mr-2"></i>Investigation List
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="investigationTable" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th><i class="fas fa-building mr-1"></i>Department</th>
                                    <th><i class="fas fa-flask mr-1"></i>Name</th>
                                    <th><i class="fas fa-rupee-sign mr-1"></i>Price</th>
                                    <th><i class="fas fa-toggle-on mr-1"></i>Status</th>
                                    <th><i class="fas fa-cogs mr-1"></i>Action</th>
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
    var table = $('#investigationTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('investigation.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'department', name: 'department.department' },
            { data: 'name', name: 'name' },
            { data: 'price', name: 'price' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Reset form
    $('#resetBtn').click(function() {
        $('#investigationForm')[0].reset();
        $('#investigation_id').val('');
        $('#formTitle').text('Add Investigation');
        $('#saveBtn').text('Save');
    });

    // Add or Update Investigation
    $('#investigationForm').submit(function(e) {
        e.preventDefault();
        var id = $('#investigation_id').val();
        var url = id ? '/investigation/' + id : '/investigation';
        var type = id ? 'PUT' : 'POST';
        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(res) {
                table.ajax.reload();
                $('#investigationForm')[0].reset();
                $('#investigation_id').val('');
                $('#formTitle').text('Add Investigation');
                $('#saveBtn').text('Save');
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });

    // Edit button
    $('#investigationTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/investigation/' + id, function(data) {
            $('#investigation_id').val(data.id);
            $('#department_id').val(data.department_id);
            $('#name').val(data.name);
            $('#price').val(data.price);
            $('#formTitle').text('Edit Investigation');
            $('#saveBtn').text('Update');
        });
    });

    // Delete button
    $('#investigationTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this investigation?')) {
            $.ajax({
                url: '/investigation/' + id,
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
    });    // Status toggle
    $('#investigationTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '/investigation/toggle-status/' + id,
            type: 'POST',
            data: { status: status, _token: '{{ csrf_token() }}' },
            success: function(res) {
                table.ajax.reload();
                toastr && toastr.success(res.message || 'Status updated successfully.');
            },
            error: function(xhr) {
                toastr && toastr.error(xhr.responseJSON?.message || 'Status update failed.');
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