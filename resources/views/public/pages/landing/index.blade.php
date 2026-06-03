@extends('public.layout.master')
@section('title', settings('app_title') ? settings('app_title') : '')

@section('content')
<!-- Home Section Start -->
@include('public.pages.landing.partials.hero-slider')
<!-- Home Section End -->

<!-- Category & Brand Section Start -->
{{-- @include('public.pages.landing.partials.category') --}}
<!-- Category & Brand Section End -->

<!-- Deals Section Start -->
@include('public.pages.landing.partials.deals')
<!-- Deals Section End -->

<!-- Top Brand Offer Section Start -->
@include('public.pages.landing.partials.top-brand-offer')
<!-- Top Brand Offer Section End -->

<!-- Flash Sale Section Start -->
@include('public.pages.landing.partials.flash-sale')
<!-- Flash Sale Section End -->

<!-- Flash Sale Section Start -->
@include('public.pages.landing.partials.top_sale')
<!-- Flash Sale Section End -->

<!-- Banner Section Start -->
@include('public.pages.landing.partials.banner')
<!-- Banner Section End -->

<!-- Video Section Start -->
@include('public.pages.landing.partials.video')
<!-- Video Section End -->

<!-- Only for you Section Start -->
@include('public.pages.landing.partials.for-you')
<!-- Only for you Section End -->

<!-- Cookie Bar Box Start -->
{{-- @if (!$has_cookie)
@include('public.components.cookie')
@endif --}}
<!-- Cookie Bar Box End -->
@endsection
