@php 
use \App\Library\Enum;
@endphp
<div class="dashboard-left-sidebar">
    <div class="close-button d-flex d-lg-none">
        <button class="close-sidebar">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="profile-box">
        <div class="cover-image">
            <img src="{{ Vite::asset(Enum::USER_COVER_IMAGE_PATH) }}" class="img-fluid blur-up lazyload" alt="">
        </div>

        <div class="profile-contain">
            <div class="profile-image">
                <div class="position-relative">
                    <img src="{{ authUser()->getAvatar() }}" class="blur-up lazyload update_img" alt="">
                </div>
            </div>

            <div class="profile-name">
                <h3>{{ authUser()->full_name }}</h3>
                <h6 class="text-content"><i data-feather="phone"></i> {{ authUser()->phone }}</h6>
            </div>
        </div>
    </div> 

    <ul class="nav nav-pills user-nav-pills">
        <li class="nav-item">
            <a class="nav-link @yield('dashboard','')" href="{{ route('dashboard.index') }}">
                <i data-feather="home"></i>
                Dashboard</a>
        </li>

        <li class="nav-item">
            <a class="nav-link @yield('order','')" href="{{ route('dashboard.order.index') }}">
                <i data-feather="shopping-bag"></i>
                Order
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @yield('order_return','')" href="{{ route('dashboard.order.return.list') }}">
                <i data-feather="refresh-cw"></i>
                Order Returns
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @yield('address','')" href="{{ route('dashboard.address.index') }}">
                <i data-feather="map-pin"></i>
                Address
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @yield('profile','')" href="{{ route('dashboard.profile.index') }}">
                <i data-feather="user"></i>
                Profile
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @yield('notification','')" href="{{ route('dashboard.notification.index') }}">
                <i data-feather="bell"></i>
                Notifications
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @yield('logout','')" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i data-feather="log-out"></i>
                Logout
            </a>
        </li>

    </ul>
</div>