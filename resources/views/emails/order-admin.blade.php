<h2>New Order: {{ $order->order_number }}</h2>
<p><strong>Placed:</strong> {{ $order->created_at->format('M j, Y g:i A') }}</p>

<h3>Customer</h3>
<p>
    <strong>Name:</strong> {{ $order->customer_name }}<br>
    <strong>Email:</strong> {{ $order->email }}<br>
    <strong>Phone:</strong> {!! $order->phone ? e($order->phone) : '&mdash;' !!}<br>
    <strong>Account:</strong> {{ $order->user_id ? 'Registered user' : 'Guest checkout' }}
</p>

<h3>Shipping</h3>
<p>
    {{ $order->address }}<br>
    {{ trim($order->city . ' ' . $order->postcode) }}
</p>
@if($order->notes)
<p><strong>Notes:</strong><br>{!! nl2br(e($order->notes)) !!}</p>
@endif

<h3>Order</h3>
@include('emails._order-items')

<p><strong>Payment:</strong> Paid (Stripe) &mdash; {{ $order->payment_intent_id }}</p>
