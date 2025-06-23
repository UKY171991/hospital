@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-building mr-2"></i>Department Test</h1>
            <p class="text-muted">Test version of department management</p>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list mr-2"></i>Department Test Table
                    </h5>
                </div>
                <div class="card-body">
                    <div id="debug-info" class="mb-3">
                        <h6>Debug Information:</h6>
                        <p id="ajax-status">AJAX Status: Not tested</p>
                        <p id="data-count">Data Count: Unknown</p>
                    </div>
                    
                    <button id="test-ajax" class="btn btn-info mb-3">Test AJAX Call</button>
                    <button id="reload-table" class="btn btn-warning mb-3">Reload Table</button>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="testTable" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Department</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>
$(function() {
    console.log('Test page loaded');
    
    // Global AJAX setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    let table;
    
    function initTable(data = []) {
        if (table) {
            table.destroy();
        }
        
        // Clear existing tbody
        $('#testTable tbody').empty();
        
        // Add data manually for testing
        if (data.length > 0) {
            data.forEach(function(dept) {
                $('#testTable tbody').append(`
                    <tr>
                        <td>${dept.id}</td>
                        <td>${dept.department}</td>
                        <td>${dept.description || ''}</td>
                        <td>${dept.status}</td>
                        <td>${dept.created_at}</td>
                    </tr>
                `);
            });
        }
        
        table = $('#testTable').DataTable({
            processing: false,
            serverSide: false,
            responsive: true,
            pageLength: 25,
            initComplete: function() {
                console.log('Test table initialized with', this.api().rows().count(), 'rows');
            }
        });
    }
    
    $('#test-ajax').click(function() {
        console.log('Testing AJAX call...');
        $('#ajax-status').text('AJAX Status: Testing...');
        
        $.ajax({
            url: '/department-debug',
            type: 'GET',
            success: function(response) {
                console.log('AJAX Success:', response);
                $('#ajax-status').text('AJAX Status: Success');
                $('#data-count').text('Data Count: ' + response.count);
                
                if (response.data && response.data.length > 0) {
                    initTable(response.data);
                } else {
                    $('#ajax-status').text('AJAX Status: Success but no data');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr, status, error);
                $('#ajax-status').text('AJAX Status: Error - ' + xhr.status);
            }
        });
    });
    
    $('#reload-table').click(function() {
        if (table) {
            table.ajax.reload();
        }
    });
    
    // Initialize empty table
    initTable();
    
    // Auto-test on load
    $('#test-ajax').click();
});
</script>
@endpush
