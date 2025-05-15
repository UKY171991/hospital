@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Add/Update Hospital</h3>
            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($hospital) ? route('hospital.update', $hospital->id) : route('hospital.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($hospital))
                            @method('PUT')
                        @endif
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Hospital Name*</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $hospital->name ?? '') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact No*</label>
                                <input type="text" name="contact_no" class="form-control" value="{{ old('contact_no', $hospital->contact_no ?? '') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $hospital->email ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Hospital Tag Line</label>
                                <input type="text" name="tag_line" class="form-control" value="{{ old('tag_line', $hospital->tag_line ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">PAN Number</label>
                                <input type="text" name="pan_no" class="form-control" value="{{ old('pan_no', $hospital->pan_no ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Address*</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address', $hospital->address ?? '') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $hospital->bank_name ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Branch Name</label>
                                <input type="text" name="branch_name" class="form-control" value="{{ old('branch_name', $hospital->branch_name ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">IFSC Code</label>
                                <input type="text" name="ifsc_code" class="form-control" value="{{ old('ifsc_code', $hospital->ifsc_code ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Account No</label>
                                <input type="text" name="account_no" class="form-control" value="{{ old('account_no', $hospital->account_no ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">GSTIN Number</label>
                                <input type="text" name="gstin_no" class="form-control" value="{{ old('gstin_no', $hospital->gstin_no ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">CIN Number</label>
                                <input type="text" name="cin_no" class="form-control" value="{{ old('cin_no', $hospital->cin_no ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Hospital Prefix</label>
                                <input type="text" name="prefix" class="form-control" value="{{ old('prefix', $hospital->prefix ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Logo</label>
                                <input type="file" name="logo" class="form-control">
                                @if(isset($hospital) && $hospital->logo)
                                    <img src="{{ asset('storage/' . $hospital->logo) }}" alt="Logo" width="80" class="mt-2">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Signature</label>
                                <input type="file" name="signature" class="form-control">
                                @if(isset($hospital) && $hospital->signature)
                                    <img src="{{ asset('storage/' . $hospital->signature) }}" alt="Signature" width="80" class="mt-2">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Stamp</label>
                                <input type="file" name="stamp" class="form-control">
                                @if(isset($hospital) && $hospital->stamp)
                                    <img src="{{ asset('storage/' . $hospital->stamp) }}" alt="Stamp" width="80" class="mt-2">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Payment QR Code</label>
                                <input type="file" name="payment_qr" class="form-control">
                                @if(isset($hospital) && $hospital->payment_qr)
                                    <img src="{{ asset('storage/' . $hospital->payment_qr) }}" alt="QR Code" width="80" class="mt-2">
                                @endif
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-danger">{{ isset($hospital) ? 'Update' : 'Save' }}</button>
                            <a href="{{ route('hospital.manage') }}" class="btn btn-secondary">Hospital List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
