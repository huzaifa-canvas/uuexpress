@extends('layouts.public')
@section('title', 'United Universe Express LLC | Home')

@section('content')
<section class="hero">
    <div class="hero__media">
        @if(request()->has('nomedia'))
            <img src="{{ asset('assets/img/hero-poster.jpg') }}" alt="">
        @else
            <video autoplay muted loop playsinline poster="{{ asset('assets/img/hero-poster.jpg') }}">
                <source src="{{ asset('assets/video/hero.mp4') }}" type="video/mp4">
            </video>
        @endif
    </div>
    <div class="hero__content">
        <div class="hero__eyebrow">United Universe Express LLC.</div>
        <h1 class="display">Albany Courier Services<br>Built Around You</h1>
        <a href="{{ route('contact') }}" class="btn btn-white">Book Now</a>
    </div>
</section>

<section class="about">
    <div class="container about__grid">
        <div class="about__collage">
            <img src="{{ asset('assets/img/about-collage.png') }}" alt="United Universe Express deliveries">
        </div>
        <div class="about__text">
            <div class="eyebrow">About Us</div>
            <h2 class="display">Your Neighborhood<br>Courier Team</h2>
            <p>United Universe Express LLC carries parcels, groceries, meals, and pets across Albany and the Capital District. Our vetted local drivers know these streets well, so every delivery follows a sensible route and reaches its door on schedule.</p>
            <p>Our motto, &ldquo;If you need it to be there&hellip;it&rsquo;s there?&rdquo;, is an open offer to anyone who could use an extra hand. Busy families, older residents, and local businesses all rely on us for fair rates and steady service.</p>
            <a href="{{ route('about') }}" class="btn btn-outline">Our Story</a>
        </div>
    </div>
</section>

<section class="services">
    <div class="container">
        <div class="services__head">
            <div class="eyebrow">Our Services</div>
            <h2 class="display">Local Delivery Services,<br>Door-to-Door</h2>
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
        <div class="services__cta">
            <a href="{{ route('services.index') }}" class="btn btn--ghost">View All Services</a>
        </div>
    </div>
</section>

<section class="testimonials">
    <div class="testimonials__inner">
        <div class="testimonials__head">
            <div class="eyebrow">Testimonials</div>
            <h2 class="display">Words From<br>Our Customers</h2>
        </div>
        <div class="testimonials__track" id="reviewTrack">
            @foreach($testimonials as $t)
            <div class="t-card">
                <div class="t-card__top">
                    <span class="t-card__quote">&rdquo;</span>
                    <span class="t-card__stars">{!! str_repeat('&#9733;', (int) $t->rating) !!}</span>
                </div>
                <p>{{ $t->quote }}</p>
                <div class="t-card__name">{{ $t->client_name }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
(function () {
    var track = document.getElementById('reviewTrack');
    if (!track) return;
    var down = false, startX = 0, startScroll = 0;
    track.addEventListener('pointerdown', function (e) {
        down = true;
        startX = e.clientX;
        startScroll = track.scrollLeft;
        track.classList.add('is-dragging');
        track.setPointerCapture(e.pointerId);
    });
    track.addEventListener('pointermove', function (e) {
        if (!down) return;
        track.scrollLeft = startScroll - (e.clientX - startX);
    });
    ['pointerup', 'pointercancel'].forEach(function (evt) {
        track.addEventListener(evt, function () {
            down = false;
            track.classList.remove('is-dragging');
        });
    });
    track.addEventListener('wheel', function (e) {
        if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) return;
        if (e.deltaY === 0) return;
        var max = track.scrollWidth - track.clientWidth;
        if ((track.scrollLeft <= 0 && e.deltaY < 0) || (track.scrollLeft >= max && e.deltaY > 0)) return;
        e.preventDefault();
        track.scrollLeft += e.deltaY;
    }, { passive: false });
})();
</script>

<section class="contact" id="contact">
    <img class="contact__bg" src="{{ asset('assets/img/contact-bg.jpg') }}" alt="">
    <div class="contact__card">
        <div class="eyebrow">Reach Out</div>
        <h2 class="display">Plan Your Next<br>Delivery</h2>
        @if(request()->has('contact'))
            <div class="form-msg {{ request('contact') === 'success' ? 'success' : 'error' }}">
                {{ request('contact') === 'success' ? 'Thanks! Your message has been sent.' : 'Something went wrong. Please check your details and try again.' }}
            </div>
        @endif
        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
            </div>
            <div class="form-row">
                <input type="email" name="email" placeholder="Email" required>
                <input type="tel" name="phone" placeholder="Phone">
            </div>
            <input type="text" name="subject" placeholder="Subject" value="{{ request('subject', '') }}" required>
            <textarea name="message" placeholder="Message" required></textarea>
            <button type="submit" class="btn btn-outline">Send Message</button>
        </form>
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

<section class="process">
    <div class="container">
        <div class="process__head">
            <div class="eyebrow">How It Works</div>
            <h2 class="display">Your Delivery in<br>Three Steps</h2>
        </div>
        <div class="process__grid">
            <div class="process-card">
                <img src="{{ asset('assets/img/icons/process-1.png') }}" alt="">
                <h3>Choose a Service</h3>
                <p>Pick the delivery option that suits your distance and cargo.</p>
            </div>
            <div class="process-card is-featured">
                <img src="{{ asset('assets/img/icons/process-2.png') }}" alt="">
                <h3>Place Your Order</h3>
                <p>Book online and share your pickup and drop-off details.</p>
            </div>
            <div class="process-card">
                <img src="{{ asset('assets/img/icons/process-3.png') }}" alt="">
                <h3>We Deliver</h3>
                <p>A vetted local driver collects your item and brings it over.</p>
            </div>
        </div>
    </div>
</section>
@endsection
