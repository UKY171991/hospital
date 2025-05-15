@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Manage Hospital</h3>
            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('hospital.create') }}" class="btn btn-success">+ Add Hospital</a>
            </div>
            <div class="card">
                <div class="card-body">
                    @if($hospitals->isEmpty())
                        <div class="alert alert-info">No hospitals found.</div>
                    @else
                    <table class="table table-bordered table-striped">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th>S.No.</th>
                                <th>Logo</th>
                                <th>Login Details</th>
                                <th>Name</th>
                                <th>Contact No</th>
                                <th>Pan No</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($hospitals as $index => $hospital)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($hospital->logo)
                                        <img src="{{ asset('storage/' . $hospital->logo) }}" alt="Logo" width="50" height="50">
                                    @else
                                        <span>No Logo</span>
                                    @endif
                                </td>
                                <td>
                                    Userid: {{ $hospital->userid }}<br>
                                    Password: {{ $hospital->password }}<br>
                                    Passcode: {{ $hospital->passcode }}
                                </td>
                                <td>{{ $hospital->name }}</td>
                                <td>{{ $hospital->contact_no }}</td>
                                <td>{{ $hospital->pan_no }}</td>
                                <td>{{ $hospital->address }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
