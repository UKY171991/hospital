@extends('layouts.guest')

@section('content')
<div class="verify-email-page" style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="verify-email-box" style="width: 100%; max-width: 400px;">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>Hospital</b>Admin</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success mb-3">
                        A new verification link has been sent to the email address you provided during registration.
                    </div>
                @endif
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
