@extends('layouts.app')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Item List</h1>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-2">
                <button class="btn btn-primary btn-xs" id="addItemBtn"><i class="fas fa-plus"></i> Add Item</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" id="itemTable" style="width:100%">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>S.No.</th>
                            <th>Item Name</th>
                            <th>Item Code</th>
                            <th>PurchasePrice</th>
                            <th>SalesPrice</th>
                            <th>Unit</th>
                            <th>Opening Stock</th>
                            <th>Current Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@include('item.modal')
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css"/>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
<script>
let table;
$(function() {
    // Global AJAX setup for CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Global AJAX error handler for session expiry
    $(document).ajaxError(function(event, xhr, settings, thrownError) {
        if (xhr.status === 419) {
            alert('Your session has expired. The page will be refreshed to continue.');
            location.reload();
        }
    });

    table = $('#itemTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/item',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'item_name', name: 'item_name' },
            { data: 'item_code', name: 'item_code' },
            { data: 'purchase_price', name: 'purchase_price' },
            { data: 'sales_price', name: 'sales_price' },
            { data: 'unit', name: 'unit' },
            { data: 'opening_stock', name: 'opening_stock' },
            { data: 'current_stock', name: 'current_stock' },
            { 
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-info editBtn" data-id="${row.id}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${row.id}" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn-success'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn-danger'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn-info'
            },
            {
                extend: 'colvis',
                text: '<i class="fas fa-columns"></i> Columns',
                className: 'btn-secondary'
            }
        ],
        responsive: true,
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
            emptyTable: 'No items found',
            zeroRecords: 'No matching items found'
        }
    });

    $('#addItemBtn').click(function(){
        $('#itemForm')[0].reset();
        $('#itemId').val('');
        $('#itemModalLabel').text('Add Item');
        $('#itemModal').modal('show');
    });

    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');
        $.get('/item/' + id)
        .done(function(item){
            $('#itemId').val(item.id || '');
            $('#type').val(item.type || '');
            $('#item_name').val(item.item_name || '');
            $('#item_code').val(item.item_code || '');
            $('#hsn_sac_code').val(item.hsn_sac_code || '');
            $('#sales_price').val(item.sales_price || '');
            $('#purchase_price').val(item.purchase_price || '');
            $('#unit').val(item.unit || '');
            $('#opening_stock').val(item.opening_stock || '');
            $('#itemModalLabel').text('Edit Item');
            $('#itemModal').modal('show');
        })
        .fail(function() {
            alert('Failed to load item data. Please try again.');
        });
    });

    $(document).on('click', '.deleteBtn', function() {
        if(confirm('Are you sure you want to delete this item?')) {
            let id = $(this).data('id');
            $.ajax({
                url: '/item/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    table.ajax.reload();
                    if(response.message) {
                        alert('Success: ' + response.message);
                    } else {
                        alert('Item deleted successfully!');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Delete failed.'));
                }
            });
        }
    });

    $(document).on('click', '.toggleStatus', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        let status = $(this).data('status');
        let button = $(this);
        
        // Disable button during request
        button.prop('disabled', true);
        
        $.ajax({
            url: `/item/toggle-status/${id}`,
            type: 'POST',
            data: { status: status },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response){
                table.ajax.reload();
                if(response.message) {
                    alert('Success: ' + response.message);
                } else {
                    alert('Item status updated successfully!');
                }
            },
            error: function(xhr) {
                console.error('Status toggle error:', xhr.status, xhr.responseText);
                if (xhr.status === 419) {
                    alert('Your session has expired. The page will be refreshed to continue.');
                    location.reload();
                } else {
                    let msg = 'Error: ';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg += xhr.responseJSON.message;
                    } else {
                        msg += 'Status update failed.';
                    }
                    alert(msg);
                }
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    });

    $('#itemForm').submit(function(e){
        e.preventDefault();
        let id = $('#itemId').val();
        let url = id ? '/item/' + id : '/item';
        let type = 'POST';
        let formData = $(this).serialize();
        if (id) formData += '&_method=PUT';
        
        $.ajax({
            url: url,
            type: type,
            data: formData,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response){
                $('#itemModal').modal('hide');
                table.ajax.reload();
                // Show success message
                if(response.message) {
                    alert('Success: ' + response.message);
                } else {
                    alert('Item saved successfully!');
                }
            },
            error: function(xhr) {
                let msg = 'Error: ';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // Laravel validation errors
                    for (const key in xhr.responseJSON.errors) {
                        msg += `\n${xhr.responseJSON.errors[key].join(' ')}`;
                    }
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg += xhr.responseJSON.message;
                } else {
                    msg += 'An error occurred.';
                }
                alert(msg);
            }
        });
    });
});
</script>
@endpush 