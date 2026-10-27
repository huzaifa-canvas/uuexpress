@extends('admin.layouts.app')
@section('title', 'Booking Details')

@section('content')
<a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-light mb-3"><i class="bi bi-arrow-left"></i> Back to bookings</a>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-4">
            <h2 class="h5 fw-bold mb-1">{{ $booking->name }}</h2>
            <p class="text-muted mb-4">Requested {{ $booking->created_at->format('M j, Y \a\t g:i A') }}</p>
            <dl class="row mb-0">
                <dt class="col-sm-4 text-muted">Service</dt><dd class="col-sm-8">{{ $booking->service_type ?: '—' }}</dd>
                <dt class="col-sm-4 text-muted">Amount</dt><dd class="col-sm-8">{{ $booking->amount ? '$'.number_format($booking->amount, 2) : '—' }}</dd>
                <dt class="col-sm-4 text-muted">Payment</dt><dd class="col-sm-8">
                    @if($booking->payment_status === 'paid')
                        <span class="badge bg-success">Paid</span>
                        @if($booking->payment_intent_id)<div class="small text-muted mt-1">{{ $booking->payment_intent_id }}</div>@endif
                    @else
                        <span class="badge bg-secondary">Unpaid</span>
                    @endif
                </dd>
                <dt class="col-sm-4 text-muted">Email</dt><dd class="col-sm-8"><a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a></dd>
                <dt class="col-sm-4 text-muted">Phone</dt><dd class="col-sm-8">{{ $booking->phone ?: '—' }}</dd>
                <dt class="col-sm-4 text-muted">Pickup Address</dt><dd class="col-sm-8">{{ $booking->pickup_address ?: '—' }}</dd>
                <dt class="col-sm-4 text-muted">Drop-off Address</dt><dd class="col-sm-8">{{ $booking->dropoff_address ?: '—' }}</dd>
                <dt class="col-sm-4 text-muted">Pickup Date</dt><dd class="col-sm-8">{{ optional($booking->pickup_date)->format('M j, Y') ?: '—' }}</dd>
                <dt class="col-sm-4 text-muted">Pickup Time</dt><dd class="col-sm-8">{{ $booking->pickup_time ?: '—' }}</dd>
                <dt class="col-sm-4 text-muted">Notes</dt><dd class="col-sm-8">{{ $booking->notes ?: '—' }}</dd>
            </dl>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card p-4 mb-3">
            <h2 class="h6 fw-bold mb-3">Status</h2>
            <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
                @csrf @method('PATCH')
                <select name="status" class="form-select mb-3">
                    @foreach(['new','confirmed','completed','cancelled'] as $st)
                        <option value="{{ $st }}" @selected($booking->status===$st)>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-brand w-100">Update Status</button>
            </form>
        </div>
        <div class="card p-4">
            <a href="mailto:{{ $booking->email }}" class="btn btn-outline-secondary w-100 mb-2"><i class="bi bi-reply"></i> Reply by Email</a>
            <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" onsubmit="return confirm('Delete this booking?');">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger w-100"><i class="bi bi-trash"></i> Delete Booking</button>
            </form>
        </div>
    </div>
</div>
@endsection
