@php
use App\Library\Helper;
@endphp
<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabss nav-tabs-vertical" role="tablist">
            {{-- @if( Helper::hasAuthRolePermission('website_settings_cookies') )
            <li class="nav-item mb-2">
                <a class="nav-link @yield('cookies','')" href="{{ route('admin.website.setting.cookies') }}">
                    <i class="fa-solid fa-cookie ms-2 mr-1"></i> Cookies
                </a>
            </li>
            @endif --}}

            @if( Helper::hasAuthRolePermission('website_settings_terms_and_conditions') )
            <li class="nav-item mb-2">
                <a class="nav-link @yield('terms_and_conditions','')"
                    href="{{ route('admin.website.setting.terms_and_conditions') }}">
                    <i class="fa-solid fa-shield-halved ms-2"></i> Terms & Conditions
                </a>
            </li>
            @endif

            {{-- @if( Helper::hasAuthRolePermission('website_settings_website_popup') )
            <li class="nav-item mb-2">
                <a class="nav-link @yield('website_popup','')"
                    href="{{ route('admin.website.setting.website_popup') }}">
                    <i class="fa-solid fa-comment ms-2"></i> Website Popup
                </a>
            </li>
            @endif --}}

            @if( Helper::hasAuthRolePermission('website_settings_banner') )
            <li class="nav-item mb-2">
                <a class="nav-link @yield('banner','')"
                    href="{{ route('admin.website.setting.banner') }}">
                    <i class="fa-solid fa-image ms-2"></i> Banners
                </a>
            </li>
            @endif

        </ul>
    </div>
</div>
