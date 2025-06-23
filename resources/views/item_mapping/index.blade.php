@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-sitemap mr-2"></i>Item Mapping</h1>
            <p class="text-muted">Map items to departments and categories</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Item Mapping</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12 text-right">
            <button class="btn btn-primary" id="addItemMappingBtn">+ Add Item Mapping</button>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <form id="filterForm" class="form-row align-items-end">
                <div class="form-group col-md-3">
                    <label>Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">--All Type--</option>
                        <option value="OPD Wise">OPD Wise</option>
                        <option value="IPD Wise">IPD Wise</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group col-md-3">
                    <label>To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-success mt-4"><i class="fas fa-search"></i> Search Report</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="itemMappingTable" style="width:100%">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>Action</th>
                        <th>S.No</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Patient Name</th>
                        <th>Patient Contact no</th>
                        <th>Item Name</th>
                        <th>Item Code</th>
                        <th>Sale Price</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Item Mapping Modal -->
<div class="modal fade" id="itemMappingModal" tabindex="-1" role="dialog" aria-labelledby="itemMappingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="itemMappingModalLabel">Add/Update Item Mapping</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="itemMappingForm">
        @csrf
        <input type="hidden" name="id" id="item_mapping_id">
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label>Type <span class="text-danger">*</span></label>
              <select name="type" id="modal_type" class="form-control" required>
                <option value="OPD Wise">OPD Wise</option>
                <option value="IPD Wise">IPD Wise</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Date <span class="text-danger">*</span></label>
              <input type="date" name="date" id="date" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
            <div class="form-group col-md-3">
              <label>Patient Name <span class="text-danger">*</span></label>
              <input type="text" name="patient_name" id="patient_name" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Patient Contact no <span class="text-danger">*</span></label>
              <input type="text" name="patient_contact_no" id="patient_contact_no" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Item Name <span class="text-danger">*</span></label>
              <input type="text" name="item_name" id="item_name" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Item Code <span class="text-danger">*</span></label>
              <input type="text" name="item_code" id="item_code" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Sale Price <span class="text-danger">*</span></label>
              <input type="number" name="sale_price" id="sale_price" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Quantity <span class="text-danger">*</span></label>
              <input type="number" name="quantity" id="quantity" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Amount <span class="text-danger">*</span></label>
              <input type="number" name="amount" id="amount" class="form-control" required>
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
<script>
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('#itemMappingTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/item_mapping',
            data: function(d) {
                d.type = $('#type').val();
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },
        columns: [
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'type', name: 'type' },
            { data: 'date', name: 'date' },
            { data: 'patient_name', name: 'patient_name' },
            { data: 'patient_contact_no', name: 'patient_contact_no' },
            { data: 'item_name', name: 'item_name' },
            { data: 'item_code', name: 'item_code' },
            { data: 'sale_price', name: 'sale_price' },
            { data: 'quantity', name: 'quantity' },
            { data: 'amount', name: 'amount' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
        ],
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print', 'colvis']
    });
    $('#filterForm').submit(function(e) {
        e.preventDefault();
        table.ajax.reload();
    });
    $('#addItemMappingBtn').click(function() {
        $('#itemMappingForm')[0].reset();
        $('#item_mapping_id').val('');
        $('#itemMappingModal').modal('show');
    });
    // Submit form (add/update)
    $('#itemMappingForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $('#item_mapping_id').val();
        var url = id ? '/item_mapping/' + id : '/item_mapping';
        var type = id ? 'POST' : 'POST';
        if (id) formData += '&_method=PUT';
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function(res) {
                $('#itemMappingModal').modal('hide');
                table.ajax.reload();
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Validation error.');
            }
        });
    });
    // Edit button
    $('#itemMappingTable').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/item_mapping/' + id, function(data) {
            $('#item_mapping_id').val(data.id);
            $('#modal_type').val(data.type);
            $('#date').val(data.date);
            $('#patient_name').val(data.patient_name);
            $('#patient_contact_no').val(data.patient_contact_no);
            $('#item_name').val(data.item_name);
            $('#item_code').val(data.item_code);
            $('#sale_price').val(data.sale_price);
            $('#quantity').val(data.quantity);
            $('#amount').val(data.amount);
            $('#itemMappingModal').modal('show');
        });
    });
});
</script>
@endpush 