@extends('admin.layouts.app')
@section('title', 'Order ' . $order->order_number)

@section('content')
<a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light mb-3"><i class="bi bi-arrow-left"></i> Back to orders</a>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h2 class="h5 fw-bold mb-1">{{ $order->order_number }}</h2>
                    <p class="text-muted mb-0">{{ $order->created_at->format('M j, Y \a\t g:i A') }}</p>
                </div>
                @if($order->payment_status==='paid')<span class="badge bg-success">Paid</span>@else<span class="badge bg-secondary">Unpaid</span>@endif
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="text-muted small"><tr><th>Item</th><th class="text-center">Qty</th><th class="text-end">Price</th><th class="text-end">Total</th></tr></thead>
                    <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td class="d-flex align-items-center gap-2">
                                @if($item->image)<img src="{{ asset($item->image) }}" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:6px;">@endif
                                {{ $item->name }}
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">${{ number_format($item->price, 2) }}</td>
                            <td class="text-end">${{ number_format($item->line_total, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr><td colspan="3" class="text-end fw-bold">Total</td><td class="text-end fw-bold">${{ number_format($order->total, 2) }}</td></tr>
                    </tfoot>
                </table>
            </div>
            @if($order->payment_intent_id)<p class="small text-muted mt-2 mb-0">Stripe: {{ $order->payment_intent_id }}</p>@endif
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card p-4 mb-3">
            <h2 class="h6 fw-bold mb-3">Customer</h2>
            <dl class="row mb-0 small">
                <dt class="col-4 text-muted">Name</dt><dd class="col-8">{{ $order->customer_name }}</dd>
                <dt class="col-4 text-muted">Email</dt><dd class="col-8"><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></dd>
                <dt class="col-4 text-muted">Phone</dt><dd class="col-8">{{ $order->phone ?: '—' }}</dd>
                <dt class="col-4 text-muted">Type</dt><dd class="col-8">{{ $order->user_id ? 'Registered' : 'Guest' }}</dd>
            </dl>
        </div>
        <div class="card p-4 mb-3">
            <h2 class="h6 fw-bold mb-3">Shipping</h2>
            <p class="small mb-0">{{ $order->address ?: '—' }}<br>{{ trim($order->city . ' ' . $order->postcode) }}</p>
            @if($order->notes)<p class="small text-muted mt-2 mb-0"><strong>Notes:</strong> {{ $order->notes }}</p>@endif
        </div>
        <div class="card p-4">
            <h2 class="h6 fw-bold mb-3">Status</h2>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                @csrf @method('PATCH')
                <select name="status" class="form-select mb-3">
                    @foreach(['processing','completed','cancelled','refunded'] as $st)
                        <option value="{{ $st }}" @selected($order->status===$st)>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-brand w-100">Update Status</button>
            </form>
        </div>
    </div>
</div>
@endsection
