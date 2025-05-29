@extends('layouts.guest')

@section('content')
<div class="forgot-password-page" style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="forgot-password-box" style="width: 100%; max-width: 400px;">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>Hospital</b>Admin</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.</p>
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('login') }}">Back to login</a>
                        <button type="submit" class="btn btn-primary">Email Password Reset Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
