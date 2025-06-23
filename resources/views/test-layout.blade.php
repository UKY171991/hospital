@extends('layouts.app')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 fw-bold">Test Layout</h1>
                <p class="text-muted">This is a test to check if the layout file works properly</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3>Test Card</h3>
        </div>
        <div class="card-body">
            <p>If you can see this, the layout file is working correctly!</p>
            <p>Current time: {{ date('Y-m-d H:i:s') }}</p>
            <p>Auth user: {{ Auth::user()->name ?? 'Not logged in' }}</p>
        </div>
    </div>
</div>
@endsection
