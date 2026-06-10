<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Mukto Shop BD is the biggest online shopping platform in Bangladesh, offering a wide range of products including fashion, electronics, home appliances, and more.">
    <meta name="keywords" content="online shopping Bangladesh, Mukto Shop BD, e-commerce Bangladesh, buy electronics online, fashion online Bangladesh, home appliances, best online store Bangladesh, affordable shopping, fast delivery Bangladesh, online deals, shop online Bangladesh">
    <meta name="author" content="Mukto Shop BD">

    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="currency_symbol" content="{{ settings('currency_symbol') ? settings('currency_symbol') : config('app.currency_sign') }}">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="@yield('og_title')">
    <meta property="og:description" content="@yield('og_description')">
    <meta property="og:image" content="@yield('og_image')">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Mukto Shop BD">
    <meta property="og:url" content="@yield('og_url')">
    <meta property="og:locale" content="en_US">
    <link rel="canonical" href="@yield('canonical')">

    <!-- Twitter Meta -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Mukto Shop BD">
    <meta name="twitter:description" content="Mukto Shop BD is the biggest online shopping platform in Bangladesh, offering a wide range of products including fashion, electronics, home appliances, and more.">
    <meta name="twitter:image" content="{{ asset('logo-1200x630.jpg') }}">

    <!-- Schema.org Markup -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "Choose different",
            "url": "https://muktoshopbd.com",
            "logo": "https://muktoshopbd.com/logo.png",
            "sameAs": [
                "https://facebook.com/muktoshopbd",
                "https://twitter.com/muktoshopbd"
            ]
        }
    </script>

    <link rel="stylesheet" href="{{ route('frontendDynamic.css') }}">

    @stack('share_info')

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">

    @vite('resources/frontend_assets/sass/app.scss')
    @stack('styles')
    <style>
        .bg-secondary {
            background-color: #6c757d !important;
        }
    </style>

    <!-- latest jquery-->
    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>

    <!-- jquery ui-->
    <script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-K6BT2Q5N');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K6BT2Q5N" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

    @php
        $categories = \App\Models\Category::whereNull('parent_id')
            ->with([
                'childrenCategories' => function ($query) {
                    $query->active()->with([
                        'childrenCategories' => function ($query) {
                            $query->active()->with([
                                'childrenCategories' => function ($query) {
                                    $query->active();
                                },
                            ]);
                        },
                    ]);
                },
            ])
            ->active()
            ->orderBy('order')
            ->get();
    @endphp

    <!-- Loader Start -->
    {{-- <div class="fullpage-loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div> --}}
    <!-- Loader End -->

    <!-- Header Start -->
    @include('public.components.header')
    <!-- Header End -->

    <!-- mobile fix menu start -->
    @include('public.components.mobile-menu')
    <!-- mobile fix menu end -->

    @yield('content')

    <!-- Footer Section Start -->
    @include('public.components.footer')
    <!-- Footer Section End -->

    <!-- Items section Start -->
    @include('public.components.side-cart')
    <!-- Items section End -->

    <!-- Modal Start -->
    @include('public.layout.partials.modals')
    <!-- Modal End -->

    <!-- Tap to top and theme setting button start -->
    <div class="theme-option">
        <div class="back-to-top">
            <a id="back-to-top" href="#">
                <i class="fas fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <!-- Tap to top and theme setting button end -->

    <!-- Bg overlay Start -->
    <div class="bg-overlay"> </div>
    <!-- Bg overlay End -->

    <!-- latest jquery-->
    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>

    <!-- jquery ui-->
    <script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('frontend/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap/popper.min.js') }}"></script>

    <!-- feather icon js-->
    <script src="{{ asset('frontend/js/feather/feather.min.js') }}"></script>
    <script src="{{ asset('frontend/js/feather/feather-icon.js') }}"></script>

    <!-- Lazyload Js -->
    <script src="{{ asset('frontend/js/lazysizes.min.js') }}"></script>

    <!-- Slick js-->
    <script src="{{ asset('frontend/js/slick/slick.js') }}"></script>
    <script src="{{ asset('frontend/js/slick/slick-animation.min.js') }}"></script>
    <script src="{{ asset('frontend/js/slick/custom_slick.js') }}"></script>

    <!-- Swiper ja -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('frontend/js/swiper/swiper.js') }}"></script>

    <!-- Lazysizes Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>


    <!-- Auto Height Js -->
    <script src="{{ asset('frontend/js/auto-height.js') }}"></script>

    <!-- Timer Js -->
    <script src="{{ asset('frontend/js/timer1.js') }}"></script>

    <!-- Fly Cart Js -->
    {{-- <script src="{{ asset('frontend/js/fly-cart.js') }}"></script> --}}

    <!-- My Cart Js -->
    {{-- <script src="{{ asset('frontend/js/my-cart.js') }}"></script> --}}

    <!-- My Wishlist Js -->
    {{-- <script src="{{ asset('frontend/js/my-wishlist.js') }}"></script> --}}

    <!-- Quantity js -->
    {{-- <script src="{{ asset('frontend/js/quantity-2.js') }}"></script> --}}

    <!-- WOW js -->
    <script src="{{ asset('frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/js/custom-wow.js') }}"></script>

    <!-- script js -->
    <script src="{{ asset('frontend/js/script.js') }}"></script>

    <!-- theme setting js -->
    <script src="{{ asset('frontend/js/theme-setting.js') }}"></script>


    @vite('resources/frontend_assets/js/app.js')
    @vite('resources/frontend_assets/js/my-wishlist.js')
    @include('public.components.flash')
    @stack('scripts')
    <script src="{{ asset('js/share.js') }}"></script>
</body>

</html>
