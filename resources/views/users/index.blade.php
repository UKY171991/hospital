@extends('layouts.app')

@section('content')
</div>
<div class="container-fluid py-4" style="min-height: 100vh; background: #f6f7fb;">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-primary mb-0">User Management</h2>
            <button class="btn btn-primary rounded-pill px-4 py-2 shadow-sm" id="addUserBtn"><i class="fas fa-plus me-2"></i> Add User</button>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="searchUser" class="form-control rounded-pill px-3 shadow-sm" placeholder="Search users...">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow rounded-4 border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0" id="usersTable">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-secondary text-uppercase text-xs fw-bold">Name</th>
                                    <th class="text-secondary text-uppercase text-xs fw-bold">Username</th>
                                    <th class="text-secondary text-uppercase text-xs fw-bold">Email</th>
                                    <th class="text-secondary text-uppercase text-xs fw-bold">Mobile</th>
                                    <th class="text-secondary text-uppercase text-xs fw-bold">User Type</th>
                                    <th class="text-secondary text-uppercase text-xs fw-bold">Status</th>
                                    <th class="text-secondary text-uppercase text-xs fw-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- User rows will be injected here by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit User Modal -->

<!-- Modal Backdrop for better separation -->
<div id="userModalBackdrop" class="modal-backdrop fade" style="display:none;"></div>
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 720px;"> <!-- Increased width -->
    <div class="modal-content shadow-lg border-0 rounded-4">
      <form id="userForm" autocomplete="off" style="padding: 20px;"> <!-- Added padding -->
        <div class="modal-header bg-gradient-primary text-white rounded-top-4">
          <h5 class="modal-title fw-bold" id="userModalLabel">Add User</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-4 px-4">
          <input type="hidden" id="userId" name="id">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
              <div class="input-group border border-primary rounded-pill shadow-sm">
                <span class="input-group-text bg-light border-0"><i class="fas fa-user"></i></span>
                <input type="text" class="form-control border-0 rounded-end-pill px-3" id="name" name="name" required placeholder="Full Name">
              </div>
              <div class="invalid-feedback d-block" id="error-name"></div>
            </div>
            <div class="col-md-6">
              <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
              <div class="input-group border border-primary rounded-pill shadow-sm">
                <span class="input-group-text bg-light border-0"><i class="fas fa-user-tag"></i></span>
                <input type="text" class="form-control border-0 rounded-end-pill px-3" id="username" name="username" required placeholder="Username">
              </div>
              <div class="invalid-feedback d-block" id="error-username"></div>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
              <div class="input-group border border-primary rounded-pill shadow-sm">
                <span class="input-group-text bg-light border-0"><i class="fas fa-envelope"></i></span>
                <input type="email" class="form-control border-0 rounded-end-pill px-3" id="email" name="email" required placeholder="Email address">
              </div>
              <div class="invalid-feedback d-block" id="error-email"></div>
            </div>
            <div class="col-md-6">
              <label for="mobile" class="form-label">Mobile</label>
              <div class="input-group border border-primary rounded-pill shadow-sm">
                <span class="input-group-text bg-light border-0"><i class="fas fa-phone"></i></span>
                <input type="text" class="form-control border-0 rounded-end-pill px-3" id="mobile" name="mobile" placeholder="Mobile number">
              </div>
              <div class="invalid-feedback d-block" id="error-mobile"></div>
            </div>
            <div class="col-md-6">
              <label for="user_type" class="form-label">User Type <span class="text-danger">*</span></label>
              <div class="input-group border border-primary rounded-pill shadow-sm">
                <span class="input-group-text bg-light border-0"><i class="fas fa-user-shield"></i></span>
                <select class="form-select border-0 rounded-end-pill px-3" id="user_type" name="user_type" required>
                  <option value="">Select type</option>
                  <option value="admin">Admin</option>
                  <option value="doctor">Doctor</option>
                  <option value="nurse">Nurse</option>
                  <option value="reception">Reception</option>
                </select>
              </div>
              <div class="invalid-feedback d-block" id="error-user_type"></div>
            </div>
            <div class="col-md-6">
              <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
              <div class="input-group border border-primary rounded-pill shadow-sm">
                <span class="input-group-text bg-light border-0"><i class="fas fa-toggle-on"></i></span>
                <select class="form-select border-0 rounded-end-pill px-3" id="status" name="status" required>
                  <option value="Active">Active</option>
                  <option value="Deactivate">Deactivate</option>
                </select>
              </div>
              <div class="invalid-feedback d-block" id="error-status"></div>
            </div>
            <div class="col-md-6">
              <label for="passcode" class="form-label">Passcode</label>
              <div class="input-group border border-primary rounded-pill shadow-sm">
                <span class="input-group-text bg-light border-0"><i class="fas fa-key"></i></span>
                <input type="text" class="form-control border-0 rounded-end-pill px-3" id="passcode" name="passcode" placeholder="Passcode (optional)">
              </div>
              <div class="invalid-feedback d-block" id="error-passcode"></div>
            </div>
            <div class="col-md-6 password-fields">
              <label for="password" class="form-label">Password <span class="text-danger password-required">*</span></label>
              <div class="input-group border border-primary rounded-pill shadow-sm">
                <span class="input-group-text bg-light border-0"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control border-0 rounded-end-pill px-3" id="password" name="password" placeholder="Password">
              </div>
              <div class="invalid-feedback d-block" id="error-password"></div>
            </div>
            <div class="col-md-6 password-fields">
              <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger password-required">*</span></label>
              <div class="input-group border border-primary rounded-pill shadow-sm">
                <span class="input-group-text bg-light border-0"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control border-0 rounded-end-pill px-3" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
              </div>
              <div class="invalid-feedback d-block" id="error-password_confirmation"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light rounded-bottom-4 d-flex justify-content-between">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary rounded-pill px-4">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
// Add CSRF token to all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const usersUrl = "{{ route('users.index') }}";
const storeUrl = "{{ route('users.store') }}";
const updateUrl = id => `/users/${id}`;
const showUrl = id => `/users/${id}`;
const deleteUrl = id => `/users/${id}`;

function fetchUsers(search = '') {
    $.get(usersUrl, {search}, function(res) {
        let rows = '';
        res.users.forEach(user => {
            rows += `<tr>
                <td>${user.name}</td>
                <td>${user.username}</td>
                <td>${user.email}</td>
                <td>${user.mobile || ''}</td>
                <td>${user.user_type}</td>
                <td><span class="badge bg-${user.status === 'active' ? 'success' : 'secondary'}">${user.status.charAt(0).toUpperCase() + user.status.slice(1)}</span></td>
                <td>
                    <button class="btn btn-sm btn-info editUserBtn" data-id="${user.id}"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger deleteUserBtn" data-id="${user.id}"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;
        });
        $('#usersTable tbody').html(rows);
    });
}

$(document).ready(function() {
    fetchUsers();

    $('#searchUser').on('input', function() {
        fetchUsers($(this).val());
    });

    $('#addUserBtn').click(function() {
        $('#userForm')[0].reset();
        $('#userId').val('');
        $('.password-fields').show();
        $('#userModalLabel').text('Add User');
        // Show modal and backdrop for better separation
        $('#userModal').modal('show');
        setTimeout(function() {
            $('#userModalBackdrop').addClass('show').css('display','block');
        }, 200);
    });

    $(document).on('click', '.editUserBtn', function() {
        const id = $(this).data('id');
        $.get(showUrl(id), function(res) {
            const user = res.user;
            $('#userId').val(user.id);
            $('#name').val(user.name);
            $('#username').val(user.username);
            $('#email').val(user.email);
            $('#mobile').val(user.mobile);
            let userType = (user.user_type || '').toLowerCase();
            let status = (user.status || '').toLowerCase();
            if (userType === 'admin' || userType === 'doctor' || userType === 'nurse' || userType === 'reception') {
                $('#user_type').val(userType);
            } else {
                $('#user_type').val('');
            }
            if (status === 'active' || status === 'deactivate') {
                $('#status').val(status.charAt(0).toUpperCase() + status.slice(1));
            } else {
                $('#status').val('Active');
            }
            $('#passcode').val(user.passcode);
            $('.password-fields').hide(); // Hide password fields on edit
            $('#userModalLabel').text('Edit User');
            $('#userModal').modal('show');
        });
    });

    $('#userForm').submit(function(e) {
        e.preventDefault();
        // Clear previous errors
        $('#userForm .form-control, #userForm .form-select').removeClass('is-invalid');
        $('#userForm .invalid-feedback').html('');
        const id = $('#userId').val();
        const method = id ? 'PUT' : 'POST';
        const url = id ? updateUrl(id) : storeUrl;
        let data = $(this).serializeArray();

        // Ensure status value matches database enum values
        data = data.map(field => {
            if (field.name === 'status') {
                field.value = field.value === 'Active' ? 'Active' : 'Deactivate';
            }
            return field;
        });

        // Remove password fields if they are empty
        data = data.filter(field => {
            if ((field.name === 'password' || field.name === 'password_confirmation') && !field.value) {
                return false;
            }
            return true;
        });

        $('#saveUserBtn').prop('disabled', true);
        $.ajax({
            url: url,
            type: method,
            data: $.param(data),
            success: function(res) {
                toastr.success('User saved successfully');
                $('#userModal').modal('hide');
                fetchUsers($('#searchUser').val());
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let msg = '';
                if (errors) {
                    for (let k in errors) {
                        msg += errors[k] + '<br>';
                        // Highlight field and show error
                        const field = $('#userForm [name="'+k+'"], #userForm [id="'+k+'"]');
                        field.addClass('is-invalid');
                        $('#error-'+k).html(errors[k]);
                    }
                }
                toastr.error(msg || 'Validation error');
            },
            complete: function() {
                $('#saveUserBtn').prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.deleteUserBtn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl(id),
                    type: 'DELETE',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function(res) {
                        toastr.success('User deleted');
                        fetchUsers($('#searchUser').val());
                    },
                    error: function() {
                        toastr.error('Failed to delete user');
                    }
                });
            }
        });
    });

    $('#userModal').on('hidden.bs.modal', function() {
        $('#userForm')[0].reset();
        $('#userId').val('');
        $('#userModalBackdrop').removeClass('show').css('display','none');
    });
});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@endpush
