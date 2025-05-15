@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Manage Employee</h3>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-2">
                        <a href="/employee/create" class="btn btn-success">+ Create Employee</a>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th>S.No.</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>EmployeeId</th>
                                <th>Department</th>
                                <th>Address</th>
                                <th>Mobile No</th>
                                <th>Pan No</th>
                                <th>Account No</th>
                                <th>Ifsc Code</th>
                                <th>Opening Bal</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        {{-- @foreach($employees as $index => $employee)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($employee->photo)
                                        <img src="{{ asset('storage/' . $employee->photo) }}" alt="Photo" width="50" height="50">
                                    @else
                                        <span>No Photo</span>
                                    @endif
                                </td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->employeeid }}</td>
                                <td>{{ $employee->department }}</td>
                                <td>{{ $employee->address }}</td>
                                <td>{{ $employee->mobile_no }}</td>
                                <td>{{ $employee->pan_no }}</td>
                                <td>{{ $employee->account_no }}</td>
                                <td>{{ $employee->ifsc_code }}</td>
                                <td>{{ $employee->opening_bal }}</td>
                                <td>{{ $employee->status }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                    <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-success"><i class="fa fa-print"></i></a>
                                </td>
                            </tr>
                        @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
