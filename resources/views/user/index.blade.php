@extends('layouts.app')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">User List</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="#" class="btn btn-primary" id="addUserBtn"><i class="fas fa-plus"></i> Add User</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" id="searchName" class="form-control" placeholder="Search by Name">
                </div>
                <div class="col-md-3">
                    <select id="searchType" class="form-control">
                        <option value="">All Types</option>
                        <option value="Admin">Admin</option>
                        <option value="Doctor">Doctor</option>
                        <option value="Employee">Employee</option>
                        <option value="Receptionist">Receptionist</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-info" id="searchBtn"><i class="fas fa-search"></i> Search</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" id="userTable" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>S No</th>
                            <th>User Name</th>
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
                d.name = $('#searchName').val();
                d.user_type = $('#searchType').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'username', name: 'username' },
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

    $('#searchBtn').click(function(){
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
        let type = 'POST';
        let data = $(this).serialize();
        if (id) {
            data += '&_method=PUT';
        }
        $.ajax({
            url: url,
            type: type,
            data: data,
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
</script>
@endpush
