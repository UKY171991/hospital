@extends('layouts.app')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-comments mr-2"></i>Complaint Management</h1>
            <p class="text-muted">Manage hospital complaints and feedback</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Complaints</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Form Section -->
        <div class="col-lg-4 col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus mr-2"></i>Create Complaint
                    </h5>
                </div>
                <div class="card-body">
                    <form id="complaintForm">
                        <input type="hidden" id="complaint_id" name="complaint_id">
                        <div class="form-group">
                            <label for="name"><i class="fas fa-tag mr-1"></i>Complaint Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   placeholder="Enter complaint title" required>
                        </div>
                        <div class="form-group">
                            <label for="description"><i class="fas fa-align-left mr-1"></i>Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" 
                                      placeholder="Describe the complaint in detail..."></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save mr-1"></i>Save Complaint
                            </button>
                            <button type="button" class="btn btn-secondary ml-2" id="resetBtn">
                                <i class="fas fa-undo mr-1"></i>Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="col-lg-8 col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list mr-2"></i>Manage Complaints
                    </h5>
                    <button class="btn btn-light btn-sm" id="addNewBtn">
                        <i class="fas fa-plus mr-1"></i>New Complaint
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="complaintTable" class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>S No</th>
                                    <th><i class="fas fa-tag mr-1"></i>Complaint Name</th>
                                    <th><i class="fas fa-align-left mr-1"></i>Description</th>
                                    <th><i class="fas fa-toggle-on mr-1"></i>Status</th>
                                    <th><i class="fas fa-cogs mr-1"></i>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    let table = $('#complaintTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ url('complaint') }}',
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'name' },
            { data: 'description' },
            { data: 'status', render: function(data, type, row) {
                return `<button class="btn btn-link toggle-status" data-id="${row.id}">${data ? '<i class="fa fa-eye text-success"></i>' : '<i class="fa fa-eye-slash text-danger"></i>'}</button>`;
            }},
            { data: null, render: function(data, type, row) {
                return `<button class="btn btn-info btn-sm editBtn" data-id="${row.id}" data-name="${row.name}" data-description="${row.description}"><i class="fa fa-edit"></i></button>`;
            }}
        ],
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print', 'colvis'
        ]
    });

    // Reset form
    $('#addNewBtn').click(function() {
        $('#complaintForm')[0].reset();
        $('#complaint_id').val('');
    });

    // Save or update
    $('#complaintForm').submit(function(e) {
        e.preventDefault();
        let id = $('#complaint_id').val();
        let url = id ? `{{ url('complaint/update') }}/${id}` : `{{ url('complaint/store') }}`;
        let method = 'POST';
        let formData = $(this).serializeArray();
        formData.push({ name: '_token', value: $('meta[name="csrf-token"]').attr('content') });
        $.ajax({
            url: url,
            method: method,
            data: $.param(formData),
            success: function(res) {
                toastr.success('Saved successfully');
                table.ajax.reload();
                $('#complaintForm')[0].reset();
                $('#complaint_id').val('');
            },
            error: function(xhr) {
                toastr.error('Error occurred');
            }
        });
    });

    // Edit
    $('#complaintTable').on('click', '.editBtn', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let description = $(this).data('description');
        $('#complaint_id').val(id);
        $('#name').val(name);
        $('#description').val(description);
    });

    // Toggle status
    $('#complaintTable').on('click', '.toggle-status', function() {
        let id = $(this).data('id');
        $.post(`{{ url('complaint/toggle-status') }}/${id}`, {_token: '{{ csrf_token() }}'}, function(res) {
            toastr.success('Status updated');
            table.ajax.reload();
        });
    });
});
</script>
@endpush 