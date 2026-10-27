@extends('admin.layouts.app')
@section('title', 'Contact Us')

@section('content')
<form method="GET" class="row g-2 mb-3">
    <div class="col-sm-6">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name, email, subject…">
    </div>
    <div class="col-sm-auto">
        <button class="btn btn-brand"><i class="bi bi-search"></i> Search</button>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-light">Reset</a>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="text-muted small">
                <tr><th>Subject</th><th>From</th><th>Received</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
            @forelse($messages as $m)
                <tr class="{{ $m->read_at ? '' : 'fw-semibold' }}">
                    <td><a href="{{ route('admin.messages.show', $m) }}" class="text-decoration-none">{{ $m->subject }}</a></td>
                    <td class="small">{{ $m->full_name }}<div class="text-muted fw-normal">{{ $m->email }}</div></td>
                    <td class="small text-muted">{{ $m->created_at->format('M j, Y') }}</td>
                    <td>
                        @if($m->read_at)
                            <span class="badge bg-light text-muted border">Read</span>
                        @else
                            <span class="badge bg-primary">New</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.messages.show', $m) }}" class="btn btn-sm btn-light"><i class="bi bi-eye"></i></a>
                        <form method="POST" action="{{ route('admin.messages.destroy', $m) }}" class="d-inline" onsubmit="return confirm('Delete this message?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No messages found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $messages->links() }}</div>
@endsection
