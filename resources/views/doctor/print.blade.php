@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Doctor Details</h3>
                    <div class="card-tools">
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            @if($doctor->photo)
                                <img src="{{ asset('storage/doctor_photos/' . $doctor->photo) }}" 
                                     class="img-fluid rounded" 
                                     alt="Doctor Photo">
                            @else
                                <img src="https://via.placeholder.com/200x200?text=No+Image" 
                                     class="img-fluid rounded" 
                                     alt="No Photo">
                            @endif
                        </div>
                        <div class="col-md-9">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $doctor->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Specialization:</th>
                                    <td>{{ $doctor->specialization ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $doctor->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $doctor->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $doctor->address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge badge-{{ $doctor->status == 'Active' ? 'success' : 'warning' }}">
                                            {{ $doctor->status ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .card, .card * {
        visibility: visible;
    }
    .card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .card-tools {
        display: none;
    }
}
</style>
@endsection
