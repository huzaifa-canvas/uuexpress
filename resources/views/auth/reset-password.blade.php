@extends('layouts.auth')
@section('title', 'Reset Password')

@section('content')
<h1>Reset password</h1>
<p class="sub">Choose a new password for your account.</p>

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>

    <label for="password">New Password</label>
    <input id="password" type="password" name="password" required>

    <label for="password_confirmation">Confirm Password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>

    <button type="submit" class="btn">Reset Password</button>
</form>

<p class="muted-link"><a href="{{ route('login') }}">Back to sign in</a></p>
@endsection
