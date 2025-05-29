@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Purchase List</h1>
        </div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-primary" id="addPurchaseBtn">+ New Purchase</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="purchaseTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Supplier Name</th>
                        <th>Purchase Date</th>
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
<div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-labelledby="purchaseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <form id="purchaseForm">
        <div class="modal-header">
          <h5 class="modal-title" id="purchaseModalLabel">Add/Update Purchase</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label>Invoice No *</label>
                <input type="text" name="invoice_no" class="form-control" required>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Date *</label>
                <input type="date" name="date" class="form-control" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Supplier Name *</label>
                <select name="supplier_id" class="form-control" required>
                  <option value="">Select Supplier</option>
                  @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Purchase Order No</label>
                <input type="text" name="purchase_order_no" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Eway Bill No</label>
                <input type="text" name="eway_bill_no" class="form-control">
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
                  <label>Item Unit</label>
                  <input type="text" name="unit[]" class="form-control">
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
              <div class="col-md-1 d-flex align-items-end">
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
    var table = $('#purchaseTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('purchase_item') }}',
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', className: 'btn btn-success btn-sm' },
            { extend: 'pdf', className: 'btn btn-danger btn-sm' },
            { extend: 'print', className: 'btn btn-info btn-sm' },
            { extend: 'colvis', className: 'btn btn-secondary btn-sm', text: 'Column visibility' }
        ],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'supplier_id', name: 'supplier_id' },
            { data: 'date', name: 'date' },
            { data: 'invoice_no', name: 'invoice_no' },
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

    // Add Purchase
    $('#addPurchaseBtn').click(function() {
        $('#purchaseForm')[0].reset();
        $('#purchaseModalLabel').text('Add Purchase');
        $('#purchaseModal').modal('show');
        $('#purchaseForm').attr('data-id', '');
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
                    <label>Item Unit</label>
                    <input type="text" name="unit[]" class="form-control">
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
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger removeItemBtn"><i class="fas fa-trash"></i></button>
            </div>
        </div>`;
    }

    // Save Purchase (Add/Edit)
    $('#purchaseForm').submit(function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var method = id ? 'POST' : 'POST';
        var url = id ? 'purchase_item/' + id : 'purchase_item';
        if(id) var _method = 'PUT';
        var items = [];
        $('#itemsSection .item-row').each(function() {
            items.push({
                item_name: $(this).find('input[name="item_name[]"]').val(),
                unit: $(this).find('input[name="unit[]"]').val(),
                price: $(this).find('input[name="price[]"]').val(),
                quantity: $(this).find('input[name="quantity[]"]').val(),
                amount: $(this).find('input[name="amount[]"]').val(),
            });
        });
        var formData = {
            invoice_no: $('input[name="invoice_no"]').val(),
            date: $('input[name="date"]').val(),
            supplier_id: $('select[name="supplier_id"]').val(),
            purchase_order_no: $('input[name="purchase_order_no"]').val(),
            eway_bill_no: $('input[name="eway_bill_no"]').val(),
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
                $('#purchaseModal').modal('hide');
                table.ajax.reload();
                toastr.success(res.message);
            },
            error: function(xhr) {
                var err = xhr.responseJSON;
                toastr.error(err.message || 'Validation error!');
            }
        });
    });

    // Edit Purchase
    $('#purchaseTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('purchase_item/' + id, function(data) {
            $('#purchaseForm')[0].reset();
            $('#purchaseModalLabel').text('Update Purchase');
            $('#purchaseForm').attr('data-id', id);
            $('input[name="invoice_no"]').val(data.invoice_no);
            $('input[name="date"]').val(data.date);
            $('select[name="supplier_id"]').val(data.supplier_id);
            $('input[name="purchase_order_no"]').val(data.purchase_order_no);
            $('input[name="eway_bill_no"]').val(data.eway_bill_no);
            $('input[name="total_amount"]').val(data.total_amount);
            $('input[name="total_discount"]').val(data.total_discount);
            $('input[name="grand_total"]').val(data.grand_total);
            $('input[name="remark"]').val(data.remark);
            $('#itemsSection').html('');
            data.items.forEach(function(item, idx) {
                var row = $(getItemRowHtml());
                row.find('input[name="item_name[]"]').val(item.item_name);
                row.find('input[name="unit[]"]').val(item.unit);
                row.find('input[name="price[]"]').val(item.price);
                row.find('input[name="quantity[]"]').val(item.quantity);
                row.find('input[name="amount[]"]').val(item.amount);
                $('#itemsSection').append(row);
            });
            $('#purchaseModal').modal('show');
        });
    });

    // Delete Purchase
    $('#purchaseTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this purchase?')) {
            $.ajax({
                url: 'purchase_item/' + id,
                type: 'POST',
                data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                success: function(res) {
                    toastr.success(res.message);
                    table.ajax.reload();
                },
                error: function(xhr) {
                    toastr.error('Failed to delete purchase.');
                }
            });
        }
    });
});
</script>
@endpush 