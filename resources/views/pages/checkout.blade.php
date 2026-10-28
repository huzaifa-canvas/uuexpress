@extends('layouts.public')
@section('title', 'Checkout | United Universe Express LLC')

@section('content')
<section class="page-hero">
    <img src="{{ asset('assets/img/hero-poster.jpg') }}" alt="">
    <div class="page-hero__inner">
        <h1 class="display">Checkout</h1>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        @php $u = auth()->user(); @endphp

        @if ($u)
            <p class="text-muted" style="margin-bottom:1.5rem;">Logged in as <strong>{{ $u->name }}</strong> ({{ $u->email }}).</p>
        @else
            <p class="text-muted" style="margin-bottom:1.5rem;">Checking out as a guest. <a href="{{ route('login') }}">Log in</a> if you have an account &mdash; or just fill in your details below.</p>
        @endif

        <form method="POST" action="{{ route('checkout.store') }}" id="checkoutForm">
            @csrf
            <input type="hidden" name="payment_intent_id" id="checkoutPaymentIntentId" value="">

            <div class="checkout-grid">
                <div class="checkout-main">
                    <h2 class="checkout-h">Billing details</h2>
                    @if ($errors->any())
                        <div class="form-msg error" style="margin-bottom:1rem;">{{ $errors->first() }}</div>
                    @endif
                    <div class="form-row">
                        <input type="text" name="customer_name" placeholder="Full Name" value="{{ old('customer_name', $u?->name) }}" required>
                        <input type="tel" name="phone" placeholder="Phone" value="{{ old('phone', $u?->phone) }}">
                    </div>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email', $u?->email) }}" required>
                    <input type="text" name="address" placeholder="Street Address" value="{{ old('address') }}" required>
                    <div class="form-row">
                        <input type="text" name="city" placeholder="City" value="{{ old('city') }}">
                        <input type="text" name="postcode" placeholder="ZIP / Postcode" value="{{ old('postcode') }}">
                    </div>
                    <textarea name="notes" placeholder="Order notes (optional)">{{ old('notes') }}</textarea>

                    <h2 class="checkout-h" style="margin-top:1.75rem;">Payment</h2>
                    <label class="checkout-card-label">Card details</label>
                    <div id="checkoutCard" class="checkout-card"></div>
                    <div id="checkoutCardError" class="form-msg error" style="display:none;margin-top:.75rem;"></div>
                </div>

                <aside class="checkout-aside">
                    <h2 class="checkout-h">Your order</h2>
                    <div class="checkout-summary">
                        @foreach ($items as $item)
                            <div class="checkout-line">
                                <span>{{ html_entity_decode($item['product']->name) }} <small>× {{ $item['quantity'] }}</small></span>
                                <span>${{ number_format($item['line_total'], 2) }}</span>
                            </div>
                        @endforeach
                        <div class="checkout-line checkout-line--total">
                            <span>Total</span>
                            <strong>${{ number_format($subtotal, 2) }}</strong>
                        </div>
                    </div>
                    <button type="submit" class="btn" id="checkoutSubmit" style="width:100%;margin-top:1rem;">Pay ${{ number_format($subtotal, 2) }} &amp; Place Order</button>
                    <a href="{{ route('cart') }}" class="checkout-back">&larr; Back to cart</a>
                </aside>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<style>
    .checkout-grid { display:grid; grid-template-columns:1.6fr 1fr; gap:2rem; align-items:start; }
    .checkout-h { font-size:1.15rem; font-weight:700; margin:0 0 1rem; }
    .checkout-main input, .checkout-main textarea { width:100%; padding:.85rem 1rem; border:1px solid #ddd; border-radius:10px; margin-bottom:.8rem; font-size:.98rem; font-family:inherit; }
    .checkout-main .form-row { display:flex; gap:.8rem; }
    .checkout-main .form-row > input { flex:1; }
    .checkout-main textarea { min-height:5rem; resize:vertical; }
    .checkout-card-label { display:block; font-size:.8rem; font-weight:600; margin-bottom:.5rem; opacity:.85; }
    .checkout-card { background:#fff; border:1px solid #ddd; border-radius:10px; padding:14px 15px; }
    .checkout-card.StripeElement--focus { border-color:#157347; box-shadow:0 0 0 3px rgba(21,115,71,.12); }
    .checkout-aside { background:#fafafa; border:1px solid #eee; border-radius:14px; padding:1.5rem; position:sticky; top:1.5rem; }
    .checkout-line { display:flex; justify-content:space-between; padding:.55rem 0; border-bottom:1px solid #eee; font-size:.95rem; }
    .checkout-line--total { border-bottom:0; font-size:1.15rem; padding-top:.9rem; }
    .checkout-back { display:block; text-align:center; margin-top:.9rem; color:#666; text-decoration:none; font-size:.9rem; }
    @media (max-width:860px) { .checkout-grid { grid-template-columns:1fr; } }
</style>
<script>
(function () {
    var form = document.getElementById('checkoutForm');
    var submitBtn = document.getElementById('checkoutSubmit');
    var piEl = document.getElementById('checkoutPaymentIntentId');
    var errEl = document.getElementById('checkoutCardError');
    var stripe = (window.Stripe && window.UU_STRIPE_KEY) ? Stripe(window.UU_STRIPE_KEY) : null;
    var card = null, submitting = false;

    if (stripe) {
        card = stripe.elements().create('card', { style: { base: { color: '#1b1b1b', fontSize: '15px' } } });
        card.mount('#checkoutCard');
    }
    function showErr(m) { errEl.textContent = m; errEl.style.display = 'block'; submitBtn.disabled = false; submitBtn.textContent = submitBtn.dataset.label; }

    form.addEventListener('submit', function (e) {
        if (submitting) return; // allow native submit after payment
        e.preventDefault();
        if (!form.reportValidity()) return;
        if (!stripe) { showErr('Payment is not available right now.'); return; }
        errEl.style.display = 'none';
        submitBtn.dataset.label = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing…';

        var fd = new FormData();
        fd.append('_token', form.querySelector('input[name="_token"]').value);
        fetch(@json(route('checkout.payment-intent')), {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: fd
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            if (res.error || !res.clientSecret) { showErr(res.error || 'Payment could not be started.'); return; }
            return stripe.confirmCardPayment(res.clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: form.querySelector('input[name="customer_name"]').value,
                        email: form.querySelector('input[name="email"]').value
                    }
                }
            }).then(function (result) {
                if (result.error) { showErr(result.error.message); return; }
                if (result.paymentIntent && result.paymentIntent.status === 'succeeded') {
                    piEl.value = result.paymentIntent.id;
                    submitting = true;
                    form.submit();
                } else {
                    showErr('Payment was not completed.');
                }
            });
        })
        .catch(function () { showErr('Payment could not be processed. Please try again.'); });
    });
})();
</script>
@endpush
@endsection
