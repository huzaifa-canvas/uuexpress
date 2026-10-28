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
    <div class="container">
        @if (session('status'))
            <div class="form-msg success" style="margin-bottom:1.5rem;">{{ session('status') }}</div>
        @endif

        @if ($items->isEmpty())
            <div style="text-align:center;">
                <h2 class="display" style="font-size:3rem;margin-bottom:1.25rem;">Your Cart Is Empty</h2>
                <p class="text-muted" style="margin-bottom:2rem;">Browse our shop to add items to your cart.</p>
                <a href="{{ route('shop') }}" class="btn btn-outline">Go To Shop</a>
            </div>
        @else
            <form method="POST" action="{{ route('cart.update') }}">
                @csrf
                @method('PATCH')
                <div class="cart-table">
                    <div class="cart-row cart-row--head">
                        <div>Product</div>
                        <div>Price</div>
                        <div>Qty</div>
                        <div>Total</div>
                        <div></div>
                    </div>
                    @foreach ($items as $item)
                        @php $p = $item['product']; @endphp
                        <div class="cart-row">
                            <div class="cart-prod">
                                <img src="{{ asset($p->image) }}" alt="">
                                <div>
                                    <div class="cart-prod__name">{{ html_entity_decode($p->name) }}</div>
                                    <div class="cart-prod__unit text-muted">{{ $p->unit }}</div>
                                </div>
                            </div>
                            <div data-label="Price">${{ number_format((float) $p->price, 2) }}</div>
                            <div data-label="Qty">
                                <input type="number" name="quantities[{{ $p->id }}]" value="{{ $item['quantity'] }}" min="0" class="cart-qty">
                            </div>
                            <div data-label="Total" class="cart-line-total">${{ number_format($item['line_total'], 2) }}</div>
                            <div>
                                <button type="button" class="cart-remove" title="Remove">&times;</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="cart-foot">
                    <button type="submit" class="btn btn-outline">Update Cart</button>
                    <div class="cart-summary">
                        <div class="cart-summary__row"><span>Subtotal</span><strong>${{ number_format($subtotal, 2) }}</strong></div>
                        <a href="{{ route('checkout') }}" class="btn">Proceed To Checkout</a>
                    </div>
                </div>
            </form>

            {{-- Per-item remove forms (DELETE) --}}
            @foreach ($items as $item)
                <form id="rm-{{ $item['product']->id }}" method="POST" action="{{ route('cart.remove', $item['product']) }}" class="d-none">
                    @csrf @method('DELETE')
                </form>
            @endforeach
        @endif
    </div>
</section>

@push('scripts')
<style>
    .cart-table { border:1px solid #ececec; border-radius:14px; overflow:hidden; }
    .cart-row { display:grid; grid-template-columns:3fr 1fr 1fr 1fr 40px; align-items:center; gap:1rem; padding:1rem 1.25rem; border-bottom:1px solid #f0f0f0; }
    .cart-row--head { background:#fafafa; font-weight:600; font-size:.82rem; letter-spacing:.03em; text-transform:uppercase; color:#777; }
    .cart-row:last-child { border-bottom:0; }
    .cart-prod { display:flex; align-items:center; gap:.9rem; }
    .cart-prod img { width:58px; height:58px; object-fit:cover; border-radius:9px; }
    .cart-prod__name { font-weight:600; }
    .cart-prod__unit { font-size:.82rem; }
    .cart-qty { width:68px; padding:.5rem .6rem; border:1px solid #ddd; border-radius:8px; }
    .cart-line-total { font-weight:700; }
    .cart-remove { width:30px; height:30px; border-radius:50%; border:1px solid #e3e3e3; background:#fff; color:#b02a37; font-size:1.2rem; line-height:1; cursor:pointer; }
    .cart-remove:hover { background:#b02a37; color:#fff; }
    .cart-foot { display:flex; justify-content:space-between; align-items:flex-start; gap:2rem; margin-top:1.5rem; flex-wrap:wrap; }
    .cart-summary { min-width:260px; margin-left:auto; }
    .cart-summary__row { display:flex; justify-content:space-between; font-size:1.1rem; margin-bottom:1rem; padding-bottom:1rem; border-bottom:1px solid #eee; }
    .cart-summary .btn { width:100%; }
    @media (max-width:720px) {
        .cart-row { grid-template-columns:1fr 1fr; }
        .cart-row--head { display:none; }
        .cart-prod { grid-column:1 / -1; }
        .cart-row > div[data-label]::before { content:attr(data-label) ": "; font-weight:600; color:#888; }
    }
</style>
<script>
    // Wire the × buttons to their DELETE forms
    document.querySelectorAll('.cart-remove').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var row = btn.closest('.cart-row');
            var id = row.querySelector('input[name^="quantities"]').name.match(/\d+/)[0];
            var f = document.getElementById('rm-' + id);
            if (f) f.submit();
        });
    });
</script>
@endpush
@endsection
