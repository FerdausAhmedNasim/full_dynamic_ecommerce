@php
    use App\Library\Helper;
    $urlArray = url()->full();
    $segments = explode('/', $urlArray);
    $numSegments = count($segments);

    if ($numSegments == 6) {
        $currentSegment = $segments[$numSegments - 2];
    } else if ($numSegments == 7) {
        $currentSegment = $segments[$numSegments - 3];
    } else {
        $currentSegment = $segments[$numSegments - 1];
    }

@endphp

<div class="col-xxl-3 col-xl-3 col-lg-4 col-md-5 pb-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <ul class="nav nav-tabss nav-tabs-vertical" role="tablist">

                @if(Helper::hasAuthRolePermission('division_index'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'division' ? 'active' : ''}}"
                        href="{{ route('admin.area.settings.division') }}">
                        <i class="fa-solid fa-location-dot ms-2 mr-1"></i> Division
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('district_index'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'district' ? 'active' : ''}}"
                    href="{{ route('admin.area.settings.district') }}">
                        <i class="fa-solid fa-location-dot ms-2 mr-1"></i> District 
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('thana_index'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'thana' ? 'active' : ''}}"
                    href="{{ route('admin.area.settings.thana.index') }}">
                    <i class="fa-solid fa-location-dot ms-2 mr-1"></i> Thana
                    </a>
                </li>
                @endif

                @if(Helper::hasAuthRolePermission('area_index'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'area' ? 'active' : ''}}"
                    href="{{ route('admin.area.settings.area.index') }}">
                        <i class="fa-solid fa-location-dot ms-2 mr-1"></i> Area
                    </a>
                </li>
                @endif

            </ul>
        </div>
    </div>
</div>
