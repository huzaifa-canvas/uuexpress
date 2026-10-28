<h2>Thank you for your order!</h2>
<p>Hi {{ $order->customer_name }}, we&rsquo;ve received your order and it&rsquo;s being processed. Here are the details:</p>

<p><strong>Order number:</strong> {{ $order->order_number }}<br>
<strong>Date:</strong> {{ $order->created_at->format('M j, Y') }}</p>

@include('emails._order-items')

<h3>Shipping to</h3>
<p>
    {{ $order->customer_name }}<br>
    {{ $order->address }}<br>
    {{ trim($order->city . ' ' . $order->postcode) }}
</p>

<p>We&rsquo;ll be in touch soon. If you have any questions, just reply to this email.</p>
<p>&mdash; United Universe Express LLC</p>
