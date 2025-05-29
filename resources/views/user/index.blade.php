@extends('layouts.app')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">User List</h1>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <form id="filterForm" class="form-inline mb-0">
                    <div class="form-group mr-2">
                        <label for="userType" class="mr-2">User Type</label>
                        <select name="user_type" id="userType" class="form-control">
                            <option value="">All</option>
                            {{-- Dynamically fill user types via JS or Blade if available --}}
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-xs"><i class="fas fa-search"></i> Search</button>
                </form>
                <button class="btn btn-primary btn-xs ml-auto" id="addUserBtn"><i class="fas fa-plus"></i> Add User</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" id="userTable" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>S No</th>
                            <th>User Name</th>
                            <th>Password</th>
                            <th>Passcode</th>
                            <th>User Type</th>
                            <th>Name</th>
                            <th>Mobile No</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@include('user.modal')
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css"/>
@endpush

@push('scripts')
<!-- Only DataTables and custom scripts, no jQuery or Bootstrap here -->
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
    table = $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/users',
            data: function(d) {
                d.user_type = $('#userType').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'username', name: 'username' },
            { data: 'password', name: 'password', render: function(){ return '••••••'; } },
            { data: 'passcode', name: 'passcode' },
            { data: 'user_type', name: 'user_type' },
            { data: 'name', name: 'name' },
            { data: 'mobile_no', name: 'mobile_no' },
            { data: 'email', name: 'email' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print', 'colvis'
        ]
    });

    $('#filterForm').submit(function(e){
        e.preventDefault();
        table.ajax.reload();
    });

    $('#addUserBtn').click(function(){
        $('#userForm')[0].reset();
        $('#userId').val('');
        $('#userModalLabel').text('Add User');
        $('#userModal').modal('show');
    });

    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');
        $.get('/users/' + id, function(user){
            $('#userId').val(user.id);
            $('#username').val(user.username);
            $('#password').val('');
            $('#passcode').val(user.passcode);
            $('#user_type').val(user.user_type);
            $('#name').val(user.name);
            $('#mobile_no').val(user.mobile_no);
            $('#email').val(user.email);
            $('#status').val(user.status);
            $('#userModalLabel').text('Edit User');
            $('#userModal').modal('show');
        });
    });

    $('#userForm').submit(function(e){
        e.preventDefault();
        let id = $('#userId').val();
        let url = id ? '/users/' + id : '/users';
        let type = 'POST'; // Always POST, use _method for PUT
        let data = $(this).serialize();
        if (id) {
            data += '&_method=PUT';
        }
        $.ajax({
            url: url,
            type: type,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(){
                $('#userModal').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr) {
                if(xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    let msg = '';
                    Object.keys(errors).forEach(function(key){
                        msg += errors[key].join(' ') + '\n';
                    });
                    alert(msg);
                } else {
                    alert('An error occurred.');
                }
            }
        });
    });

    $(document).on('click', '.deleteBtn', function(){
        if(confirm('Delete this user?')){
            let id = $(this).data('id');
            $.ajax({
                url: '/users/' + id,
                type: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                success: function(){
                    table.ajax.reload();
                }
            });
        }
    });

    $(document).on('click', '.statusBtn', function(){
        let id = $(this).data('id');
        $.post('/users/status/' + id, {_token: '{{ csrf_token() }}'}, function(){
            table.ajax.reload();
        });
    });
});

$(document).ready(function() {
    // Test Modal
    $('#testModalBtn').off('click').on('click', function() {
        $('#testModal').modal('show');
    });
    // Add User Modal
    $('#addUserBtn').off('click').on('click', function(){
        $('#userForm')[0].reset();
        $('#userId').val('');
        $('#userModalLabel').text('Add User');
        $('#userModal').modal('show');
    });
    // Edit User Modal
    $(document).off('click', '.editBtn').on('click', '.editBtn', function(){
        let id = $(this).data('id');
        $.get('/users/' + id, function(user){
            $('#userId').val(user.id);
            $('#username').val(user.username);
            $('#password').val('');
            $('#passcode').val(user.passcode);
            $('#user_type').val(user.user_type);
            $('#name').val(user.name);
            $('#mobile_no').val(user.mobile_no);
            $('#email').val(user.email);
            $('#status').val(user.status);
            $('#userModalLabel').text('Edit User');
            $('#userModal').modal('show');
        });
    });
    // Close modal on success (already handled in AJAX, but ensure here too)
    $('#userModal').on('hidden.bs.modal', function () {
        $('#userForm')[0].reset();
    });
});
</script>
@endpush
