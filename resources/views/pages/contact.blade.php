@extends('layouts.public')
@section('title', 'Contact Us | United Universe Express LLC')

@section('content')
<section class="page-hero">
    <img src="{{ asset('assets/img/hero-poster.jpg') }}" alt="">
    <div class="page-hero__inner">
        <h1 class="display">Contact Us</h1>
    </div>
</section>

<section class="contact contact--plain">
    <div class="contact__card">
        <div class="eyebrow">Contact Us</div>
        <h2 class="display">Contact UU Express</h2>
        <p class="text-muted" style="font-size:1.0625rem;line-height:1.6rem;margin-bottom:1.5rem;">Questions about an order, a subscription, or a business partnership? Our team is happy to help.</p>

        <dl class="contact__info">
            <div><dt>Location</dt><dd>Albany, New York</dd></div>
            <div><dt>Service Area</dt><dd>Albany and the Capital District</dd></div>
            <div><dt>Phone</dt><dd><a href="tel:+18302591567">(830) 259-1567</a></dd></div>
            <div><dt>Email</dt><dd class="contact__info--pending">To be announced</dd></div>
        </dl>

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
            <textarea name="message" placeholder="Message" required>{{ request('date') ? 'Preferred pickup date: ' . request('date') . "\n\n" : '' }}</textarea>
            <button type="submit" class="btn">Send Message</button>
        </form>
    </div>
</section>
@endsection
