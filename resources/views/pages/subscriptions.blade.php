@extends('layouts.public')
@section('title', 'Subscriptions | United Universe Express LLC')

@php
    $plans = [
        ['name' => 'Basic',        'price' => '$29/mo',  'desc' => 'Perfect for occasional shipments and small packages.'],
        ['name' => 'Professional', 'price' => '$79/mo',  'desc' => 'Ideal for growing businesses with regular delivery needs.', 'featured' => true],
        ['name' => 'Enterprise',   'price' => '$149/mo', 'desc' => 'Priority handling and dedicated support for high volume.'],
    ];
@endphp

@section('content')
<section class="page-hero">
    <img src="{{ asset('assets/img/hero-poster.jpg') }}" alt="">
    <div class="page-hero__inner">
        <h1 class="display">Subscriptions</h1>
    </div>
</section>

<section class="process">
    <div class="container">
        <div class="process__head">
            <div class="eyebrow">Plans</div>
            <h2 class="display">Choose Your<br>Delivery Plan</h2>
            <p class="text-muted" style="max-width:36rem;margin:1rem auto 0;">Regular deliveries on your calendar? A monthly plan keeps your costs steady and your orders moving.</p>
        </div>
        <div class="process__grid">
            @foreach($plans as $p)
            <div class="process-card {{ !empty($p['featured']) ? 'is-featured' : '' }}">
                <h3 style="font-size:2.25rem;">{{ $p['name'] }}</h3>
                <p style="font-size:2rem;font-weight:600;color:inherit;margin-bottom:1rem;">{{ $p['price'] }}</p>
                <p>{{ $p['desc'] }}</p>
                <a href="{{ route('contact') }}" class="btn {{ !empty($p['featured']) ? 'btn-white' : 'btn-outline' }}" style="margin-top:1.5rem;">Get Started</a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
