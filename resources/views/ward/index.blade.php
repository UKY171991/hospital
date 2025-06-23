@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-door-open mr-2"></i>Ward Management</h1>
            <p class="text-muted">Manage hospital wards and room allocations</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Wards</li>
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
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0" id="formTitle">
                        <i class="fas fa-plus mr-2"></i>Add Ward
                    </h5>
                </div>
                <form id="wardForm">
                    @csrf
                    <input type="hidden" name="id" id="ward_id">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name"><i class="fas fa-door-open mr-1"></i>Ward Name</label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   placeholder="Enter ward name" required>
                        </div>
                        <div class="form-group">
                            <label for="description"><i class="fas fa-align-left mr-1"></i>Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" 
                                      placeholder="Enter ward description..."></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success" id="saveBtn">
                            <i class="fas fa-save mr-1"></i>Save Ward
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
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list mr-2"></i>Ward Directory
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="wardTable" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th><i class="fas fa-door-open mr-1"></i>Name</th>
                                    <th><i class="fas fa-align-left mr-1"></i>Description</th>
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
</div>
@endsection

@push('scripts')
<script>
$(function() {
    // DataTable
    var table = $('#wardTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('ward.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Reset form
    $('#resetBtn').click(function() {
        $('#wardForm')[0].reset();
        $('#ward_id').val('');
        $('#formTitle').text('Add Ward');
        $('#saveBtn').text('Save');
    });

    // Add or Update Ward
    $('#wardForm').submit(function(e) {
        e.preventDefault();
        var id = $('#ward_id').val();
        var url = id ? '/ward/' + id : '/ward';
        var type = id ? 'PUT' : 'POST';
        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(res) {
                table.ajax.reload();
                $('#wardForm')[0].reset();
                $('#ward_id').val('');
                $('#formTitle').text('Add Ward');
                $('#saveBtn').text('Save');
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });

    // Edit button
    $('#wardTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/ward/' + id, function(data) {
            $('#ward_id').val(data.id);
            $('#name').val(data.name);
            $('#description').val(data.description);
            $('#formTitle').text('Edit Ward');
            $('#saveBtn').text('Update');
        });
    });

    // Delete button
    $('#wardTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this ward?')) {
            $.ajax({
                url: '/ward/' + id,
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
    $('#wardTable').on('click', '.toggleStatus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '/ward/toggle-status/' + id,
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