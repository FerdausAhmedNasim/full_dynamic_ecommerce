<!-- Header Start -->
@php
use App\Models\Cart;

$cartIdentifier = request()->cookie('cart_identifier');
$cartItems = Cart::with('product')->where('cart_identifier', $cartIdentifier)->get();
@endphp

<header class="pb-0">
    {{-- <div class="header-top">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-5 col-md-4 d-xxl-block">
                </div>

                <div class="col-5 col-md-2">

                </div>

                <div class="col-2 col-md-6">
                    <ul class="about-list right-nav-about d-none d-md-flex">

                        @if (App\Models\Page::where(['link' => 'terms-and-conditions', 'active' => 1])->first())
                            <li class="right-nav-list">
                                <a href="{{ route('public.page.show', \App\Library\Enum::TERM_CONDITION) }}"
                                    class="text-white">Terms & Condition</a>
                            </li>
                        @endif

                    </ul>
                    <div class="d-flex d-md-none justify-content-end">
                        <img src="{{ Vite::asset(\App\Library\Enum::BANGLADESH_FLAG_PATH) }}" class="img-fluid blur-up lazyload me-0" alt="Bangladesh Flag">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="top-nav top-header sticky-header">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="navbar-top">
                        <button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                            <span class="navbar-toggler-icon">
                                <i class="fa-solid fa-bars"></i>
                            </span>
                        </button>
                        <a href="{{ url('/') }}" class="web-logo nav-logo d-none d-sm-block">
                            <img src="{{ settings('logo') ? asset(settings('logo')) : Vite::asset(\App\Library\Enum::LOGO_PATH) }}"
                                class="img-fluid blur-up lazyload" alt="Mukto Shop BD - Biggest Online Shopping Platform in Bangladesh">
                        </a>
                        <form class="d-sm-none">
                            <div class="input-group">
                                <input type="text" class="form-control search-type" placeholder="Search here..">
                                <button class="input-group-text">
                                    <i data-feather="search" class="font-light"></i>
                                </button>
                            </div>
                        </form>

                        <div class="middle-box">
                            <div class="search-box">
                                <form method="post" action="{{ route('public.product.search') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group">
                                        <input type="search" required name="search_by" class="form-control"
                                            placeholder="Search...">
                                        <button class="btn" type="submit" id="button-addon2">
                                            <i data-feather="search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="rightside-box">
                            <div class="search-full">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i data-feather="search" class="font-light"></i>
                                    </span>
                                    <input type="text" required class="form-control search-type"
                                        placeholder="Search here..">
                                    <span class="input-group-text close-search">
                                        <i data-feather="x" class="font-light"></i>
                                    </span>
                                </div>
                            </div>
                            <ul class="right-side-menu">
                                <li class="right-side">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <div class="search-box">
                                                <i data-feather="search"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="right-side">
                                    <div class="onhover-dropdown header-badge">
                                        <a href="{{ route('checkout') }}" class="btn btn-sm cart-button">
                                            <button type="button"
                                                class="btn p-0 position-relative header-wishlist header-cart">
                                                <i data-feather="shopping-cart"></i>
                                                @if(count($cartItems) > 0)
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge cartItemTotal">
                                                    {{ count($cartItems) }}
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                                @endif
                                            </button>
                                        </a>
                                    </div>
                                </li>

                                @auth
                                <li class="right-side">
                                    <a href="{{ route('public.wishlist.index') }}"
                                        class="btn p-0 position-relative header-wishlist ">
                                        <i data-feather="heart"></i>
                                            <span class="position-absolute top-0 start-100 translate-middle badge">
                                                <span id="wishlist">{{ '' }}</span>
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                    </a>
                                </li>

                                <li class="right-side right-side-last onhover-dropdown" style="display: block">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                        <div class="delivery-detail">
                                            <h6>Hello,</h6>
                                            <h5>{{ authUser()->full_name }}</h5>
                                        </div>
                                    </div>

                                    <div class="onhover-div onhover-div-login">
                                        <ul class="user-box-name">
                                            <li class="product-box-contain">
                                                <i></i>
                                                <a href="{{ route('dashboard.index') }}">Dashboard</a>
                                            </li>

                                            <li class="product-box-contain">
                                                <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="ti-power-off text-primary"></i>
                                                    Logout
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                @endauth

                                @guest
                                <li class="right-side onhover-dropdown">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="fs-5 ms-4 ms-lg-0">
                                            <i class="fa fa-user"></i>
                                        </div>

                                        <div class="d-none d-lg-flex align-items-center gap-3">
                                            <a class="fs-6 text-black" href="{{ route('login') }}">Log In</a>
                                            <div>|</div>
                                            <a class="fs-6 text-black" href="{{ route('register') }}">Register</a>
                                        </div>

                                        <div class="onhover-div onhover-div-login d-flex flex-column d-lg-none">
                                            <a class="fs-6 text-black" href="{{ route('login') }}">Log In</a>
                                            <div class="d-none d-lg-block">|</div>
                                            <a class="fs-6 text-black" href="{{ route('register') }}">Register</a>
                                        </div>
                                    </div>
                                </li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid-lg nav-menuBar">
        <div class="row">
            <div class="col-12">
                <div class="header-nav">
                    <div class="header-nav-left">
                        <button class="dropdown-category px-0">
                            <i data-feather="align-left"></i>
                            <span>All Categories</span>
                        </button>

                        <div class="category-dropdown">
                            <div class="category-title">
                                <h5>Categories</h5>
                                <button type="button" class="btn p-0 close-button text-content">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <ul class="category-list">
                                @foreach($categories as $category)
                                <li class="onhover-category-list">
                                    <div class="category-name d-flex justify-content-between align-items-center">
                                        <a href="{{ route('public.product.category_wise', $category->slug) }}" class="w-md-100 d-flex align-items-center">
                                            <img src="{{ $category->getIconImage() }}" alt="">
                                            <h6> {{ $category->getTranslation('title') }}</h6>
                                            @if(count($category->childrenCategories) > 0)
                                            <i class="fa-solid fa-angle-right"></i>
                                            @endif
                                        </a>
                                    </div>

                                    @if(count($category->childrenCategories) > 0)
                                    <div class="onhover-category-box">
                                        <div class="position-relative w-100 h-100">
                                            <div class="list-1 list">
                                                @foreach($category->childrenCategories as $key => $subCategory)
                                                <div class="category-title-box">
                                                    <div class="category-title-name d-flex justify-content-between align-items-center">
                                                        <a href="{{ route('public.product.category_wise', $subCategory->slug) }}"
                                                            class="w-md-100 d-flex align-items-center">
                                                            <img src="{{ $subCategory->getIconImage() }}" alt="">
                                                            <h6>{{ $subCategory->getTranslation('title') }} </h6>
                                                            @if(count($subCategory->childrenCategories) > 0)
                                                            <i class="fa-solid fa-angle-right"></i>
                                                            @endif
                                                        </a>
                                                    </div>
                                                    @if(count($subCategory->childrenCategories) > 0)
                                                    <div class="sub-category-title mt-3 mt-md-0">
                                                        <div class="row">
                                                            @foreach($subCategory->childrenCategories as $key
                                                            =>$subSubCategory)

                                                            <a class="col-xl-6 pb-3"
                                                                href="{{ route('public.product.category_wise', $subSubCategory->slug) }}">
                                                                <img src="{{ $subSubCategory->getIconImage() }}"
                                                                    alt="">
                                                                <h6>{{ $subSubCategory->getTranslation('title') }}</h6>
                                                            </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="header-nav-middle">
                        <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
                            <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                                <div class="offcanvas-header navbar-shadow">
                                    <a href="{{ url('/') }}" class="web-logo nav-logo">
                                        <img src="{{ settings('logo') ? asset(settings('logo')) : Vite::asset(\App\Library\Enum::LOGO_PATH) }}"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <a class="nav-link drop-none" href="{{ url('/') }}">Home</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link drop-none"
                                                href="{{ route('public.brand.index') }}">Brand</a>
                                        </li>

                                        @if (App\Models\Page::where(['link' => 'about-us', 'active' => 1])->first())
                                            <li class="nav-item">
                                                <a href="{{ route('public.page.about_us') }}" class="nav-link drop-none">About us</a>
                                            </li>
                                        @endif

                                        @if (App\Models\Page::where(['link' => 'contact-us', 'active' => 1])->first())
                                            <li class="nav-item">
                                                <a href="{{ route('public.contact.index') }}" class="nav-link drop-none">Contact us</a>
                                            </li>
                                        @endif
                                        {{-- <li class="nav-item dropdown">
                                            <a class="nav-link drop-none"
                                                href="{{ route('public.seller.index') }}">Shop</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link drop-none"
                                                href="{{ route('public.offer.index') }}">Offers</a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="header-nav-right px-0 d-none justify-content-end">
                        <img src="{{ Vite::asset(\App\Library\Enum::BANGLADESH_FLAG_PATH) }}" class="img-fluid blur-up lazyload me-0" alt="Bangladesh Flag">
                        
                        {{-- <img src="{{ Vite::asset(\App\Library\Enum::USA_FLAG_PATH) }}" class="img-fluid blur-up lazyload me-0" alt=""> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->