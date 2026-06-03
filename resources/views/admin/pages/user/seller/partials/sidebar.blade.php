<div class="col-xxl-3 col-xl-3 col-lg-4 col-md-5 pb-4">

@php
    use App\Library\Helper;
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
                    <i class="fas fa-map-marker-alt"></i> {{ $user->location }}
                </p>
            </div>
            <div class="text-center mt-4 nav-tab">
                @if(Helper::hasAuthRolePermission('user_update_status'))
                <button
                    class="btn btn-sm mb-2 mr-2 change-status {{ $user->status != \App\Library\Enum::USER_STATUS_ACTIVE  ? 'btn-secondary tooltip-secondary' : 'btn2-secondary' }}"
                    onclick="clickUpdateStatus()" tooltip="Change Status">
                   
                    <i class="fas fa-power-off"></i>
                </button>
                @endif

                @if(Helper::hasAuthRolePermission('user_update_password'))
                <button class="btn btn-sm mb-2 mr-2 btn2-light-secondary change-pass"
                    onclick="bus.emit('common-update-password', {{ $user->id }})" tooltip="Change Password">
                    <i class="fas fa-key"></i> </button>
                @endif

                @if(Helper::hasAuthRolePermission('customer_update'))
                <a href="{{ route('admin.user.seller.update', $user->id) }}"
                    class="btn btn-sm btn-warning mb-2 mr-2 tooltip-warning " tooltip="Edit">
                    <i class="fas fa-edit"></i></a>
                @endif

                @if(Helper::hasAuthRolePermission('user_delete'))
                <button class="btn btn-sm mb-2 mr-2 btn-danger tooltip-danger" tooltip="Delete"
                    onclick="confirmFormModal('{{ route('admin.user.delete.api', $user->id) }}', 'Confirmation', 'Are you sure to delete operation?')">
                    <i class="fas fa-trash-alt"></i> </button>
                @endif
            </div>
        </div>
    </div><!-- End Client Info -->

    <!-- SideBar Start -->
    <div class="card mt-3">
        <div class="card-body">
            <ul class="nav nav-tabss nav-tabs-vertical" role="tablist">
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'show' ? 'active' : ''}}"
                        href="{{ route('admin.user.seller.show', $user->id) }}">
                        <i class="fa-solid fa-border-all ms-2 mr-1"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'details' ? 'active' : ''}}" href="{{ route('admin.user.seller.show.details', $user->id) }}">
                        <i class="fa-solid fa-user ms-2"></i> Details
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'store' ? 'active' : ''}}" href="{{ route('admin.user.seller.show.store', $user->id) }}">
                        <i class="fa-solid fa-store ms-2"></i> Store
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'banks' ? 'active' : ''}}" href="{{ route('admin.user.seller.show.banks', $user->id) }}">
                        <i class="fa-solid fa-store ms-2"></i> Bank Details
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Sidebar End -->
</div>
