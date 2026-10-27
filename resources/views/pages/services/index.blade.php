@extends('layouts.public')
@section('title', 'Services | United Universe Express LLC')

@section('content')
<section class="page-hero">
    <img src="{{ asset('assets/img/hero-poster.jpg') }}" alt="">
    <div class="page-hero__inner">
        <h1 class="display">Our Services</h1>
    </div>
</section>

<section class="services services--plain">
    <div class="container">
        <div class="services__head">
            <div class="eyebrow">Our Services</div>
            <h2 class="display">Courier Services in Albany, NY</h2>
            <p class="text-muted" style="max-width:38rem;margin:0.75rem auto 0;">Four delivery options, one local team. Choose the service that fits your distance and cargo.</p>
        </div>
        <div class="services__grid">
            @foreach($services as $s)
            <div class="service-card service-card--{{ $s->tint }}">
                <img src="{{ asset($s->image) }}" alt="{{ $s->name }}">
                <span class="service-card__tint"></span>
                <div class="service-card__body">
                    <a href="{{ route('services.show', $s->slug) }}" class="service-card__title-link">
                        <h3 class="service-card__title">{{ $s->name }}</h3>
                    </a>
                    <div class="service-card__reveal"><div>
                        <p>{{ $s->desc }}</p>
                        <button type="button" class="btn btn--ghost" data-book-now="{{ $s->name }}">Book Now</button>
                    </div></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-pad service-details">
    <div class="container">
        @foreach($services as $s)
        <div class="service-details__row">
            <h3><a href="{{ route('services.show', $s->slug) }}">{{ $s->name }}</a></h3>
            <p class="text-muted">{{ $s->intro ?: $s->desc }}</p>
        </div>
        @endforeach
    </div>
</section>

<section class="ready">
    <div class="container ready__inner">
        <div class="ready__left">
            <img src="{{ asset('assets/img/ready-van.png') }}" alt="Van at the door">
        </div>
        <div class="ready__right">
            <div class="ready__text">
                <div class="eyebrow">Need It Now?</div>
                <h2 class="display">One Booking Gets<br>It Moving</h2>
                <p>Order online today and leave the driving to us.</p>
                <a href="{{ route('contact') }}" class="btn btn-outline">Book Now</a>
            </div>
            <div class="ready__front-wrap">
                <img class="ready__front" src="{{ asset('assets/img/doorstep-1.png') }}" alt="Doorstep delivery">
            </div>
        </div>
    </div>
</section>
@endsection
