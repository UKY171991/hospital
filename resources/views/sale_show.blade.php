@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sale Details</h1>
        <a href="{{ route('sale.manage') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Sales List</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Sale #{{ $sale->id }}</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</p>
                    <p><strong>Client Name:</strong> {{ $sale->client_name }}</p>
                    <p><strong>Mobile No:</strong> {{ $sale->mobile_no ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Sold By:</strong> {{ $sale->user->name ?? 'N/A' }}</p>
                    <p><strong>Hospital:</strong> {{ $sale->hospital->name ?? 'N/A' }}</p>
                    <p><strong>Remark:</strong> {{ $sale->remark ?? 'N/A' }}</p>
                </div>
            </div>

            <h5 class="mt-4 mb-3">Items Sold</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Item Code</th>
                            <th>Price at Sale</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sale->items as $index => $saleItem)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $saleItem->item->item_name }}</td>
                                <td>{{ $saleItem->item->item_code }}</td>
                                <td>{{ number_format($saleItem->price_at_sale, 2) }}</td>
                                <td>{{ $saleItem->quantity }}</td>
                                <td>{{ number_format($saleItem->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No items found for this sale.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <hr class="my-4">

            <div class="row justify-content-end">
                <div class="col-md-4">
                    <p class="lead">Summary</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width:50%">Total Amount:</th>
                                    <td>{{ number_format($sale->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Discount:</th>
                                    <td>{{ number_format($sale->total_discount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Grand Total:</th>
                                    <td><strong>{{ number_format($sale->grand_total, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button onclick="window.print();" class="btn btn-primary"><i class="fas fa-print"></i> Print Invoice</button>
                {{-- Add other actions like Edit or Cancel if needed --}}
            </div>
        </div>
    </div>
</div>
@endsection
