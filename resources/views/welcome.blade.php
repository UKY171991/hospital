@extends('layouts.guest')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 90vh;">
    <div class="text-center">
        <h1 class="display-4 mb-4"><i class="fas fa-hospital-symbol text-danger"></i> Welcome to Healthcare Hospital</h1>
        <p class="lead mb-4">Your trusted hospital management system.</p>
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2"><i class="fas fa-sign-in-alt"></i> Login</a>
        <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg"><i class="fas fa-user-plus"></i> Register</a>
    </div>
</div>
@endsection
