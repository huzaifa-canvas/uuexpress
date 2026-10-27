@extends('layouts.public')
@section('title', 'Thank You | United Universe Express LLC')

@section('content')
<section class="thankyou section-pad">
    <div class="container">
        <div class="thankyou__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 6 9 17l-5-5"/>
            </svg>
        </div>
        <div class="eyebrow">Request Received</div>
        <h1 class="cta-heading">Thank You For Hiring Us</h1>
        <p class="text-muted">We&rsquo;ve received your request and will be in touch shortly to confirm the details.
            Keep an eye on your email &mdash; that&rsquo;s where we&rsquo;ll reach you first.</p>
        <div class="thankyou__actions">
            <a href="{{ route('home') }}" class="btn btn-outline">Back To Home</a>
            <a href="{{ route('services.index') }}" class="btn">Browse Services</a>
        </div>
    </div>
</section>
@endsection
