@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="my-4">User List</h2>
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="userType" class="col-form-label">User Type</label>
                </div>
                <div class="col-auto">
                    <select class="form-select" id="userType" name="userType">
                        <option selected>Doctor Wise</option>
                        <option>Nurse Wise</option>
                        <option>Employee Wise</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="mb-2">
                <button class="btn btn-danger btn-sm">Excel</button>
                <button class="btn btn-danger btn-sm">PDF</button>
                <button class="btn btn-danger btn-sm">Print</button>
                <button class="btn btn-danger btn-sm dropdown-toggle" data-bs-toggle="dropdown">Column visibility</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead style="background: linear-gradient(155deg, #b40c00, #0a0b22a3); color: #fff;">
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="background: #ffe6ea;">
                            <td>1</td>
                            <td>DemoAyush1</td>
                            <td>98552326562</td>
                            <td>1234</td>
                            <td>Doctor</td>
                            <td>Ayush Raj</td>
                            <td>98552326562</td>
                            <td>khs201496@GMAIL.COM</td>
                            <td><span class="btn btn-warning btn-sm">Deactive</span></td>
                        </tr>
                        <tr style="background: #ffe6ea;">
                            <td>2</td>
                            <td>DemoSonu2</td>
                            <td>9568658569</td>
                            <td>1234</td>
                            <td>Doctor</td>
                            <td>DR MR SONU RAJ YADAV</td>
                            <td>9568658569</td>
                            <td>technicalhelpindia9@gmail.com</td>
                            <td><span class="btn btn-success btn-sm">Active</span></td>
                        </tr>
                        <tr style="background: #ffe6ea;">
                            <td>3</td>
                            <td>RAGHAVDR29</td>
                            <td>9876543210</td>
                            <td>1234</td>
                            <td>Doctor</td>
                            <td>DR SUMAN</td>
                            <td>9876543210</td>
                            <td></td>
                            <td><span class="btn btn-success btn-sm">Active</span></td>
                        </tr>
                        <tr style="background: #ffe6ea;">
                            <td>4</td>
                            <td>ABCDDR.49</td>
                            <td>8826322273</td>
                            <td>1234</td>
                            <td>Doctor</td>
                            <td>DR. NAVNEET</td>
                            <td>8826322273</td>
                            <td></td>
                            <td><span class="btn btn-success btn-sm">Active</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div>Showing 1 to 4 of 4 entries</div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                        <li class="page-item active"><span class="page-link">1</span></li>
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
