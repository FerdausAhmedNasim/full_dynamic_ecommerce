<div class="col-xxl-3 col-xl-3 col-lg-5 col-md-6 pb-4">

@php
$urlArray = url()->full();
$segments = explode('/', $urlArray);
$numSegments = count($segments);
$currentSegment = $segments[$numSegments - 1];
@endphp

    <!-- Client Info -->
    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <div class="border-bottom text-center pb-2">
                <div class="mb-3">
                    <h3>{{ $user?->full_name }}</h3>
                </div>
                <p class="mx-auto mb-2">
                    <i class="fas fa-map-marker-alt"></i> {{ $member?->user?->location }}
                </p>
            </div>
        </div>
    </div><!-- End Client Info -->

    <!-- SideBar Start -->
    <div class="card mt-3">
        <div class="card-body">
            <ul class="nav nav-tabss nav-tabs-vertical" role="tablist">
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'show' ? 'active' : ''}}"
                        href="{{ route('seller.member.show', $member->id) }}">
                        <i class="fa-solid fa-border-all ms-2 mr-1"></i> Dashboard
                    </a>
                </li>

                @if(false)
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'details' ? 'active' : ''}}"
                    href="{{ route('seller.member.show.details', $member->id) }}">
                        <i class="fa-solid fa-user ms-2"></i> Details
                    </a>
                </li>
                @endif

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'address' ? 'active' : ''}}"
                    href="{{ route('seller.member.show.address', $member->id) }}">
                        <i class="fa-solid fa-location-dot ms-2"></i> Address
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'contact' ? 'active' : ''}}"
                    href="{{ route('seller.member.show.contact', $member->id) }}">
                        <i class="fa-solid fa-address-book ms-2"></i> Emergency Contact
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'client_alert' ? 'active' : ''}}"
                    href="{{ route('seller.member.show.alert', $member->id) }}">
                        <i class="fa-solid fa-triangle-exclamation ms-2"></i> Alert
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'household' ? 'active' : ''}}"
                    href="{{ route('seller.member.show.household', $member->id) }}">
                        <i class="fa-solid fa-house-chimney-window ms-2"></i> Household
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'health' ? 'active' : ''}}"
                    href="{{ route('seller.member.show.health', $member->id) }}">
                        <i class="fas fa-heartbeat"></i> Health
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <!-- Sidebar End -->
</div>
