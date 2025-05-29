@extends('layouts.app')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Manage Department</h1>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="mb-3">Create Department:</h5>
                    <form id="departmentForm">
                        @csrf
                        <input type="hidden" name="id" id="departmentId">
                        <div class="form-group">
                            <label>Department<span class="text-danger">*</span></label>
                            <input type="text" name="department" id="department" class="form-control" placeholder="Department" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="description" id="description" class="form-control" placeholder="Description">
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="mb-3">Manage Department:</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="departmentTable" style="width:100%">
                            <thead class="bg-danger text-white">
                                <tr>
                                    <th>Sr No</th>
                                    <th>Department</th>
                                    <th>Description</th>
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
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css"/>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
<script>
let table;
$(function() {
    table = $('#departmentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/department',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'department', name: 'department' },
            { data: 'description', name: 'description' },
            { data: 'status', name: 'status', orderable: false, searchable: false, render: function(data, type, row){
                let icon = data === 'Active' ? 'fa-eye text-success' : 'fa-eye-slash text-danger';
                let nextStatus = data === 'Active' ? 'Inactive' : 'Active';
                return `<a href="#" class="toggleStatus" data-id="${row.id}" data-status="${nextStatus}"><i class="fas ${icon}"></i></a>`;
            } },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print', 'colvis']
    });

    $('#departmentForm').submit(function(e){
        e.preventDefault();
        let id = $('#departmentId').val();
        let url = id ? '/department/' + id : '/department';
        let type = 'POST';
        let formData = $(this).serialize();
        if (id) formData += '&_method=PUT';
        $.ajax({
            url: url,
            type: type,
            data: formData,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(){
                $('#departmentForm')[0].reset();
                $('#departmentId').val('');
                table.ajax.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON.message || 'An error occurred.'));
            }
        });
    });

    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');
        $.get('/department/' + id, function(dept){
            $('#departmentId').val(dept.id || '');
            $('#department').val(dept.department || '');
            $('#description').val(dept.description || '');
        });
    });

    $(document).on('click', '.toggleStatus', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        let status = $(this).data('status');
        $.ajax({
            url: `/department/${id}`,
            type: 'PUT',
            data: { status: status, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(){
                table.ajax.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON.message || 'An error occurred.'));
            }
        });
    });
});
</script>
@endpush 