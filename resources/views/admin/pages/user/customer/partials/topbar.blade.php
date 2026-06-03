@php
    use App\Library\Helper;

    $urlArray = url()->full();
    $segments = explode('/', $urlArray);
    $numSegments = count($segments);
    $currentSegmentt = $segments[$numSegments - 1];
    // dd($currentSegmentt);
@endphp

<div class="card-body py-sm-4">
    <ul class="nav nav-tab" role="tablist">
        @if(Helper::hasAuthRolePermission('customer_show'))
        <li class="nav-item">
            <a  class="nav-link {{ ($currentSegmentt === 'show' || $currentSegmentt === 'details') ? 'active' : ''}}"  href="{{ route('admin.user.customer.show', $user->id) }}">
                <i class="fa-solid fa-circle-info"></i> Details
            </a>
        </li>
        @endif

        @if(Helper::hasAuthRolePermission('customer_orders'))
        <li class="nav-item">
            <a  class="nav-link {{ ($currentSegmentt === 'orders' || $currentSegmentt === 'detail') ? 'active' : ''}}"  href="{{ route('admin.user.customer.order', $user->id) }}">
                <i class="fa-solid fa-bag-shopping"></i> Orders
            </a>
        </li>
        @endif

    </ul>
</div>
