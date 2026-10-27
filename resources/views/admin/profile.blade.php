@extends('admin.layouts.app')
@section('title', 'My Profile')

@section('content')
@php $user = auth()->user(); @endphp

@if (session('status') === 'profile-information-updated')
    <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle"></i> Profile updated.<button class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if (session('status') === 'password-updated')
    <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle"></i> Password changed.<button class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card p-4">
            <h2 class="h6 fw-bold mb-3">Profile Information</h2>
            <form method="POST" action="{{ route('user-profile-information.update') }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name', 'updateProfileInformation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email', 'updateProfileInformation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-0">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>
                <button class="btn btn-brand mt-3"><i class="bi bi-check-lg"></i> Save Profile</button>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card p-4">
            <h2 class="h6 fw-bold mb-3">Update Password</h2>
            <form method="POST" action="{{ route('user-password.update') }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
                    @error('current_password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                    @error('password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-0">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <button class="btn btn-brand mt-3"><i class="bi bi-shield-lock"></i> Change Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
