<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Invoice #{{ $purchase->invoice_no }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none; }
        }
        .invoice-box {
            max-width: 900px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .table th, .table td { vertical-align: middle !important; }
        .header-title { font-size: 24px; font-weight: bold; }
    </style>
</head>
<body>
<div class="invoice-box">
    <div class="row mb-4">
        <div class="col-8">
            <span class="header-title">Purchase Invoice</span>
        </div>
        <div class="col-4 text-right no-print">
            <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-6">
            <strong>Supplier Name:</strong> {{ $purchase->supplier ? $purchase->supplier->name : '' }}<br>
            <strong>Contact No:</strong> {{ $purchase->supplier ? $purchase->supplier->contact_no : '' }}<br>
            <strong>Address:</strong> {{ $purchase->supplier ? $purchase->supplier->address : '' }}<br>
        </div>
        <div class="col-md-6 text-right">
            <strong>Purchase Date:</strong> {{ $purchase->date }}<br>
            <strong>Invoice No:</strong> {{ $purchase->invoice_no }}<br>
            <strong>Purchase Order No:</strong> {{ $purchase->purchase_order_no }}<br>
            <strong>Eway Bill No:</strong> {{ $purchase->eway_bill_no }}<br>
        </div>
    </div>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Item Unit</th>
                <th>Rate Per Unit</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
        @foreach($purchase->items as $i => $item)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $item['item_name'] }}</td>
                <td>{{ $item['unit'] ?? '' }}</td>
                <td>{{ $item['price'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ $item['amount'] }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total</th>
                <th>{{ $purchase->total_amount }}</th>
            </tr>
            <tr>
                <th colspan="5" class="text-right">Discount</th>
                <th>{{ $purchase->total_discount }}</th>
            </tr>
            <tr>
                <th colspan="5" class="text-right">Grand Total</th>
                <th>{{ $purchase->grand_total }}</th>
            </tr>
        </tfoot>
    </table>
    <div class="row mt-4">
        <div class="col-md-12">
            <strong>Remark:</strong> {{ $purchase->remark }}
        </div>
    </div>
</div>
<!-- FontAwesome for print icon -->
<script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/js/all.min.js"></script>
</body>
</html> 