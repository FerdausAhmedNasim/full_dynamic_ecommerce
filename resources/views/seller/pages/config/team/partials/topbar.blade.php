<div class="card-body py-sm-4">
    <ul class="nav nav-tab" role="tablist">
        <li class="nav-item">
            <a  class="nav-link @yield('team','')"  href="{{ route('admin.team.show', $team->id) }}">
                <!-- <div class="tooltip">Details</div> -->
                <i class="fa-solid fa-circle-info"></i> Details
            </a>
        </li>

        <li class="nav-item notes">
            <a class="nav-link @yield('team_member','')"  href="{{ route('admin.team.member', $team->id) }}">
                <!-- <div class="tooltip">Enrollment</div> -->
                <i class="fas fa-users"></i> Team Member
            </a>
        </li>

    </ul>
</div>
