@extends('layouts.admin')

@section('title', 'Manage Items')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="my-4">Item List</h2>
        <div>
            <a href="#" class="btn btn-success me-1">+ Add Sale</a> 
            <a href="#" class="btn btn-warning me-1">+ Add Purchase</a>
            {{-- Link to item create route --}}
            <a href="{{ route('items.create') }}" class="btn btn-primary">+ Add Item</a> 
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    {{-- Show 10 entries --}}
                    <select class="form-select form-select-sm d-inline-block" style="width: auto;">
                        <option selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    entries
                </div>
                <div>
                    {{-- Export buttons --}}
                    <button class="btn btn-outline-secondary btn-sm">Excel</button>
                    <button class="btn btn-outline-secondary btn-sm">PDF</button>
                    <button class="btn btn-outline-secondary btn-sm">Print</button>
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Column visibility
                    </button>
                    <ul class="dropdown-menu">
                        {{-- Add column names here --}}
                        <li><a class="dropdown-item" href="#">Item Name</a></li>
                        <li><a class="dropdown-item" href="#">Item Code</a></li>
                        {{-- ... more columns --}}
                    </ul>
                </div>
                <div>
                    Search: <input type="search" class="form-control form-control-sm d-inline-block" style="width: auto;">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Item Name</th>
                            <th>Item Code</th>
                            <th>Purchase Price</th>
                            <th>Sales Price</th>
                            <th>Unit</th>
                            <th>Opening Stock</th>
                            <th>Current Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->item_code ?? 'N/A' }}</td>
                                <td>{{ $item->purchase_price }}</td>
                                <td>{{ $item->sales_price }}</td>
                                <td>{{ $item->unit ?? 'N/A' }}</td>
                                <td>{{ $item->opening_stock }}</td>
                                <td>{{ $item->current_stock }}</td>
                                <td>
                                    {{-- Edit button --}}
                                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-info me-1"><i class="fa fa-edit"></i></a>
                                    {{-- Delete button (using a form for DELETE request) --}}
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                    </form>
                                    {{-- Placeholder for toggle if needed --}}
                                    {{-- <button class="btn btn-sm btn-secondary"><i class="fa fa-toggle-on"></i></button> --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination links if using paginate() in controller --}}
            {{-- $items->links() --}}
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- Add any page-specific JavaScript here --}}
{{-- For example, for DataTables library if you want advanced table features --}}
{{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script> --}}
{{-- <script>
    $(document).ready(function() {
        $('.table').DataTable();
    });
</script> --}}
@endsection

@section('head')
{{-- Add any page-specific CSS here --}}
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> --}}
@endsection
