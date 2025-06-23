@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-building mr-2"></i>Department Management</h1>
            <p class="text-muted">Manage hospital departments and their details</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Departments</li>
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
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus mr-2"></i>Create Department
                    </h5>
                </div>
                <div class="card-body">
                    <form id="departmentForm">
                        @csrf
                        <input type="hidden" name="id" id="departmentId">
                        <div class="form-group">
                            <label for="department"><i class="fas fa-building mr-1"></i>Department Name <span class="text-danger">*</span></label>
                            <input type="text" name="department" id="department" class="form-control" 
                                   placeholder="Enter department name" required>
                        </div>
                        <div class="form-group">
                            <label for="description"><i class="fas fa-align-left mr-1"></i>Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" 
                                      placeholder="Enter department description..."></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save mr-1"></i>Save Department
                            </button>
                            <button type="button" class="btn btn-secondary ml-2" id="resetBtn">
                                <i class="fas fa-undo mr-1"></i>Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="col-lg-8 col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list mr-2"></i>Manage Departments
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="departmentTable" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sr No</th>
                                    <th><i class="fas fa-building mr-1"></i>Department</th>
                                    <th><i class="fas fa-align-left mr-1"></i>Description</th>
                                    <th><i class="fas fa-toggle-on mr-1"></i>Status</th>
                                    <th><i class="fas fa-cogs mr-1"></i>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>
let table;

$(document).ready(function() {
    console.log('Document ready');
    
    // Global AJAX setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize DataTable
    table = $('#departmentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/department',
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'department', name: 'department' },
            { data: 'description', name: 'description' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        pageLength: 25,
        language: {
            processing: 'Loading departments...',
            emptyTable: 'No departments found'
        }
    });

    // Form submission
    $('#departmentForm').on('submit', function(e) {
        e.preventDefault();
        
        let id = $('#departmentId').val();
        let url = id ? '/department/' + id : '/department';
        let method = 'POST';
        let formData = $(this).serialize();
        
        if (id) {
            formData += '&_method=PUT';
        }
        
        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                $('#departmentForm')[0].reset();
                $('#departmentId').val('');
                table.ajax.reload();
                alert('Department saved successfully!');
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                if (errors) {
                    let errorMsg = '';
                    for (let field in errors) {
                        errorMsg += errors[field].join(', ') + '\n';
                    }
                    alert('Error: ' + errorMsg);
                } else {
                    alert('An error occurred while saving the department.');
                }
            }
        });
    });

    // Edit button
    $(document).on('click', '.editBtn', function() {
        let id = $(this).data('id');
        
        $.get('/department/' + id, function(data) {
            $('#departmentId').val(data.id);
            $('#department').val(data.department);
            $('#description').val(data.description);
        });
    });

    // Delete button
    $(document).on('click', '.deleteBtn', function() {
        if (confirm('Are you sure you want to delete this department?')) {
            let id = $(this).data('id');
            
            $.ajax({
                url: '/department/' + id,
                type: 'DELETE',
                success: function(response) {
                    table.ajax.reload();
                    alert('Department deleted successfully!');
                },
                error: function() {
                    alert('Error deleting department.');
                }
            });
        }
    });

    // Status toggle
    $(document).on('click', '.toggleStatus', function() {
        let id = $(this).data('id');
        let status = $(this).data('status');
        
        $.ajax({
            url: '/department/toggle-status/' + id,
            type: 'POST',
            data: { status: status },
            success: function(response) {
                table.ajax.reload();
                alert('Status updated successfully!');
            },
            error: function() {
                alert('Error updating status.');
            }
        });
    });

    // Reset button
    $('#resetBtn').on('click', function() {
        $('#departmentForm')[0].reset();
        $('#departmentId').val('');
    });
});
</script>
@endpush
