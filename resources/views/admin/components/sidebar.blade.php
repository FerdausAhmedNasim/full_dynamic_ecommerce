@php
use App\Library\Helper;
@endphp

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.home.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        @if( Helper::hasAuthRolePermission('notification_index'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.notification.index') }}">
                <i class="icon-bell menu-icon"></i>
                <span class="menu-title">Notifications</span>
            </a>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('order_index'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.order.index') }}">
                <i class="fa-solid fa-bag-shopping menu-icon"></i>
                <span class="menu-title">Orders</span>
            </a>
        </li>
        @endif

        @if(Helper::hasAuthRolePermission('product_index') ||
            Helper::hasAuthRolePermission('review_index') ||
            Helper::hasAuthRolePermission('product_question_index') ||
            Helper::hasAuthRolePermission('product_alert_index')
        )
        <li class="nav-item">
            <a class="nav-link" href="#products" aria-controls="tables">
                <i class="fa-solid fa-cart-plus menu-icon"></i>
                <span class="menu-title">Products</span>
            </a>
            <div class="collapse" id="products">
                <ul class="nav flex-column sub-menu">
                    
                    @if(Helper::hasAuthRolePermission('product_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.product.index') }}">All Products</a>
                    </li>
                    @endif

                    @if(Helper::hasAuthRolePermission('review_index'))
                    <li class="nav-item"> 
                        <a class="nav-link" href="{{ route('admin.product.all_reviews') }}">Products Reviews</a>
                    </li>
                    @endif

                    @if(Helper::hasAuthRolePermission('product_question_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.product.question.all_questions') }}">Products Q & A</a>
                    </li>
                    @endif

                    @if(Helper::hasAuthRolePermission('product_alert_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.product.alert') }}">Products Alert</a>
                    </li>
                    @endif

                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('customer_index')
        || Helper::hasAuthRolePermission('employee_index'))

        <li class="nav-item">
            <a class="nav-link" href="#users" aria-controls="tables">
                <i class="fa-solid fa-users menu-icon"></i>
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="users">
                <ul class="nav flex-column sub-menu">

                    @if( Helper::hasAuthRolePermission('customer_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.user.customer.index') }}">Customers</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('employee_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.user.employee.index') }}">Employees</a>
                    </li>
                    @endif

                    {{-- @if( Helper::hasAuthRolePermission('seller_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.user.seller.index') }}">Sellers</a>
                    </li>
                    @endif --}}
                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('return_index') )
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.return.index') }}">
                <i class="fa-solid fa-rotate-left menu-icon"></i>
                <span class="menu-title">Return</span>
            </a>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('ticket_index')
        || Helper::hasAuthRolePermission('contact_us_index')
        )
        <li class="nav-item">
            <a class="nav-link" href="#support" aria-controls="tables">
                <i class="fa-solid fa-headset menu-icon"></i>
                <span class="menu-title">Support</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="support">
                <ul class="nav flex-column sub-menu">

                    @if( Helper::hasAuthRolePermission('ticket_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ticket.index') }}">Tickets</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('contact_us_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.contactUs.index') }}">Contact Us</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('subscriber_index') && false)
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.subscriber.index') }}">
                <i class="fa-brands fa-telegram menu-icon"></i>
                <span class="menu-title">Subscribers</span>
            </a>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('courier_pricing_plan_index') )
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.courier_pricing_plan.index') }}">
                <i class="fas fa-shipping-fast"></i>
                <span class="menu-title">Courier Pricing</span>
            </a>
        </li>
        @endif

        @if(Helper::hasAuthRolePermission('expense_index'))
        <li class="nav-item">
            <a class="nav-link" href="#accounts" aria-controls="tables">
                <i class="fa-solid fa-sack-dollar menu-icon"></i>
                <span class="menu-title">Accounts</span>
                <i class="menu-arrow"></i>
            </a>

            <div class="collapse" id="accounts">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('expense_index') )
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.expense.index') }}">Expenses</a>
                        </li>
                    @endif

                    {{-- @if( Helper::hasAuthRolePermission('withdraw_index') )
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.payout.index') }}">Payouts</a>
                        </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('withdraw_index') )
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.settlement.index') }}">Satelment</a>
                        </li>
                    @endif --}}
                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('ad_location_index') || Helper::hasAuthRolePermission('ad_index') || Helper::hasAuthRolePermission('coupon_index'))
        <li class="nav-item">
            <a class="nav-link" href="#advertisement" aria-controls="tables">
                <i class="fa-solid fa-users menu-icon"></i>
                <span class="menu-title">Advertisements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="advertisement">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('ad_location_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ad.location.index') }}">Ad Locations</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('ad_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ad.index') }}">
                           Advertise
                        </a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('coupon_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.coupon.index') }}">Coupon</a>
                    </li>
                    @endif

                </ul>
            </div>
        </li>
        @endif

        @if(Helper::hasAuthRolePermission('slider_index') ||
            Helper::hasAuthRolePermission('page_index') ||
            Helper::hasAuthRolePermission('website_settings_terms_and_conditions') ||
            Helper::hasAuthRolePermission('website_settings_banner')
        )
        <li class="nav-item">
            <a class="nav-link" href="#website" aria-controls="tables">
                <i class="fa-solid fa-earth-asia menu-icon"></i>
                <span class="menu-title">Website</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="website">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('slider_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.website.slider.index') }}"> Slider </a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('slider_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.website.video.index') }}"> Video </a>
                    </li>
                    @endif

                    {{-- @if( Helper::hasAuthRolePermission('benefit_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.website.benefit.index') }}"> Benefits </a>
                    </li>
                    @endif --}}

                    @if(Helper::hasAuthRolePermission('page_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.website.page.index') }}"> Pages </a>
                    </li>
                    @endif


                    {{-- @if( Helper::hasAuthRolePermission('website_settings_cookies') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.website.setting.cookies') }}"> Cookies </a>
                    </li>
                    @endif --}}

                    @if( Helper::hasAuthRolePermission('website_settings_terms_and_conditions') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.website.setting.terms_and_conditions') }}"> Terms & Conditions </a>
                    </li>
                    @endif
                    {{-- @if( Helper::hasAuthRolePermission('website_settings_website_popup') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.website.setting.website_popup') }}"> Website Popup </a>
                    </li>
                    @endif --}}

                    @if( Helper::hasAuthRolePermission('website_settings_banner') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.website.setting.banner') }}"> Banners </a>
                    </li>
                    @endif

                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('general_settings_show') ||
            Helper::hasAuthRolePermission('role_index') ||
            Helper::hasAuthRolePermission('dropdown_index') || 
            Helper::hasAuthRolePermission('division_index') || 
            Helper::hasAuthRolePermission('district_index') || 
            Helper::hasAuthRolePermission('thana_index') || 
            Helper::hasAuthRolePermission('area_index')
        )
        <li class="nav-item">
            <a class="nav-link" href="#settings" aria-controls="settings">
                <i class="fas fa-cogs menu-icon"></i>
                <span class="menu-title">Settings</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="settings">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('general_settings_show') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.general_settings.systemDetails') }}">General Settings</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('role_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.role.index', 'employee') }}"> Manage Roles </a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('dropdown_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.dropdown.menu') }}"> Dropdown List</a>
                    </li>
                    @endif

                    @if(Helper::hasAuthRolePermission('division_index') || 
                        Helper::hasAuthRolePermission('district_index') || 
                        Helper::hasAuthRolePermission('thana_index') || 
                        Helper::hasAuthRolePermission('area_index')
                    )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.area.settings.division') }}"> Area Settings</a>
                    </li>
                    @endif

                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('log_login_index') ||
            Helper::hasAuthRolePermission('log_activity_index') ||
            Helper::hasAuthRolePermission('log_email_index')
        )
        <li class="nav-item">
            <a class="nav-link" href="#footprints"
                aria-controls="footprints">
                <i class="fas fa-shoe-prints menu-icon"></i>
                <span class="menu-title">Foot Print</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="footprints">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('log_login_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.log.login.index') }}">Login History</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('log_activity_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.log.activity.index') }}">Activity Logs</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('log_email_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.log.email.index') }}">Email History</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('report_stock') ||
            Helper::hasAuthRolePermission('report_order') ||
            Helper::hasAuthRolePermission('report_user') ||
            Helper::hasAuthRolePermission('report_expense')
        )
        <li class="nav-item">
            <a class="nav-link" href="#reports" aria-controls="reports">
                <i class="fa-solid fa-chart-line menu-icon"></i>
                <span class="menu-title">Reports</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="reports">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('report_stock') )
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.report.stock') }}">Stock Reports</a>
                        </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('report_order') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.report.order') }}">Sales Reports</a>
                    </li>
                    @endif

                    {{-- @if( Helper::hasAuthRolePermission('report_order') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.report.seller.order') }}">Seller Sales Reports</a>
                    </li>
                    @endif --}}

                    @if( Helper::hasAuthRolePermission('report_expense') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.report.expense') }}">Expense Reports</a>
                    </li>
                    @endif

                    {{-- @if( Helper::hasAuthRolePermission('report_withdraw') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.report.settlements') }}">Settlement Reports</a>
                    </li>
                    @endif --}}

                    @if( Helper::hasAuthRolePermission('report_user') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.report.users') }}">User Reports</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('report_profit') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.report.profit') }}">Profit Reports</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif
    </ul>
</nav>
