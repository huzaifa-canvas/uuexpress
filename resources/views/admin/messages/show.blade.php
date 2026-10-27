@extends('admin.layouts.app')
@section('title', 'Contact Message')

@section('content')
<a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-light mb-3"><i class="bi bi-arrow-left"></i> Back to Contact Us</a>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-4">
            <h2 class="h5 fw-bold mb-1">{{ $message->subject }}</h2>
            <p class="text-muted mb-4">From {{ $message->full_name }} · {{ $message->created_at->format('M j, Y \a\t g:i A') }}</p>
            <div class="border rounded p-3 bg-light" style="white-space:pre-wrap;">{{ $message->message }}</div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card p-4 mb-3">
            <h2 class="h6 fw-bold mb-3">Sender</h2>
            <dl class="row mb-0 small">
                <dt class="col-4 text-muted">Name</dt><dd class="col-8">{{ $message->full_name }}</dd>
                <dt class="col-4 text-muted">Email</dt><dd class="col-8"><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></dd>
                <dt class="col-4 text-muted">Phone</dt><dd class="col-8">{{ $message->phone ?: '—' }}</dd>
            </dl>
        </div>
        <div class="card p-4">
            <a href="mailto:{{ $message->email }}?subject=RE: {{ $message->subject }}" class="btn btn-outline-secondary w-100 mb-2"><i class="bi bi-reply"></i> Reply by Email</a>
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?');">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger w-100"><i class="bi bi-trash"></i> Delete Message</button>
            </form>
        </div>
    </div>
</div>
@endsection
