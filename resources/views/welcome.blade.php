@extends('layouts.guest')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 92vh;">
        <div class="col-lg-10">
            <div class="card shadow border-0 overflow-hidden">
                <div class="row no-gutters">
                    <div class="col-md-6 bg-primary text-white p-5 d-flex flex-column justify-content-center">
                        <h1 class="display-5 font-weight-bold mb-3">
                            <i class="fas fa-hospital-symbol mr-2"></i>
                            Healthcare Hospital
                        </h1>
                        <p class="lead mb-4">Smart, fast, and reliable hospital management for your entire team.</p>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fas fa-check-circle mr-2"></i>Patient & OPD/IPD management</li>
                            <li class="mb-2"><i class="fas fa-check-circle mr-2"></i>Inventory, billing, and reports</li>
                            <li><i class="fas fa-check-circle mr-2"></i>Role-based secure access</li>
                        </ul>
                    </div>
                    <div class="col-md-6 p-5 d-flex flex-column justify-content-center bg-light">
                        <h2 class="h4 font-weight-bold text-dark mb-2">Welcome back</h2>
                        <p class="text-muted mb-4">Choose an action to continue.</p>
                        <div class="d-flex flex-wrap">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg mr-2 mb-2">
                                <i class="fas fa-sign-in-alt mr-1"></i> Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg mb-2">
                                    <i class="fas fa-user-plus mr-1"></i> Register
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
