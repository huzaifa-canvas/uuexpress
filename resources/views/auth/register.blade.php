@extends('layouts.auth')
@section('title', 'Create Account')

@section('content')
<h1>Create your account</h1>
<p class="sub">Join United Universe Express.</p>

<form method="POST" action="{{ route('register') }}">
    @csrf
    <label for="name">Full Name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>

    <label for="password_confirmation">Confirm Password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>

    <button type="submit" class="btn">Create Account</button>
</form>

<p class="muted-link">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
@endsection
