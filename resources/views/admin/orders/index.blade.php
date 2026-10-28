@extends('admin.layouts.app')
@section('title', 'Orders')

@section('content')
<form method="GET" class="row g-2 mb-3">
    <div class="col-sm-5">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search order #, name, email…">
    </div>
    <div class="col-sm-3">
        <select name="status" class="form-select">
            <option value="">All statuses</option>
            @foreach(['processing','completed','cancelled','refunded'] as $st)
                <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-auto">
        <button class="btn btn-brand"><i class="bi bi-search"></i> Filter</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-light">Reset</a>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="text-muted small">
                <tr><th>Order</th><th>Customer</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th class="text-end"></th></tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
                @php $badge = ['processing'=>'bg-primary','completed'=>'bg-success','cancelled'=>'bg-secondary','refunded'=>'bg-warning text-dark'][$order->status] ?? 'bg-secondary'; @endphp
                <tr>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="fw-semibold text-decoration-none">{{ $order->order_number }}</a></td>
                    <td>{{ $order->customer_name }}<div class="small text-muted">{{ $order->email }}</div></td>
                    <td>{{ $order->items_count }}</td>
                    <td class="fw-semibold">${{ number_format($order->total, 2) }}</td>
                    <td>@if($order->payment_status==='paid')<span class="badge bg-success">Paid</span>@else<span class="badge bg-secondary">Unpaid</span>@endif</td>
                    <td><span class="badge {{ $badge }}">{{ ucfirst($order->status) }}</span></td>
                    <td class="small text-muted">{{ $order->created_at->format('M j, Y') }}</td>
                    <td class="text-end"><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-light"><i class="bi bi-eye"></i></a></td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No orders yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $orders->links() }}</div>
@endsection
