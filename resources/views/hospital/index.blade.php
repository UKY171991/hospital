@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-primary mb-0">Manage Hospital</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow rounded-4 border-0">
                <div class="card-body p-4">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th>S.No.</th>
                                <th>Logo</th>
                                <th>Login Details</th>
                                <th>Name</th>
                                <th>Contact No</th>
                                <th>PAN No</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><img src="/path/to/logo.png" alt="Logo" style="width: 50px; height: auto;"></td>
                                <td>
                                    <p>UserID: ThiDemo1</p>
                                    <p>Password: 9876543210</p>
                                    <p>Passcode: 1234</p>
                                </td>
                                <td>HEALTHCARE HOSPITAL</td>
                                <td>7836910002</td>
                                <td>CYPPS4987P</td>
                                <td>Plot No 199 Sector -28 Faridabad Haryana-121002</td>
                                <td><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
