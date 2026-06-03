@php
    use App\Library\Helper;
    $urlArray = url()->full();
    $segments = explode('/', $urlArray);
    $numSegments = count($segments);
    $currentSegment = $segments[$numSegments - 1];
@endphp

<div class="col-xxl-3 col-xl-3 col-lg-4 col-md-5 pb-4">
    <!-- SideBar Start -->
    <div class="card shadow-sm">
        <div class="card-body">
            <ul class="nav nav-tabss nav-tabs-vertical" role="tablist">

                @if(Helper::hasAuthRolePermission('general_settings_show'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'system-details' ? 'active' : ''}}"
                        href="{{ route('admin.config.general_settings.systemDetails') }}">
                        <i class="fa-solid fa-border-all ms-2 mr-1"></i> System Details
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('general_settings_show'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'address' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.address') }}">
                        <i class="fa-solid fa-location-dot ms-2 mr-1"></i> Address
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('general_settings_show'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'communication' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.communication') }}">
                        <i class="fa-solid fa-paper-plane ms-2 mr-1"></i> Communication
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('general_settings_show'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'multimedia' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.multimedia') }}">
                        <i class="fa-solid fa-images ms-2 mr-1"></i> Multimedia
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('general_settings_show'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'date-time' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.date_time') }}">
                        <i class="fa-solid fa-calendar-days ms-2 mr-1"></i> Date & Time
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('general_settings_show'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'currency' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.currency') }}">
                        <i class="fa-solid fa-coins ms-2 mr-1"></i> Currency
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('general_settings_show'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'pos-settings' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.pos_settings') }}">
                        <i class="fa-solid fa-gear ms-2 mr-1"></i> Invoice Settings
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('social_link_show'))
                <li class="nav-item mb-2">
                    <a class="nav-link @yield('social','')"
                    href="{{ route('admin.config.general_settings.social.link') }}">
                    <i class="fa-sharp fa-solid fa-link ms-2"></i> Social Links
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('email_settings_show'))
                <li class="nav-item mb-2">
                    <a class="nav-link @yield('email_settings','')"
                    href="{{ route('admin.config.general_settings.email.settings') }}">
                    <i class="fa-sharp fa-solid fa-envelope ms-2 mr-1"></i> Email Settings
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('email_template_index'))
                <li class="nav-item mb-2">
                    <a class="nav-link @yield('email_template','')"
                    href="{{ route('admin.config.more_settings.email_template.index') }}">
                    <i class="fa-sharp fa-solid fa-envelope-open-text ms-2 mr-1"></i> Email Templates
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('email_signature_index'))
                <li class="nav-item mb-2">
                    <a class="nav-link @yield('email_signature','')"
                    href="{{ route('admin.config.more_settings.email_signature.index') }}">
                    <i class="fa-solid fa-signature ms-2"></i> Email Signature
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('general_settings_show'))
                <li class="nav-item mb-2">
                    <a class="nav-link @yield('preference','')"
                    href="{{ route('admin.config.general_settings.preference') }}">
                    <i class="fa-solid fa-shield-halved ms-2 mr-1"></i> Preference
                    </a>
                </li>
                @endif

                {{-- <li class="nav-item mb-2">
                    <a class="nav-link @yield('settlement','')"
                    href="{{ route('admin.config.general_settings.settlement') }}">
                    <i class="fa-solid fa-shield-halved ms-2 mr-1"></i> Settlement
                    </a>
                </li> --}}

                @if(Helper::hasAuthRolePermission('general_settings_show'))
                <li class="nav-item mb-2">
                    <a class="nav-link @yield('courier','')" href="{{ route('admin.config.general_settings.courier') }}">
                        <i class="fas fa-shipping-fast ms-2"></i> Courier
                    </a>
                </li>
                @endif
               
                @if(Helper::hasAuthRolePermission('pickup_hub_index'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'pickup-hub' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.pickup_hub.index') }}">
                    <i class="fa-solid fa-shield-halved"></i> Pickup Hub
                    </a>
                </li>
                @endif

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'shipping-cost' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.shipping_cost') }}">
                    <i class="fa-solid fa-money-bill"></i> Shipping Cost
                    </a>
                </li>

                @if(Helper::hasAuthRolePermission('backend_color_index'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'backend-color' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.backend.color') }}">
                    <i class="fa-solid fa-palette"></i> Backend Color Settings
                    </a>
                </li>
                @endif
                @if(Helper::hasAuthRolePermission('frontend_color_index'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'frontend-color' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.frontend.color') }}">
                    <i class="fa-solid fa-palette"></i> Frontend Color Settings
                    </a>
                </li>
                @endif

            </ul>
        </div>
    </div>
    <!-- Sidebar End -->
</div>
