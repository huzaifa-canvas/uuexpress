@extends('layouts.public')
@section('title', 'Order Confirmed | United Universe Express LLC')

@section('content')
<section class="thankyou section-pad">
    <div class="container">
        <div class="thankyou__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 6 9 17l-5-5"/>
            </svg>
        </div>
        <div class="eyebrow">Order Received</div>
        <h1 class="cta-heading">Thank You For Your Order</h1>
        <p class="text-muted">Your order <strong>{{ $order->order_number }}</strong> has been placed and paid. A confirmation has been emailed to {{ $order->email }}.</p>

        <div class="order-box">
            <div class="order-box__head">
                <div><span class="text-muted">Order</span><br><strong>{{ $order->order_number }}</strong></div>
                <div><span class="text-muted">Date</span><br><strong>{{ $order->created_at->format('M j, Y') }}</strong></div>
                <div><span class="text-muted">Total</span><br><strong>${{ number_format($order->total, 2) }}</strong></div>
                <div><span class="text-muted">Payment</span><br><strong class="text-success">Paid</strong></div>
            </div>
            <table class="order-items">
                <thead><tr><th>Item</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead>
                <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->line_total, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot><tr><td colspan="3" style="text-align:right;font-weight:700;">Total</td><td style="font-weight:700;">${{ number_format($order->total, 2) }}</td></tr></tfoot>
            </table>
        </div>

        <div class="thankyou__actions">
            <a href="{{ route('home') }}" class="btn btn-outline">Back To Home</a>
            <a href="{{ route('shop') }}" class="btn">Continue Shopping</a>
        </div>
    </div>
</section>

@push('scripts')
<style>
    .order-box { max-width:640px; margin:2rem auto; border:1px solid #eee; border-radius:14px; text-align:left; overflow:hidden; }
    .order-box__head { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; padding:1.25rem 1.5rem; background:#fafafa; font-size:.9rem; }
    .order-items { width:100%; border-collapse:collapse; }
    .order-items th, .order-items td { padding:.7rem 1.5rem; text-align:left; border-top:1px solid #f0f0f0; font-size:.92rem; }
    .order-items th { font-size:.72rem; text-transform:uppercase; letter-spacing:.04em; color:#888; }
    @media (max-width:560px){ .order-box__head { grid-template-columns:repeat(2,1fr); } }
</style>
@endpush
@endsection
