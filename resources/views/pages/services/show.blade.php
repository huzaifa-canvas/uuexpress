@extends('layouts.public')
@section('title', $service->name . ' | United Universe Express LLC')

@section('content')
<section class="page-hero">
    <img src="{{ asset($service->image) }}" alt="{{ $service->name }}">
    <div class="page-hero__inner">
        <h1 class="display">{{ $service->name }}</h1>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="shop__head" style="margin-bottom:0;">
            <h2 class="display" style="font-size:3rem;line-height:1.15;">{!! nl2br(e($service->detail_heading)) !!}</h2>
            <p class="text-muted">{{ $service->detail_body }}</p>
        </div>
        @if(!empty($service->features))
        <ul class="feature-list">
            @foreach($service->features as $feature)
            <li>{{ $feature }}</li>
            @endforeach
        </ul>
        @endif
    </div>
</section>

<section class="service-cta section-pad">
    <h2 class="cta-heading">{{ $service->cta_heading }}</h2>
    <div class="date-cta">
        <button type="button" class="btn btn-outline" data-book-now="{{ $service->name }}">Book Now</button>
    </div>
</section>
@endsection
