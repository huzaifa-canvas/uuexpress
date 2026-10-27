@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    @php
        $tiles = [
            ['label' => 'Total Bookings', 'value' => $stats['bookings'], 'sub' => $stats['new_bookings'].' new', 'icon' => 'bi-calendar-check', 'bg' => '#e6f4ea', 'fg' => '#0f5132', 'route' => route('admin.bookings.index')],
            ['label' => 'Contact Us', 'value' => $stats['messages'], 'sub' => $stats['unread_messages'].' unread', 'icon' => 'bi-chat-left-text', 'bg' => '#e7f0fb', 'fg' => '#1b4f9b', 'route' => route('admin.messages.index')],
            ['label' => 'Services', 'value' => $stats['services'], 'sub' => 'manage', 'icon' => 'bi-grid-1x2', 'bg' => '#fdf0e6', 'fg' => '#9a5b2a', 'route' => route('admin.services.index')],
            ['label' => 'Products', 'value' => $stats['products'], 'sub' => 'catalog', 'icon' => 'bi-bag', 'bg' => '#f3e9fb', 'fg' => '#6b2a9a', 'route' => '#'],
        ];
    @endphp
    @foreach($tiles as $t)
    <div class="col-sm-6 col-xl-3">
        <a href="{{ $t['route'] }}" class="text-decoration-none">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-center gap-3">
                <span class="icon" style="background:{{ $t['bg'] }};color:{{ $t['fg'] }}"><i class="bi {{ $t['icon'] }}"></i></span>
                <div>
                    <div class="fs-4 fw-bold text-dark">{{ $t['value'] }}</div>
                    <div class="text-muted small">{{ $t['label'] }} · {{ $t['sub'] }}</div>
                </div>
            </div>
        </div>
        </a>
    </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h2 class="h6 mb-0 fw-bold">Recent Bookings</h2>
                <a href="{{ route('admin.bookings.index') }}" class="small">View all</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="text-muted small"><tr><th>Name</th><th>Service</th><th>Date</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($recentBookings as $b)
                        <tr>
                            <td><a href="{{ route('admin.bookings.show', $b) }}" class="text-decoration-none fw-semibold">{{ $b->name }}</a></td>
                            <td class="small">{{ $b->service_type ?: '—' }}</td>
                            <td class="small">{{ optional($b->pickup_date)->format('M j, Y') ?: '—' }}</td>
                            <td><span class="badge bg-light text-dark border">{{ ucfirst($b->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-muted text-center py-3">No bookings yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h2 class="h6 mb-0 fw-bold">Recent Contact Messages</h2>
                <a href="{{ route('admin.messages.index') }}" class="small">View all</a>
            </div>
            <ul class="list-unstyled mb-0">
                @forelse($recentMessages as $m)
                    <li class="py-2 border-bottom">
                        <a href="{{ route('admin.messages.show', $m) }}" class="text-decoration-none">
                            <div class="fw-semibold text-dark">{{ $m->subject }}</div>
                            <div class="small text-muted">{{ $m->full_name }} · {{ $m->created_at->diffForHumans() }}</div>
                        </a>
                    </li>
                @empty
                    <li class="text-muted text-center py-3">No messages yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
