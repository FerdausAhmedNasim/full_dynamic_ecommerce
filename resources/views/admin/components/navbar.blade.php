@php
use App\Library\Helper;

$auth_user = auth()->user();
$employee = $auth_user->employee;
$notifications = App\Models\Notification::where('send_date', '<=', now()->format('Y-m-d'))
                ->orWhereNull('send_date')
                ->latest()
                ->take(5)
                ->get();
@endphp

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="{{ route('admin.home.dashboard') }}"><img
                src="{{ settings('logo') ? asset(settings('logo')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                class="mr-2" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('admin.home.dashboard') }}"><img
                src="{{ settings('logo') ? asset(settings('logo')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                alt="logo" /></a>
    </div>
    <div class="welcome-text-sm" style="width: 50%;text-align: center;">
        <span style="color: #14886D;font-size: 16px;">Welcome! {{ $auth_user?->full_name }}</span>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-4">
            {{-- <li class="nav-item nav-profile">
                <a href="{{ url(config('app.url')) }}" target="_blank" class="navbar-toggler navbar-toggler align-self-center mx-2">
                    <i class="fa-solid fa-globe"></i>
                </a>
            </li> --}}
            <!-- <li class="nav-item nav-search d-none d-lg-block">
                <div class="input-group">
                    <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                        <span class="input-group-text" id="search">
                            <i class="icon-search"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
                </div>
            </li> -->
        </ul>

        <div class="welcome-text" style="width: 50%;text-align: right;">
            <span style="color: #14886D;font-size: 16px;">Welcome! {{ $auth_user?->full_name }}</span>
        </div>

        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile">
                <a href="{{ url('/pos') }}" class="align-self-center btn p-1 px-2 btn2-secondary text-white">
                    <i class="fa-solid fa-cart-plus"></i> POS
                </a>
            </li>
            <li class="nav-item nav-profile">
                <a href="{{ route('admin.clear.cache') }}" class="align-self-center btn p-1 px-2 btn2-secondary text-white">
                    <i class="fa-solid fa-broom"></i> 
                </a>
            </li>
            <li class="nav-item nav-profile">
                <a href="{{ url(config('app.url')) }}" target="_blank" class="navbar-toggler navbar-toggler align-self-center mx-2" style="color: var(--color-secondary);">
                    <i class="fa-solid fa-globe"></i>
                </a>
            </li>

            @if(Helper::hasAuthRolePermission('notification_index'))
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                    data-toggle="dropdown">
                    <i class="fa-regular fa-bell fa-lg mx-0"></i>
                    <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="notificationDropdown">
                    {{-- <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p> --}}
                    @if(count($notifications))
                        @foreach( $notifications as $notification )
                        <a class="dropdown-item preview-item" onclick="showViewModal( '{{$notification->message}}', '{{$notification->subject}}' )">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-success">
                                    <i class="ti-info-alt mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">
                                        {{$notification->subject}}
                            </h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </a>
                        @endforeach
                        <p class="mb-0 font-weight-normal float-left dropdown-header"><a class="nav-link" href="{{ route('admin.notification.index') }}">See all</a></p>
                    @else
                        <p class="mb-0 font-weight-normal float-left dropdown-header">You have 0 notifications</p>
                    @endif
                </div>
            </li>
            @endif

            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown" aria-expanded="false">
                <img src="{{ $employee ? $employee->getProfileImage() : Vite::asset(\App\Library\Enum::NO_AVATAR_PATH) }}"
                        alt="{{ $auth_user?->full_name }}" />
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                        <i class="fas fa-user"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ti-power-off text-primary"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>

<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
    @csrf
</form>
@include('admin.pages.notification.partials.modal_show_notification')
