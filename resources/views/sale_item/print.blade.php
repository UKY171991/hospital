<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale Receipt #{{ $sale->id }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none; }
        }
        .receipt-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .table th, .table td { vertical-align: middle !important; }
    </style>
</head>
<body>
<div class="receipt-box">
    <div class="row mb-4">
        <div class="col-8">
            <h2>Sale Receipt</h2>
        </div>
        <div class="col-4 text-right no-print">
            <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-6">
            <strong>Client Name:</strong> {{ $sale->client_name }}<br>
            <strong>Mobile No:</strong> {{ $sale->mobile_no }}<br>
            <strong>Address:</strong> {{ $sale->address }}<br>
        </div>
        <div class="col-md-6 text-right">
            <strong>Date:</strong> {{ $sale->date }}<br>
            <strong>Invoice No:</strong> {{ $sale->id }}<br>
        </div>
    </div>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
        @foreach($sale->items as $i => $item)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $item['item_name'] }}</td>
                <td>{{ $item['price'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ $item['amount'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="row mt-4">
        <div class="col-md-6">
            <strong>Remark:</strong> {{ $sale->remark }}
        </div>
        <div class="col-md-6 text-right">
            <strong>Total Amount:</strong> {{ $sale->total_amount }}<br>
            <strong>Total Discount:</strong> {{ $sale->total_discount }}<br>
            <strong>Grand Total:</strong> {{ $sale->grand_total }}<br>
        </div>
    </div>
</div>
<!-- FontAwesome for print icon -->
<script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/js/all.min.js"></script>
</body>
</html> 