@extends('layouts.auth')
@section('title', 'Sign In')

@section('content')
<h1>Welcome back</h1>
<p class="sub">Sign in to your account to continue.</p>

<form method="POST" action="{{ route('login') }}">
    @csrf
    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>

    <div class="row">
        <label class="check"><input type="checkbox" name="remember"> Remember me</label>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">Forgot password?</a>
        @endif
    </div>

    <button type="submit" class="btn">Sign In</button>
</form>

@if (Route::has('register'))
<p class="muted-link">Don&rsquo;t have an account? <a href="{{ route('register') }}">Create one</a></p>
@endif
@endsection
