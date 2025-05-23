@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Dashboard</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-success mb-0">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
