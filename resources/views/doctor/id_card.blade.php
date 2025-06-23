@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="max-width: 400px; margin: 0 auto;">
                <div class="card-header bg-primary text-white text-center">
                    <h5>{{ config('app.name', 'Hospital') }}</h5>
                    <small>Doctor ID Card</small>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($doctor->photo)
                            <img src="{{ asset('storage/doctor_photos/' . $doctor->photo) }}" 
                                 class="rounded-circle" 
                                 style="width: 100px; height: 100px; object-fit: cover;"
                                 alt="Doctor Photo">
                        @else
                            <img src="https://via.placeholder.com/100x100?text=No+Image" 
                                 class="rounded-circle" 
                                 style="width: 100px; height: 100px;"
                                 alt="No Photo">
                        @endif
                    </div>
                    <h5 class="mb-1">{{ $doctor->name ?? 'N/A' }}</h5>
                    <p class="text-muted mb-2">{{ $doctor->specialization ?? 'Doctor' }}</p>
                    
                    <div class="text-left mt-3">
                        <div class="row">
                            <div class="col-4"><strong>ID:</strong></div>
                            <div class="col-8">{{ $doctor->id ?? 'N/A' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4"><strong>Phone:</strong></div>
                            <div class="col-8">{{ $doctor->phone ?? 'N/A' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4"><strong>Email:</strong></div>
                            <div class="col-8">{{ $doctor->email ?? 'N/A' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4"><strong>Status:</strong></div>
                            <div class="col-8">
                                <span class="badge badge-{{ $doctor->status == 'Active' ? 'success' : 'warning' }}">
                                    {{ $doctor->status ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <small class="text-muted">Valid Hospital ID Card</small>
                    <div class="mt-2">
                        <button onclick="window.print()" class="btn btn-primary btn-sm">
                            <i class="fas fa-print"></i> Print Card
                        </button>
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
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
    .card-footer .btn {
        display: none;
    }
}
</style>
@endsection
