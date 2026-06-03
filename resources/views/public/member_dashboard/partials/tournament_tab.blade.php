<style>

    .nav-tabs {
        border: 0;
        padding: 15px 0;
    }

    .nav-tabs:not(.nav-tabs-neutral)>.nav-item>.nav-link.active {
        box-shadow: 0px 5px 35px 0px rgba(0, 0, 0, 0.3);
    }

    .card .nav-tabs {
        border-top-right-radius: 0.1875rem;
        border-top-left-radius: 0.1875rem;
    }

    .nav-tabs>.nav-item>.nav-link {
        color: #1c3263;
        margin: 0;
        margin-right: 5px;
        background-color: transparent;
        border: 1px solid #1c3263;
        border-radius: 30px;
        font-size: 14px;
        padding: 11px 23px;
        line-height: 1.5;
    }

    .nav-tabs>.nav-item>.nav-link:hover {
        background-color: #1c3263;
        color: white;
    }

    .nav-tabs>.nav-item>.nav-link.active {
        background-color: #1c3263;
        border-radius: 30px;
        color: #FFFFFF;
    }

    .nav-tabs>.nav-item>.nav-link i {
        font-size: 14px;
        position: relative;
        top: 1px;
        margin-right: 3px;
    }

    .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link {
        color: #FFFFFF;
    }

    .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link.active {
        background-color: #1c3263;
        color: #FFFFFF;
    }

    .tab-card {
        border: 0;
        border-radius: 0.1875rem;
        display: inline-block;
        position: relative;
        width: 100%;
    }

    .tab-card .card-header {
        background-color: transparent;
        border-bottom: 0;
        background-color: transparent;
        border-radius: 0;
        padding: 0;
    }
</style>
<div class="card tab-card">
    <div class="card-header">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link @yield('current','') " href="{{ route('member.dashboard.tournament.current') }}">
                    <i class="fas fa-person-running"></i> Current
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @yield('upcoming','') " href="{{ route('member.dashboard.tournament.upcoming') }}">
                <i class="fa-solid fa-angles-right"></i> Upcoming
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @yield('history','') " href="{{ route('member.dashboard.tournament.history') }}">
                    <i class="fas fa-timeline"></i> History
                </a>
            </li>
        </ul>
    </div>
</div>
<hr>