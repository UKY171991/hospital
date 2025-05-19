@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Sales</h1>
        <a href="{{ route('sale.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add New Sale</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Sales List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Mobile No</th>
                            <th>Grand Total</th>
                            <th>Sold By</th>
                            <th>Hospital</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($sale->date)->format('d-m-Y') }}</td>
                                <td>{{ $sale->client_name }}</td>
                                <td>{{ $sale->mobile_no ?? 'N/A' }}</td>
                                <td>{{ number_format($sale->grand_total, 2) }}</td>
                                <td>{{ $sale->user->name ?? 'N/A' }}</td>
                                <td>{{ $sale->hospital->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm disabled" title="View Details"><i class="fas fa-eye"></i></a>
                                    {{-- <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning btn-sm disabled" title="Edit"><i class="fas fa-edit"></i></a> --}}
                                    {{-- <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm disabled" title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                                    </form> --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No sales found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
