@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Manage Hospital</h3>
            <button class="btn btn-light btn-sm">Add New Hospital</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
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
                            <td><img src="/path/to/logo.png" alt="Logo" class="img-thumbnail" style="width: 50px;"></td>
                            <td>
                                <p><strong>UserID:</strong> ThiDemo1</p>
                                <p><strong>Password:</strong> 9876543210</p>
                                <p><strong>Passcode:</strong> 1234</p>
                            </td>
                            <td>HEALTHCARE HOSPITAL</td>
                            <td>7836910002</td>
                            <td>CYPPS4987P</td>
                            <td>Plot No 199 Sector -28 Faridabad Haryana-121002</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                <a href="#" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
