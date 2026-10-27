@extends('admin.layouts.app')
@section('title', 'Bookings')

@section('content')
<form method="GET" class="row g-2 mb-3">
    <div class="col-sm-5">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name, email, service…">
    </div>
    <div class="col-sm-3">
        <select name="status" class="form-select">
            <option value="">All statuses</option>
            @foreach(['new','confirmed','completed','cancelled'] as $st)
                <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-auto">
        <button class="btn btn-brand"><i class="bi bi-search"></i> Filter</button>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-light">Reset</a>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="text-muted small">
                <tr><th>Name</th><th>Service</th><th>Pickup</th><th>Date / Time</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
            @forelse($bookings as $b)
                @php $badge = ['new'=>'bg-primary','confirmed'=>'bg-info','completed'=>'bg-success','cancelled'=>'bg-secondary'][$b->status] ?? 'bg-secondary'; @endphp
                <tr>
                    <td>
                        <a href="{{ route('admin.bookings.show', $b) }}" class="fw-semibold text-decoration-none">{{ $b->name }}</a>
                        <div class="small text-muted">{{ $b->email }}</div>
                    </td>
                    <td class="small">{{ $b->service_type ?: '—' }}</td>
                    <td class="small text-muted">{{ \Illuminate\Support\Str::limit($b->pickup_address, 28) ?: '—' }}</td>
                    <td class="small">{{ optional($b->pickup_date)->format('M j, Y') ?: '—' }}<br><span class="text-muted">{{ $b->pickup_time }}</span></td>
                    <td><span class="badge {{ $badge }}">{{ ucfirst($b->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.bookings.show', $b) }}" class="btn btn-sm btn-light"><i class="bi bi-eye"></i></a>
                        <form method="POST" action="{{ route('admin.bookings.destroy', $b) }}" class="d-inline" onsubmit="return confirm('Delete this booking?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No bookings found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $bookings->links() }}</div>
@endsection
