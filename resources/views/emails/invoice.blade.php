<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .details { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Kemet Egypt Tourism</h1>
        <h2>Invoice #{{ $order->id }}</h2>
    </div>
    
    <div class="details">
        <p><strong>Customer Name:</strong> {{ optional($order->user)->name ?? 'Guest' }}</p>
        <p><strong>Email:</strong> {{ optional($order->user)->email ?? '' }}</p>
        <p><strong>Phone:</strong> {{ $order->phone }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d') }}</p>
        <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ optional($item->product)->name ?? 'Product' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }} EGP</td>
                <td>{{ number_format($item->price * $item->quantity, 2) }} EGP</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="text-align: right; margin-top: 20px;">Total: {{ number_format($order->total_amount, 2) }} EGP</h3>
</body>
</html>
