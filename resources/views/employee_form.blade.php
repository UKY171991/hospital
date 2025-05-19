<style>
    .input-error {
        box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25) !important;
        border-color: #dc3545 !important;
    }
</style>
@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Add/Update Employee</h3>
            <div class="card">
                <div class="card-body">
                    <form id="employeeForm" action="{{ isset($employee) ? route('employee.update', $employee->id) : route('employee.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($employee))
                            @method('PUT')
                        @endif
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Phone*</label>
                                <input type="text" name="phone" class="form-control" required value="{{ old('phone', $employee->phone ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Position*</label>
                                <input type="text" name="position" class="form-control" required value="{{ old('position', $employee->position ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Hospital*</label>
                                <select name="hospital_id" class="form-control" required>
                                    <option value="">-- Select Hospital --</option>
                                    @if(isset($hospitals))
                                        @foreach($hospitals as $hospital)
                                            <option value="{{ $hospital->id }}" {{ (old('hospital_id', $employee->hospital_id ?? '') == $hospital->id) ? 'selected' : '' }}>{{ $hospital->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Employee Name*</label>
                                <input type="text" name="name" class="form-control" required value="{{ old('name', $employee->name ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Relative Name</label>
                                <input type="text" name="relative_name" class="form-control" value="{{ old('relative_name', $employee->relative_name ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Mobile Number*</label>
                                <input type="text" name="mobile_no" class="form-control" required value="{{ old('mobile_no', $employee->mobile_no ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Alternate Mobile No</label>
                                <input type="text" name="alternate_mobile_no" class="form-control" value="{{ old('alternate_mobile_no', $employee->alternate_mobile_no ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Employee Email*</label>
                                <input type="email" name="email" class="form-control" required value="{{ old('email', $employee->email ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date Of Birth</label>
                                <input type="date" name="dob" class="form-control" value="{{ old('dob', $employee->dob ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Gender*</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Male" {{ old('gender', $employee->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $employee->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $employee->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Aadhar Number</label>
                                <input type="text" name="aadhar_no" class="form-control" value="{{ old('aadhar_no', $employee->aadhar_no ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Pan Number</label>
                                <input type="text" name="pan_no" class="form-control" value="{{ old('pan_no', $employee->pan_no ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Current Address*</label>
                                <input type="text" name="current_address" class="form-control" required value="{{ old('current_address', $employee->current_address ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Permanent Address</label>
                                <input type="text" name="permanent_address" class="form-control" value="{{ old('permanent_address', $employee->permanent_address ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Marital Status</label>
                                <select name="marital_status" class="form-control">
                                    <option value="Single" {{ old('marital_status', $employee->marital_status ?? '') == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('marital_status', $employee->marital_status ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Blood Group</label>
                                <select name="blood_group" class="form-control">
                                    <option value="">Not Know</option>
                                    <option value="A+" {{ old('blood_group', $employee->blood_group ?? '') == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_group', $employee->blood_group ?? '') == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_group', $employee->blood_group ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_group', $employee->blood_group ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="O+" {{ old('blood_group', $employee->blood_group ?? '') == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_group', $employee->blood_group ?? '') == 'O-' ? 'selected' : '' }}>O-</option>
                                    <option value="AB+" {{ old('blood_group', $employee->blood_group ?? '') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_group', $employee->blood_group ?? '') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Education</label>
                                <input type="text" name="education" class="form-control" value="{{ old('education', $employee->education ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Experience Year</label>
                                <input type="text" name="experience_year" class="form-control" value="{{ old('experience_year', $employee->experience_year ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Joining Date</label>
                                <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date', $employee->joining_date ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Leaving Date</label>
                                <input type="date" name="leaving_date" class="form-control" value="{{ old('leaving_date', $employee->leaving_date ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Role*</label>
                                <select name="role" class="form-control" required>
                                    <option value="">-- Select Any One --</option>
                                    <option value="Doctor" {{ old('role', $employee->role ?? '') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                                    <option value="Nurse" {{ old('role', $employee->role ?? '') == 'Nurse' ? 'selected' : '' }}>Nurse</option>
                                    <option value="Staff" {{ old('role', $employee->role ?? '') == 'Staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="Other" {{ old('role', $employee->role ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Department*</label>
                                <select name="department" class="form-control" required>
                                    <option value="">-- Select Any One --</option>
                                    <option value="Ear Dept" {{ old('department', $employee->department ?? '') == 'Ear Dept' ? 'selected' : '' }}>Ear Dept</option>
                                    <option value="Eye Dept" {{ old('department', $employee->department ?? '') == 'Eye Dept' ? 'selected' : '' }}>Eye Dept</option>
                                    <option value="General" {{ old('department', $employee->department ?? '') == 'General' ? 'selected' : '' }}>General</option>
                                    <option value="Other" {{ old('department', $employee->department ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $employee->bank_name ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Branch Name</label>
                                <input type="text" name="branch_name" class="form-control" value="{{ old('branch_name', $employee->branch_name ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Account Number</label>
                                <input type="text" name="account_no" class="form-control" value="{{ old('account_no', $employee->account_no ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Account Holder Name</label>
                                <input type="text" name="account_holder_name" class="form-control" value="{{ old('account_holder_name', $employee->account_holder_name ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">IFSC Code</label>
                                <input type="text" name="ifsc_code" class="form-control" value="{{ old('ifsc_code', $employee->ifsc_code ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Opening Balance</label>
                                <input type="text" name="opening_balance" class="form-control" value="{{ old('opening_balance', $employee->opening_balance ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Salary (One Day)*</label>
                                <input type="text" name="salary" class="form-control" required value="{{ old('salary', $employee->salary ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Employee Photo</label>
                                <input type="file" name="photo" class="form-control">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-danger" id="saveBtn">{{ isset($employee) ? 'Update' : 'Save' }}</button>
                            <a href="/employee/manage" class="btn btn-secondary">Employee List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function() {
    $('#employeeForm').on('submit', function(e) {
        e.preventDefault();
        // Remove previous error highlights
        $('#employeeForm .input-error').removeClass('input-error');
        var formData = new FormData(this);
        $('#saveBtn').prop('disabled', true).text('Saving...');
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success('Employee saved successfully!');
                setTimeout(function() {
                    window.location.href = '/employee/manage';
                }, 1200);
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        toastr.error(errors[key][0]);
                        // Highlight the error field
                        var field = $('[name="' + key + '"]');
                        if (field.length) {
                            field.addClass('input-error');
                        }
                    });
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Please check your input.');
                }
                $('#saveBtn').prop('disabled', false).text('Save');
            }
        });
    });
});
</script>
@endsection
