@php
    use App\Library\Helper;

    $urlArray = url()->full();
    $segments = explode('/', $urlArray);
    $numSegments = count($segments);
    $currentSegmentt = $segments[$numSegments - 1];

@endphp

<div class="card-body py-sm-4">
    <ul class="nav nav-tab" role="tablist">

        @if(Helper::hasAuthRolePermission('ticket_my_ticket'))
        <li class="nav-item">
            <a  class="nav-link {{ $currentSegmentt === 'my-tickets' ? 'active' : ''}}" href="{{ route('admin.ticket.index') }}">
                <i class="fa-solid fa-circle-info"></i> My Ticket
            </a>
        </li>
        @endif

        @if(Helper::hasAuthRolePermission('ticket_all_ticket'))
        <li class="nav-item notes">
            <a class="nav-link {{ $currentSegmentt === 'all-tickets' ? 'active' : ''}}" href="{{ route('admin.ticket.all') }}">
                <i class="fas fa-notes-medical"></i> All Ticket
            </a>
        </li>
        @endif

    </ul>
</div>
