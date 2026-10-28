<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'United Universe Express LLC')</title>
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ @filemtime(public_path('assets/css/style.css')) }}">
<style>
    /* Keep the booking popup compact so it fits without scrolling */
    .booking-modal__panel { max-height: 94vh; padding: 1.6rem 1.75rem; }
    .booking-modal__panel form { gap: 0.7rem; }
    .booking-modal__panel textarea { min-height: 4rem; }
    .booking-modal__eyebrow { margin-bottom: 0.25rem; }
    .booking-modal__title { margin-bottom: 0.6rem; }
    .booking-pay { margin:6px 0 2px; }
    .booking-pay__price { font-weight:700; font-size:1.05rem; margin-bottom:7px; }
    .booking-pay__label { display:block; font-size:.76rem; font-weight:600; letter-spacing:.02em; margin-bottom:5px; opacity:.85; }
    .booking-pay__card { background:#fff; border:1px solid rgba(0,0,0,.2); border-radius:10px; padding:11px 13px; }
    .booking-pay__card.StripeElement--focus { border-color:#157347; box-shadow:0 0 0 3px rgba(21,115,71,.12); }
    .booking-pay__card.StripeElement--invalid { border-color:#dc3545; }
</style>
</head>
<body>
<header class="site-header">
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('assets/img/logo-clean.png') }}" alt="United Universe Express LLC">
    </a>
    <nav class="site-nav" id="siteNav">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
        <a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'active' : '' }}">Shop</a>
        <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">Services</a>
        <a href="{{ route('subscriptions') }}" class="{{ request()->routeIs('subscriptions') ? 'active' : '' }}">Subscriptions</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
        <a href="{{ route('contact') }}" class="btn nav-cta">Get A Free Quote</a>
    </nav>
    <div class="header-right">
        <a href="{{ route('cart') }}" class="cart-btn" aria-label="Cart">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 8h16l-1.2 12H5.2L4 8z"/>
                <path d="M9 8V6.5a3 3 0 0 1 6 0V8"/>
            </svg>
            @if(($cartCount ?? 0) > 0)<span class="badge">{{ $cartCount }}</span>@endif
        </a>
        <a href="{{ route('contact') }}" class="btn header-quote">Get A Free Quote</a>
        <button class="menu-toggle" id="menuToggle" type="button"
                aria-label="Menu" aria-expanded="false" aria-controls="siteNav">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

@yield('content')

<footer class="site-footer">
    <img class="site-footer__bg" src="{{ asset('assets/img/footer-bg.jpg') }}" alt="">
    <div class="container">
        <div class="footer__grid">
            <div class="footer__brand">
                <img src="{{ asset('assets/img/logo-white.png') }}" alt="United Universe Express LLC">
                <a href="tel:+18302591567" class="footer__phone">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.4.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.4 0 .8-.2 1l-2.3 2.2z"/></svg>
                    <span>(830) 259-1567</span>
                </a>
                <div class="footer__phone footer__phone--muted">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 5.5-8 12-8 12s-8-6.5-8-12a8 8 0 1 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span>Albany &amp; the Capital District</span>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('shop') }}">Shop</a></li>
                    <li><a href="{{ route('services.index') }}">Services</a></li>
                    <li><a href="{{ route('subscriptions') }}">Subscriptions</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="{{ route('services.show', 'local-delivery') }}">Local Delivery</a></li>
                    <li><a href="{{ route('services.show', 'first-class') }}">First Class</a></li>
                    <li><a href="{{ route('services.show', 'long-distance') }}">Long Distance</a></li>
                    <li><a href="{{ route('services.show', 'pet-delivery') }}">Pet Delivery</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Legal Information</h4>
                <ul>
                    <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}">Terms Of Use</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <span>&copy; {{ date('Y') }} United Universe Express LLC. All Rights Reserved</span>
        <div class="socials">
            <a href="#" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-8h2.7l.4-3h-3.1V8.2c0-.9.3-1.5 1.5-1.5h1.7V4.1C16.4 4 15.5 4 14.5 4 12 4 10.5 5.5 10.5 8v2H8v3h2.5v8h3z"/></svg></a>
            <a href="#" aria-label="Twitter"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 7.5c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.8-.6.4-1.3.7-2.1.8A3.3 3.3 0 0 0 11.7 10c-2.7-.1-5.1-1.4-6.7-3.4-.3.5-.4 1-.4 1.7 0 1.1.6 2.1 1.5 2.7-.5 0-1-.2-1.5-.4 0 1.6 1.1 2.9 2.6 3.2-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.3 1.6 2.3 3.1 2.3-1.1.9-2.5 1.4-4.1 1.4H4c1.5.9 3.2 1.5 5 1.5 6 0 9.3-5 9.3-9.3v-.4c.7-.5 1.2-1.1 1.7-1.8z"/></svg></a>
            <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 8.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7zm0 5.8a2.3 2.3 0 1 1 0-4.6 2.3 2.3 0 0 1 0 4.6zM16.5 4h-9A3.5 3.5 0 0 0 4 7.5v9A3.5 3.5 0 0 0 7.5 20h9a3.5 3.5 0 0 0 3.5-3.5v-9A3.5 3.5 0 0 0 16.5 4zm2.3 12.5c0 1.3-1 2.3-2.3 2.3h-9c-1.3 0-2.3-1-2.3-2.3v-9c0-1.3 1-2.3 2.3-2.3h9c1.3 0 2.3 1 2.3 2.3v9zm-2-8.7a.8.8 0 1 1-1.6 0 .8.8 0 0 1 1.6 0z"/></svg></a>
        </div>
    </div>
</footer>

<div class="booking-modal" id="bookingModal" aria-hidden="true">
    <div class="booking-modal__overlay" data-booking-close></div>
    <div class="booking-modal__panel" role="dialog" aria-modal="true" aria-labelledby="bookingModalTitle">
        <button type="button" class="booking-modal__close" data-booking-close aria-label="Close">&times;</button>
        <div class="booking-modal__eyebrow">Request A Pickup</div>
        <h3 class="booking-modal__title" id="bookingModalTitle">Book <span id="bookingServiceName">a Delivery</span></h3>
        <div id="bookingFormMsg"></div>
        <form id="bookingForm" action="{{ route('booking.store') }}" method="POST">
            @csrf
            <input type="hidden" name="service_type" id="bookingServiceType" value="">
            <input type="hidden" name="payment_intent_id" id="bookingPaymentIntentId" value="">
            <div class="form-row">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="tel" name="phone" placeholder="Phone">
            </div>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="pickup_address" placeholder="Pickup Address" required>
            <input type="text" name="dropoff_address" placeholder="Drop-off Address" required>
            <div class="form-row">
                <input type="date" name="pickup_date" id="bookingDate" aria-label="Pickup date" required>
                <input type="time" name="pickup_time" aria-label="Pickup time" required>
            </div>
            <textarea name="notes" placeholder="Anything else we should know? (optional)"></textarea>

            <div class="booking-pay" id="bookingPayWrap" hidden>
                <div class="booking-pay__price" id="bookingPrice"></div>
                <label class="booking-pay__label">Card details</label>
                <div id="bookingCard" class="booking-pay__card"></div>
            </div>

            <button type="submit" class="btn btn-outline" id="bookingSubmitBtn">Send Booking Request</button>
        </form>
    </div>
</div>

<script>
(function () {
    var btn = document.getElementById('menuToggle');
    var nav = document.getElementById('siteNav');
    if (!btn || !nav) return;

    function setOpen(open) {
        nav.classList.toggle('is-open', open);
        btn.classList.toggle('is-open', open);
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.body.classList.toggle('nav-open', open);
    }
    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        setOpen(!nav.classList.contains('is-open'));
    });
    document.addEventListener('click', function (e) {
        if (nav.classList.contains('is-open') && !nav.contains(e.target)) setOpen(false);
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') setOpen(false);
    });
    window.addEventListener('resize', function () {
        if (window.innerWidth > 1180) setOpen(false);
    });
})();
</script>

<script src="https://js.stripe.com/v3/"></script>
<script>
    window.UU_STRIPE_KEY = @json(config('services.stripe.key'));
    window.UU_SERVICE_PRICES = @json($servicePrices ?? []);
    window.UU_THANKYOU_URL = @json(route('thank-you'));
    window.UU_PI_URL = @json(route('booking.payment-intent'));
</script>
<script>
(function () {
    var modal = document.getElementById('bookingModal');
    if (!modal) return;
    var form = document.getElementById('bookingForm');
    var msgBox = document.getElementById('bookingFormMsg');
    var serviceNameEl = document.getElementById('bookingServiceName');
    var serviceTypeEl = document.getElementById('bookingServiceType');
    var dateEl = document.getElementById('bookingDate');
    var payWrap = document.getElementById('bookingPayWrap');
    var priceEl = document.getElementById('bookingPrice');
    var piEl = document.getElementById('bookingPaymentIntentId');
    var submitBtn = document.getElementById('bookingSubmitBtn');
    var lastFocused = null;

    var prices = window.UU_SERVICE_PRICES || {};
    var stripe = (window.Stripe && window.UU_STRIPE_KEY) ? Stripe(window.UU_STRIPE_KEY) : null;
    var card = null, cardMounted = false, currentPrice = 0;

    function mountCard() {
        if (!stripe || cardMounted) return;
        card = stripe.elements().create('card', {
            style: { base: { color: '#1b1b1b', fontSize: '15px', '::placeholder': { color: '#9aa0a6' } } }
        });
        card.mount('#bookingCard');
        cardMounted = true;
    }
    function priceFor(name) {
        var p = prices[name];
        return p ? parseFloat(p) : 0;
    }
    function defaultLabel() { return currentPrice > 0 ? 'Pay & Book' : 'Send Booking Request'; }

    function openModal(serviceName, prefillDate) {
        serviceName = serviceName || 'a Delivery';
        serviceNameEl.textContent = serviceName;
        serviceTypeEl.value = serviceName;
        if (prefillDate) { dateEl.value = prefillDate; }
        msgBox.innerHTML = '';
        piEl.value = '';
        currentPrice = priceFor(serviceName);
        if (currentPrice > 0 && stripe) {
            mountCard();
            priceEl.textContent = 'Total: $' + currentPrice.toFixed(2);
            payWrap.hidden = false;
        } else {
            payWrap.hidden = true;
        }
        submitBtn.disabled = false;
        submitBtn.textContent = defaultLabel();
        form.hidden = false;
        lastFocused = document.activeElement;
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('booking-modal-open');
        var firstField = form.querySelector('input[name="name"]');
        if (firstField) { setTimeout(function () { firstField.focus(); }, 50); }
    }
    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('booking-modal-open');
        if (lastFocused && lastFocused.focus) { lastFocused.focus(); }
    }

    document.querySelectorAll('[data-book-now]').forEach(function (trigger) {
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            var serviceName = trigger.getAttribute('data-book-now') || '';
            var wrap = trigger.closest('.date-cta') || trigger.closest('form');
            var prefillDate = wrap ? wrap.querySelector('input[type="date"]') : null;
            openModal(serviceName, prefillDate ? prefillDate.value : '');
        });
    });
    modal.querySelectorAll('[data-booking-close]').forEach(function (el) {
        el.addEventListener('click', closeModal);
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });

    function fail(message) {
        msgBox.innerHTML = '<div class="form-msg error">' + (message || 'Something went wrong.') + '</div>';
        submitBtn.disabled = false;
        submitBtn.textContent = defaultLabel();
    }
    function token() { var t = form.querySelector('input[name="_token"]'); return t ? t.value : ''; }

    function submitBooking() {
        fetch(form.action, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: new FormData(form)
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.status === 'success') { window.location.href = window.UU_THANKYOU_URL; return; }
            fail(data.message);
        })
        .catch(function () { fail('Something went wrong. Please try again.'); });
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing…';

        if (!(currentPrice > 0 && stripe)) { submitBooking(); return; }

        var fd = new FormData();
        fd.append('service_type', serviceTypeEl.value);
        fd.append('_token', token());
        fetch(window.UU_PI_URL, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: fd
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            if (res.error || !res.clientSecret) { fail(res.error || 'Payment could not be started.'); return; }
            return stripe.confirmCardPayment(res.clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: form.querySelector('input[name="name"]').value,
                        email: form.querySelector('input[name="email"]').value
                    }
                }
            }).then(function (result) {
                if (result.error) { fail(result.error.message); return; }
                if (result.paymentIntent && result.paymentIntent.status === 'succeeded') {
                    piEl.value = result.paymentIntent.id;
                    submitBooking();
                } else {
                    fail('Payment was not completed.');
                }
            });
        })
        .catch(function () { fail('Payment could not be processed. Please try again.'); });
    });
})();
</script>
@stack('scripts')
</body>
</html>
