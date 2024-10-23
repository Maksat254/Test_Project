<head>
    <title>Order Created</title>
</head>
<body>
<h1>Order #{{ $order->id }} Created</h1>
<p>Dear {{ $order->customer_name }},</p>
<p>Your order has been successfully created.</p>
<p>Order Details:</p>
<ul>
    <li>Order ID: {{ $order->id }}</li>
    <li>Total Amount: {{ $order->total_amount }}</li>
    <li>Status: {{ $order->status }}</li>
</ul>
<p>Thank you for your order!</p>
</body>
