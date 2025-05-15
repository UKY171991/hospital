@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="my-4">Change Password/Passcode</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Change Password:</h5>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Current Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" placeholder="Enter Current Password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" placeholder="Enter New Password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" placeholder="Enter Again New Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Change</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Change Passcode:</h5>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Current Passcode<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" placeholder="Enter Current Passcode">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Passcode<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" placeholder="Enter New Passcode">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Passcode<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" placeholder="Enter Again New Passcode">
                        </div>
                        <button type="submit" class="btn btn-success">Change</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
