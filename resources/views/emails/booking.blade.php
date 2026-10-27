<h2>New Booking Request</h2>
<p><strong>Service:</strong> {{ $booking->service_type }}</p>
<p>
    <strong>Name:</strong> {{ $booking->name }}<br>
    <strong>Email:</strong> {{ $booking->email }}<br>
    <strong>Phone:</strong> {!! $booking->phone ? e($booking->phone) : '&mdash;' !!}
</p>
<p>
    <strong>Pickup Address:</strong> {{ $booking->pickup_address }}<br>
    <strong>Drop-off Address:</strong> {{ $booking->dropoff_address }}
</p>
<p>
    <strong>Pickup Date:</strong> {{ optional($booking->pickup_date)->format('Y-m-d') }}<br>
    <strong>Pickup Time:</strong> {{ $booking->pickup_time }}
</p>
@if($booking->notes)
<p><strong>Notes:</strong><br>{!! nl2br(e($booking->notes)) !!}</p>
@endif
