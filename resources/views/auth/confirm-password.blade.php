@extends('layouts.guest')

@section('content')
<div class="confirm-password-page" style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="confirm-password-box" style="width: 100%; max-width: 400px;">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>Hospital</b>Admin</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">This is a secure area of the application. Please confirm your password before continuing.</p>
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('dashboard') }}">Back to dashboard</a>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
