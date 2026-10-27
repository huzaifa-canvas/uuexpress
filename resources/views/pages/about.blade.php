@extends('layouts.public')
@section('title', 'About Us | United Universe Express LLC')

@section('content')
<section class="page-hero">
    <img src="{{ asset('assets/img/hero-poster.jpg') }}" alt="">
    <div class="page-hero__inner">
        <h1 class="display">About Us</h1>
        <p class="page-hero__subtitle">Albany&rsquo;s local courier team for parcels, groceries, meals, and pets.</p>
    </div>
</section>

<section class="about">
    <div class="container about__grid">
        <div class="about__collage">
            <img src="{{ asset('assets/img/about-collage.png') }}" alt="United Universe Express deliveries">
        </div>
        <div class="about__text">
            <div class="eyebrow">About Us</div>
            <h2 class="display">A Company Built<br>on Everyday Help</h2>
            <p>United Universe Express LLC has earned its name through careful work, efficient routes, and a professional manner on every job. We began with a clear aim: to take some of the daily errands off our customers&rsquo; lists. A package that needs sending, a weekly grocery run, or a meal order can eat into a busy day. We take on those tasks and complete them with care.</p>
        </div>
    </div>
</section>

<section class="section-pad about-sub">
    <div class="container">
        <div class="about-feature">
            <div class="about-feature__text">
                <h3>The Meaning of &ldquo;Need It Now?&rdquo;</h3>
                <p class="text-muted">Our motto is a question we ask every customer. It speaks to anyone who could use an extra pair of hands, from older residents who find travel difficult to restaurants that need a dependable delivery partner. Households and businesses across Albany now count on us as part of their daily routine. Our drivers live and work in the Capital District, and each one is vetted before joining the team.</p>
            </div>
            <div class="about-feature__media">
                <img src="{{ asset('assets/img/about-feature-1.jpg') }}" alt="Driver handing off a package at the door">
            </div>
        </div>
        <div class="about-feature">
            <div class="about-feature__media">
                <img src="{{ asset('assets/img/about-feature-2.jpg') }}" alt="United Universe Express driver handling a delivery">
            </div>
            <div class="about-feature__text">
                <h3>Skilled People, Simple Service</h3>
                <p class="text-muted">Our crew is ready for jobs of every size. They bring practical experience to each assignment and handle every item with steady attention. We keep booking straightforward, deliveries prompt, and pricing fair.</p>
            </div>
        </div>
    </div>
</section>

<section class="section-pad values">
    <div class="container">
        <div class="values__head">
            <h2 class="display">The Values Behind<br>Every Delivery</h2>
        </div>
        <div class="values__grid">
            <div class="value-card">
                <h4>Speed</h4>
                <p>We move quickly because your schedule matters.</p>
            </div>
            <div class="value-card">
                <h4>Quality</h4>
                <p>Each pickup and drop-off gets close attention from start to finish.</p>
            </div>
            <div class="value-card">
                <h4>Reliability</h4>
                <p>Customers return to us because we follow through.</p>
            </div>
            <div class="value-card">
                <h4>Innovation</h4>
                <p>Online ordering and monthly plans make delivery easier to manage.</p>
            </div>
        </div>
    </div>
</section>

<section class="about-cta section-pad">
    <h2 class="cta-heading">Ready When You Are</h2>
    <p class="text-muted">Book your first delivery today and see why Albany households and businesses choose UU Express.</p>
    <a href="{{ route('contact') }}" class="btn btn-outline">Book Now</a>
</section>
@endsection
