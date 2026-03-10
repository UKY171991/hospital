@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-8">
            <h1 class="m-0"><i class="{{ $icon ?? 'fas fa-file-alt' }} me-2"></i>{{ $title ?? 'Page' }}</h1>
            <p class="text-muted mb-0">{{ $description ?? 'This page is now available from the sidebar menu.' }}</p>
        </div>
        <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $title ?? 'Page' }}</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-body text-center py-5">
            <i class="{{ $icon ?? 'fas fa-file-alt' }} fa-3x text-primary mb-3"></i>
            <h4 class="mb-2">{{ $title ?? 'Page' }} is ready</h4>
            <p class="text-muted mb-4">{{ $description ?? 'You can continue building detailed workflows here.' }}</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
