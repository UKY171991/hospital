@extends('layouts.app')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Day Book Report</h1>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body">
            <form id="dayBookFilterForm" class="form-row align-items-end">
                <div class="form-group col-md-3">
                    <label>Report Type<span class="text-danger">*</span></label>
                    <select class="form-control" name="report_type" required>
                        <option value="Today-Report">Today-Report</option>
                        <option value="Month-Wise">Month-Wise</option>
                        <option value="Date-Range-Wise">Date-Range-Wise</option>
                        <option value="All-Report">All-Report</option>
                    </select>
                </div>
                <div class="form-group col-md-2 ml-auto">
                    <button type="submit" class="btn btn-success btn-block"><i class="fas fa-search"></i> Search Report</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dayBookTable">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>Sr No</th>
                            <th>Name Of Particular</th>
                            <th>Credit</th>
                            <th>Debit</th>
                            <th>Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit -->
<div class="modal fade" id="dayBookModal" tabindex="-1" role="dialog" aria-labelledby="dayBookModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dayBookModalLabel">Add/Edit Day Book Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form will be loaded here by AJAX -->
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    // DataTable
    var table = $('#dayBookTable').DataTable({
        processing: true,
        serverSide: false,
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print', 'colvis'
        ],
        ajax: {
            url: '/day-book',
            dataSrc: 'data'
        },
        columns: [
            { data: 'sno' },
            { data: 'name_of_particular' },
            { data: 'credit' },
            { data: 'debit' },
            { data: 'balance' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Toastr status
    function showStatus(type, message) {
        toastr.clear();
        if(type === 'success') toastr.success(message);
        else if(type === 'info') toastr.info(message);
        else toastr.error(message);
    }

    // Open modal for add
    $(document).on('click', '#addDayBookBtn', function() {
        $('#dayBookModalLabel').text('Add Day Book Entry');
        $('#dayBookModal .modal-body').html(`
            <form id="dayBookForm">
                @csrf
                <input type="hidden" name="id" id="day_book_id">
                <div class="form-group">
                    <label>Name Of Particular</label>
                    <input type="text" class="form-control" name="name_of_particular" id="name_of_particular" required>
                </div>
                <div class="form-group">
                    <label>Credit</label>
                    <input type="number" step="0.01" class="form-control" name="credit" id="credit">
                </div>
                <div class="form-group">
                    <label>Debit</label>
                    <input type="number" step="0.01" class="form-control" name="debit" id="debit">
                </div>
                <div class="form-group">
                    <label>Balance</label>
                    <input type="number" step="0.01" class="form-control" name="balance" id="balance">
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        `);
        $('#dayBookModal').modal('show');
    });

    // Open modal for edit
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('/day-book/' + id, function(data) {
            $('#dayBookModalLabel').text('Edit Day Book Entry');
            $('#dayBookModal .modal-body').html(`
                <form id="dayBookForm">
                    @csrf
                    <input type="hidden" name="id" id="day_book_id" value="${data.id}">
                    <div class="form-group">
                        <label>Name Of Particular</label>
                        <input type="text" class="form-control" name="name_of_particular" id="name_of_particular" value="${data.name_of_particular}" required>
                    </div>
                    <div class="form-group">
                        <label>Credit</label>
                        <input type="number" step="0.01" class="form-control" name="credit" id="credit" value="${data.credit}">
                    </div>
                    <div class="form-group">
                        <label>Debit</label>
                        <input type="number" step="0.01" class="form-control" name="debit" id="debit" value="${data.debit}">
                    </div>
                    <div class="form-group">
                        <label>Balance</label>
                        <input type="number" step="0.01" class="form-control" name="balance" id="balance" value="${data.balance}">
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            `);
            $('#dayBookModal').modal('show');
        });
    });

    // Save (add or update)
    $(document).on('submit', '#dayBookForm', function(e) {
        e.preventDefault();
        var id = $('#day_book_id').val();
        var url = id ? '/day-book/' + id : '/day-book';
        var type = id ? 'PUT' : 'POST';
        var formData = $(this).serialize();
        if (id) formData += '&_method=PUT';
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(res) {
                $('#dayBookModal').modal('hide');
                table.ajax.reload();
                showStatus('success', res.message);
            },
            error: function(xhr) {
                showStatus('danger', 'Failed to save day book entry.');
            }
        });
    });

    // Delete
    $(document).on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this entry?')) {
            $.ajax({
                url: '/day-book/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    table.ajax.reload();
                    showStatus('success', res.message);
                },
                error: function() {
                    showStatus('danger', 'Failed to delete day book entry.');
                }
            });
        }
    });

    // Filter/search form
    $('#dayBookFilterForm').submit(function(e) {
        e.preventDefault();
        table.ajax.reload();
    });
});
</script>
@endpush 