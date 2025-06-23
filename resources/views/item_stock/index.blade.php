@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-boxes mr-2"></i>Item Stock</h1>
            <p class="text-muted">Monitor item stock levels and inventory</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Item Stock</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Item Stock Report</h1>
        </div>
        <div class="col-sm-6 text-right">
            <form id="filterForm" class="form-inline float-right">
                <label for="month" class="mr-2">Month</label>
                <input type="month" id="month" name="month" class="form-control mr-2" value="{{ date('Y-m') }}">
                <button type="button" class="btn btn-success" id="printBtn"><i class="fas fa-print"></i> Print</button>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="stockTable">
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Name Of Item</th>
                        <th>Opening Stock</th>
                        <th>Purchased Item</th>
                        <th>Sold Item</th>
                        <th>Current Stock</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>
// Ensure CSRF token is sent with all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(function() {
    function getMonthYear() {
        var val = $('#month').val();
        var parts = val.split('-');
        return { month: parts[1], year: parts[0] };
    }
    var table = $('#stockTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        paging: false,
        info: false,
        ajax: {
            url: '{{ url('item_stock') }}',
            data: function(d) {
                var my = getMonthYear();
                d.month = my.month;
                d.year = my.year;
            }
        },
        columns: [
            { data: 'sr_no', name: 'sr_no' },
            { data: 'item_name', name: 'item_name' },
            { data: 'opening_stock', name: 'opening_stock' },
            { data: 'purchased', name: 'purchased' },
            { data: 'sold', name: 'sold' },
            { data: 'current_stock', name: 'current_stock' },
        ]
    });
    $('#month').on('change', function() {
        table.ajax.reload();
    });
    $('#printBtn').on('click', function() {
        window.print();
    });
});
</script>
@endpush 