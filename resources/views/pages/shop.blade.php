@extends('layouts.public')
@section('title', 'Shop | United Universe Express LLC')

@section('content')
<section class="page-hero">
    <img src="{{ asset('assets/img/hero-poster.jpg') }}" alt="">
    <div class="page-hero__inner">
        <h1 class="display">Shop</h1>
    </div>
</section>

<section class="shop">
    <div class="container">
        <div class="shop__head">
            <div class="eyebrow">Packing Supplies</div>
            <h2 class="display">Everything You Need<br>To Ship It Safely</h2>
            <p class="text-muted">Choose your delivery, check out in a few clicks, and let a local driver take it from there.</p>
        </div>

        <div class="shop__grid">
            @foreach($products as $p)
            <article class="product-card">
                <div class="product-card__media">
                    <img src="{{ asset($p->image) }}" alt="{{ html_entity_decode($p->name) }}">
                    @if(!empty($p->tag))
                    <span class="product-card__tag">{{ $p->tag }}</span>
                    @endif
                </div>
                <h3 class="product-card__name">{{ html_entity_decode($p->name) }}</h3>
                <p class="product-card__desc">{{ $p->description }}</p>
                <div class="product-card__foot">
                    <span class="product-card__price">
                        ${{ number_format((float) $p->price, 2) }}
                        <small>{{ $p->unit }}</small>
                    </span>
                    <a href="{{ route('cart') }}" class="btn product-card__btn">Add To Cart</a>
                </div>
            </article>
            @endforeach
        </div>

        <div class="shop__note">
            <p class="text-muted">Need a bulk quote or something not listed here?</p>
            <a href="{{ route('contact') }}" class="btn">Request A Quote</a>
        </div>
    </div>
</section>
@endsection
