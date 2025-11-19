<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Invoice - {{ $order->user_order_id }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            line-height: 1.4;
        }
        .header-title {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 25px;
            border-bottom: 1px solid #000;
            padding-bottom: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        .totals {
            width: 40%;
            float: right;
            margin-top: 20px;
        }
        .totals td {
            border: none !important;
            padding: 5px 0;
        }
        .badge {
            padding: 4px 8px;
            font-size: 12px;
            color: #fff;
            border-radius: 4px;
        }
        .pending { background: orange; }
        .processing { background: #17a2b8; }
        .completed { background: green; }
        .cancelled { background: red; }
    </style>
</head>
<body>

    <p class="header-title">SOLE BAZAR ORDER INVOICE</p>

    <!-- Customer Info -->
    <p class="section-title">Customer Information</p>

    <table>
        <tr>
            <th>Name</th>
            <td>{{ $order->name }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $order->mobile }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $order->email }}</td>
        </tr>
        <tr>
            <th>District</th>
            <td>{{ $order->district }}</td>
        </tr>
        <tr>
            <th>Upazila</th>
            <td>{{ $order->upzilla }}</td>
        </tr>
        <tr>
            <th>Union</th>
            <td>{{ $order->union }}</td>
        </tr>
    </table>

    <!-- Order Info -->
    <p class="section-title">Order Information</p>

    <table>
        <tr>
            <th>Order ID</th>
            <td>#{{ $order->user_order_id }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ $order->created_at->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @if($order->status == 0)
                    <span class="badge pending">Pending</span>
                @elseif($order->status == 1)
                    <span class="badge processing">Processing</span>
                @elseif($order->status == 2)
                    <span class="badge completed">Completed</span>
                @else
                    <span class="badge cancelled">Cancelled</span>
                @endif
            </td>
        </tr>
    </table>

    <!-- Product List -->
    <p class="section-title">Ordered Products</p>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th width="80px">Qty</th>
                <th width="100px">Price</th>
                <th width="100px">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <table class="totals">
        <tr>
            <td><strong>Grand Total:</strong></td>
            <td><strong>{{ number_format($order->grand_total, 2) }} ৳</strong></td>
        </tr>
    </table>

</body>
</html>
