@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Sale List</h1>
        </div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-primary" id="addSaleBtn">+ New Sale</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="saleTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Client Name</th>
                        <th>Sale Date</th>
                        <th>Invoice No</th>
                        <th>No of Items</th>
                        <th>Discount</th>
                        <th>Gross Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="saleModal" tabindex="-1" role="dialog" aria-labelledby="saleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <form id="saleForm">
        <div class="modal-header">
          <h5 class="modal-title" id="saleModalLabel">Add/Update Sale</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Date *</label>
                <input type="date" name="date" class="form-control" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Client Name *</label>
                <input type="text" name="client_name" class="form-control" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Mobile No *</label>
                <input type="text" name="mobile_no" class="form-control" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control">
              </div>
            </div>
          </div>
          <div id="itemsSection">
            <div class="row item-row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Item Name *</label>
                  <input type="text" name="item_name[]" class="form-control" required>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Price *</label>
                  <input type="number" name="price[]" class="form-control" required>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Quantity *</label>
                  <input type="number" name="quantity[]" class="form-control" required>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Amount</label>
                  <input type="number" name="amount[]" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger removeItemBtn"><i class="fas fa-trash"></i></button>
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-info" id="addItemBtn"><i class="fas fa-plus"></i> Add Item</button>
          <div class="row mt-3">
            <div class="col-md-3">
              <div class="form-group">
                <label>Total Amount</label>
                <input type="number" name="total_amount" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Total Discount *</label>
                <input type="number" name="total_discount" class="form-control" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Grand Total</label>
                <input type="number" name="grand_total" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Remark</label>
                <input type="text" name="remark" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add View Details Modal -->
<div class="modal fade" id="viewSaleModal" tabindex="-1" role="dialog" aria-labelledby="viewSaleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewSaleModalLabel">Sale Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="saleDetailsBody">
        <!-- Sale details will be loaded here -->
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
<script>
// Ensure CSRF token is sent with all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(function() {
    var table = $('#saleTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('sale_item') }}',
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', className: 'btn btn-success btn-sm' },
            { extend: 'pdf', className: 'btn btn-danger btn-sm' },
            { extend: 'print', className: 'btn btn-info btn-sm' },
            { extend: 'colvis', className: 'btn btn-secondary btn-sm', text: 'Column visibility' }
        ],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'client_name', name: 'client_name' },
            { data: 'date', name: 'date' },
            { data: 'id', name: 'id', render: function(data, type, row, meta) { return row.id; } },
            { data: 'items', name: 'items', render: function(data, type, row, meta) {
                try {
                    var arr = JSON.parse(data);
                    return Array.isArray(arr) ? arr.length : 0;
                } catch (e) {
                    return 0;
                }
            } },
            { data: 'total_discount', name: 'total_discount' },
            { data: 'grand_total', name: 'grand_total' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Add Sale
    $('#addSaleBtn').click(function() {
        $('#saleForm')[0].reset();
        $('#saleModalLabel').text('Add Sale');
        $('#saleModal').modal('show');
        $('#saleForm').attr('data-id', '');
        $('#itemsSection').html(getItemRowHtml());
    });

    // Add Item Row
    $('#addItemBtn').click(function() {
        $('#itemsSection').append(getItemRowHtml());
    });

    // Remove Item Row
    $(document).on('click', '.removeItemBtn', function() {
        if ($('.item-row').length > 1) {
            $(this).closest('.item-row').remove();
            calculateTotals();
        }
    });

    // Calculate Amount on Price/Quantity Change
    $(document).on('input', 'input[name="price[]"], input[name="quantity[]"]', function() {
        var row = $(this).closest('.item-row');
        var price = parseFloat(row.find('input[name="price[]"]').val()) || 0;
        var qty = parseFloat(row.find('input[name="quantity[]"]').val()) || 0;
        row.find('input[name="amount[]"]').val(price * qty);
        calculateTotals();
    });

    // Calculate Grand Total on Discount Change
    $(document).on('input', 'input[name="total_discount"]', function() {
        calculateTotals();
    });

    function calculateTotals() {
        var total = 0;
        $('input[name="amount[]"]').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $('input[name="total_amount"]').val(total);
        var discount = parseFloat($('input[name="total_discount"]').val()) || 0;
        $('input[name="grand_total"]').val(total - discount);
    }

    function getItemRowHtml() {
        return `<div class="row item-row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Item Name *</label>
                    <input type="text" name="item_name[]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Price *</label>
                    <input type="number" name="price[]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Quantity *</label>
                    <input type="number" name="quantity[]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" name="amount[]" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger removeItemBtn"><i class="fas fa-trash"></i></button>
            </div>
        </div>`;
    }

    // Save Sale (Add/Edit)
    $('#saleForm').submit(function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var method = id ? 'POST' : 'POST';
        var url = id ? 'sale_item/' + id : 'sale_item';
        if(id) var _method = 'PUT';
        var items = [];
        $('#itemsSection .item-row').each(function() {
            items.push({
                item_name: $(this).find('input[name="item_name[]"]').val(),
                price: $(this).find('input[name="price[]"]').val(),
                quantity: $(this).find('input[name="quantity[]"]').val(),
                amount: $(this).find('input[name="amount[]"]').val(),
            });
        });
        var formData = {
            date: $('input[name="date"]').val(),
            client_name: $('input[name="client_name"]').val(),
            mobile_no: $('input[name="mobile_no"]').val(),
            address: $('input[name="address"]').val(),
            items: items,
            total_amount: $('input[name="total_amount"]').val(),
            total_discount: $('input[name="total_discount"]').val(),
            grand_total: $('input[name="grand_total"]').val(),
            remark: $('input[name="remark"]').val(),
        };
        if(id) formData._method = 'PUT';
        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(res) {
                $('#saleModal').modal('hide');
                table.ajax.reload();
                toastr.success(res.message);
            },
            error: function(xhr) {
                var err = xhr.responseJSON;
                toastr.error(err.message || 'Validation error!');
            }
        });
    });

    // Edit Sale
    $('#saleTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('sale_item/' + id, function(data) {
            $('#saleForm')[0].reset();
            $('#saleModalLabel').text('Update Sale');
            $('#saleForm').attr('data-id', id);
            $('input[name="date"]').val(data.date);
            $('input[name="client_name"]').val(data.client_name);
            $('input[name="mobile_no"]').val(data.mobile_no);
            $('input[name="address"]').val(data.address);
            $('input[name="total_amount"]').val(data.total_amount);
            $('input[name="total_discount"]').val(data.total_discount);
            $('input[name="grand_total"]').val(data.grand_total);
            $('input[name="remark"]').val(data.remark);
            $('#itemsSection').html('');
            data.items.forEach(function(item, idx) {
                var row = $(getItemRowHtml());
                row.find('input[name="item_name[]"]').val(item.item_name);
                row.find('input[name="price[]"]').val(item.price);
                row.find('input[name="quantity[]"]').val(item.quantity);
                row.find('input[name="amount[]"]').val(item.amount);
                $('#itemsSection').append(row);
            });
            $('#saleModal').modal('show');
        });
    });

    // Delete Sale
    $('#saleTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this sale?')) {
            $.ajax({
                url: 'sale_item/' + id,
                type: 'POST',
                data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                success: function(res) {
                    toastr.success(res.message);
                    table.ajax.reload();
                },
                error: function(xhr) {
                    toastr.error('Failed to delete sale.');
                }
            });
        }
    });

    // Add View Details Modal
    $('body').append(`
    <div class="modal fade" id="viewSaleModal" tabindex="-1" role="dialog" aria-labelledby="viewSaleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="viewSaleModalLabel">Sale Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="saleDetailsBody">
            <!-- Sale details will be loaded here -->
          </div>
        </div>
      </div>
    </div>
    `);

    // View Sale Details
    $('#saleTable').on('click', '.viewBtn', function() {
        var id = $(this).data('id');
        $.get('sale_item/' + id, function(data) {
            var html = `<div class='row mb-2'>
                <div class='col-md-6'><strong>Client Name:</strong> ${data.client_name}<br>
                <strong>Mobile No:</strong> ${data.mobile_no}<br>
                <strong>Address:</strong> ${data.address}<br></div>
                <div class='col-md-6 text-right'><strong>Date:</strong> ${data.date}<br>
                <strong>Invoice No:</strong> ${data.id}<br></div>
            </div>
            <table class='table table-bordered'><thead><tr><th>#</th><th>Item Name</th><th>Price</th><th>Quantity</th><th>Amount</th></tr></thead><tbody>`;
            data.items.forEach(function(item, i) {
                html += `<tr><td>${i+1}</td><td>${item.item_name}</td><td>${item.price}</td><td>${item.quantity}</td><td>${item.amount}</td></tr>`;
            });
            html += `</tbody></table>
            <div class='row mt-3'><div class='col-md-6'><strong>Remark:</strong> ${data.remark || ''}</div>
            <div class='col-md-6 text-right'><strong>Total Amount:</strong> ${data.total_amount}<br><strong>Total Discount:</strong> ${data.total_discount}<br><strong>Grand Total:</strong> ${data.grand_total}</div></div>`;
            $('#saleDetailsBody').html(html);
            $('#viewSaleModal').modal('show');
        });
    });
});
</script>
@endpush 