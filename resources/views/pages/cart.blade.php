@extends('layouts.public')
@section('title', 'Cart | United Universe Express LLC')

@section('content')
<section class="page-hero">
    <img src="{{ asset('assets/img/hero-poster.jpg') }}" alt="">
    <div class="page-hero__inner">
        <h1 class="display">Your Cart</h1>
    </div>
</section>

<section class="section-pad">
    <div class="container" style="text-align:center;">
        <h2 class="display" style="font-size:3.875rem;margin-bottom:1.25rem;">Your Cart Is Empty</h2>
        <p class="text-muted" style="margin-bottom:2rem;">Browse our shop to add items to your cart.</p>
        <a href="{{ route('shop') }}" class="btn btn-outline">Go To Shop</a>
    </div>
</section>
@endsection
