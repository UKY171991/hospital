@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Add/Update Employee</h3>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Employee Name*</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Relative Name</label>
                                <input type="text" name="relative_name" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Mobile Number*</label>
                                <input type="text" name="mobile_no" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Alternate Mobile No</label>
                                <input type="text" name="alternate_mobile_no" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Employee Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date Of Birth</label>
                                <input type="date" name="dob" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Gender*</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Aadhar Number</label>
                                <input type="text" name="aadhar_no" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Pan Number</label>
                                <input type="text" name="pan_no" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Current Address*</label>
                                <input type="text" name="current_address" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Permanent Address</label>
                                <input type="text" name="permanent_address" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Marital Status</label>
                                <select name="marital_status" class="form-control">
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Blood Group</label>
                                <select name="blood_group" class="form-control">
                                    <option value="">Not Know</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Education</label>
                                <input type="text" name="education" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Experience Year</label>
                                <input type="text" name="experience_year" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Joining Date</label>
                                <input type="date" name="joining_date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Leaving Date</label>
                                <input type="date" name="leaving_date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Role*</label>
                                <select name="role" class="form-control" required>
                                    <option value="">-- Select Any One --</option>
                                    <option value="Doctor">Doctor</option>
                                    <option value="Nurse">Nurse</option>
                                    <option value="Staff">Staff</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Department*</label>
                                <select name="department" class="form-control" required>
                                    <option value="">-- Select Any One --</option>
                                    <option value="Ear Dept">Ear Dept</option>
                                    <option value="Eye Dept">Eye Dept</option>
                                    <option value="General">General</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Branch Name</label>
                                <input type="text" name="branch_name" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Account Number</label>
                                <input type="text" name="account_no" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Account Holder Name</label>
                                <input type="text" name="account_holder_name" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">IFSC Code</label>
                                <input type="text" name="ifsc_code" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Opening Balance</label>
                                <input type="text" name="opening_balance" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Salary (One Day)*</label>
                                <input type="text" name="salary" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Employee Photo</label>
                                <input type="file" name="photo" class="form-control">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-danger">Save</button>
                            <a href="/employee/manage" class="btn btn-secondary">Employee List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
