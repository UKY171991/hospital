@extends('layouts.app')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 fw-bold">Welcome back, {{ Auth::user()->name ?? 'Admin' }}!</h1>
                <p class="text-muted">Here's an overview of your hospital stats today.</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-4 mt-2">
        <!-- Doctors -->
        <div class="col-md-3 col-6">
            <div class="card dashboard-card glass-card border-0 shadow-sm text-white bg-gradient-primary">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-user-md fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">4</h3>
                        <div class="small">Doctors</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Patients -->
        <div class="col-md-3 col-6">
            <div class="card dashboard-card glass-card border-0 shadow-sm text-white bg-gradient-success">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-user-injured fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">23</h3>
                        <div class="small">Patients</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Employees -->
        <div class="col-md-3 col-6">
            <div class="card dashboard-card glass-card border-0 shadow-sm text-white bg-gradient-info">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">7</h3>
                        <div class="small">Employees</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- In/Out Patients -->
        <div class="col-md-3 col-6">
            <div class="card dashboard-card glass-card border-0 shadow-sm text-white bg-gradient-warning">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-heartbeat fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">49</h3>
                        <div class="small">In/Out Patients</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
