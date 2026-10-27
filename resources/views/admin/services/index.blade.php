@extends('admin.layouts.app')
@section('title', 'Services')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0">Manage the services shown on the public site.</p>
    <a href="{{ route('admin.services.create') }}" class="btn btn-brand btn-sm"><i class="bi bi-plus-lg"></i> Add Service</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="text-muted small">
                <tr><th style="width:64px;"></th><th>Name</th><th>Slug</th><th>Price</th><th>Order</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
            @forelse($services as $service)
                <tr>
                    <td><img src="{{ asset($service->image) }}" alt="" style="width:46px;height:46px;object-fit:cover;border-radius:8px;"></td>
                    <td class="fw-semibold">{{ $service->name }}</td>
                    <td class="small text-muted">{{ $service->slug }}</td>
                    <td class="fw-semibold">{{ $service->price > 0 ? '$'.number_format($service->price, 2) : 'Free' }}</td>
                    <td>{{ $service->sort_order }}</td>
                    <td>
                        @if($service->is_active)
                            <span class="badge bg-success-subtle text-success">Active</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Hidden</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="btn btn-sm btn-light" title="View"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="d-inline" onsubmit="return confirm('Delete this service?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light text-danger" title="Delete"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No services yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $services->links() }}</div>
@endsection
