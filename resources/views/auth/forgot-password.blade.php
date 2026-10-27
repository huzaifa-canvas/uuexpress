@extends('layouts.auth')
@section('title', 'Forgot Password')

@section('content')
<h1>Forgot password?</h1>
<p class="sub">Enter your email and we&rsquo;ll send you a reset link.</p>

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

    <button type="submit" class="btn">Email Password Reset Link</button>
</form>

<p class="muted-link"><a href="{{ route('login') }}">Back to sign in</a></p>
@endsection
