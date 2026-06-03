@php
    use App\Library\Helper;
@endphp
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('seller.home.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        @if( Helper::hasAuthRolePermission('seller_notification_index'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('seller.notification.index') }}">
                <i class="icon-bell menu-icon"></i>
                <span class="menu-title">Notifications</span>
            </a>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('seller_order_index'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('seller.order.index') }}">
                <i class="fa-solid fa-cart-plus menu-icon"></i>
                <span class="menu-title">Orders</span>
            </a>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('seller_product_index'))
        <li class="nav-item">
            <a class="nav-link" href="#products" aria-controls="tables">
                <i class="fas fa-computer menu-icon"></i>
                <span class="menu-title">Products</span>
            </a>
            <div class="collapse" id="products">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.product.index') }}">All Products</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.product.all_reviews') }}">Products Reviews</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.product.alert') }}">Products Alert</a>
                    </li>

                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('seller_moderator_index'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('seller.return.index') }}">
                <i class="fa-solid fa-rotate-left menu-icon"></i>
                <span class="menu-title">Return</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('seller.moderator.index') }}">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-title">Moderators</span>
            </a>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('seller_ticket_index'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('seller.ticket.index') }}">
                <i class="far fa-envelope menu-icon"></i>
                <span class="menu-title">Tickets</span>
            </a>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('seller_ad_request_index'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('seller.ad.index') }}">
                <i class="fa-solid fa-cart-flatbed-suitcase menu-icon"></i>
                <span class="menu-title">Advertise</span>
            </a>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('seller_coupon_index'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('seller.coupon.index') }}">
                <i class="fa-solid fa-money-check-dollar menu-icon"></i>
                <span class="menu-title">Coupon</span>
            </a>
        </li>
        @endif

        @if ( Helper::hasAuthRolePermission('seller_bank_account_index') ||
                Helper::hasAuthRolePermission('seller_payout_index'))
        <li class="nav-item">
            <a class="nav-link" href="#settings" aria-controls="settings">
                <i class="fa-solid fa-dollar-sign"></i>
                <span class="menu-title">Accounts</span>
            </a>
            <div class="collapse" id="settings">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('seller_bank_account_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.bankAccount.index') }}">Bank Account</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('seller_payout_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.payout.index') }}">Payout Request</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('seller_payout_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.settlement.index') }}">Settlements</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('seller_payout_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.balance.history') }}">Balance History</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('seller_role_index'))
        <li class="nav-item">
            <a class="nav-link" href="#settings" aria-controls="settings">
                <i class="fas fa-cogs menu-icon"></i>
                <span class="menu-title">Settings</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="settings">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.config.general_settings.index') }}">General Settings</a>
                    </li>

                    @if( Helper::hasAuthRolePermission('seller_role_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.config.role.index') }}">Manage Roles</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('seller_role_index') ||
            Helper::hasAuthRolePermission('seller_role_index') ||
            Helper::hasAuthRolePermission('seller_role_index') ||
            Helper::hasAuthRolePermission('seller_role_index') ||
            Helper::hasAuthRolePermission('seller_role_index')
        )
        <li class="nav-item">
            <a class="nav-link" href="#reports" aria-controls="reports">
                <i class="fa-solid fa-chart-line menu-icon"></i>
                <span class="menu-title">Reports</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="reports">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('seller_role_index'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('seller.report.stock') }}">Stock Reports</a>
                        </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('seller_role_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.report.order') }}">Sale Reports</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('seller_role_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.report.settlements') }}">Settlement Reports</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif
    </ul>
</nav>


