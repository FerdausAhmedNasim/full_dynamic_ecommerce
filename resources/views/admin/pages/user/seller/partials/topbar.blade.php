@php
    use App\Library\Helper;
@endphp

<div class="card-body py-sm-4">
    <ul class="nav nav-tab" role="tablist">
        <li class="nav-item">
            <a  class="nav-link @yield('details','')" href="{{ route('admin.user.seller.show', $user->id??'') }}">
                <i class="fa-solid fa-circle-info"></i> Details
            </a>
        </li>

        <li class="nav-item">
            <a  class="nav-link @yield('products','')"  href="{{ route('admin.user.seller.product.index', $user->id??'') }}">
                <i class="fa-solid fa-basket-shopping"></i> Products
            </a>
        </li>

        <li class="nav-item">
            <a  class="nav-link @yield('orders','')"  href="{{ route('admin.user.seller.order.index', $user->id??'') }}">
                <i class="fa-solid fa-bag-shopping"></i> Orders
            </a>
        </li>
{{--
        <li class="nav-item">
            <a  class="nav-link @yield('accounts','')"  href="#">
                <i class="fa-solid fa-money-check-dollar"></i> Accounts
            </a>
        </li> --}}

        <li class="nav-item">
            <a  class="nav-link @yield('notes','')"  href="{{ route('admin.user.seller.note.index', $user->id??'') }}">
                <i class="fa-solid fa-clipboard"></i> Notes
            </a>
        </li>

        <li class="nav-item">
            <a  class="nav-link @yield('sellerCategory','')"  href="{{ route('admin.user.seller.category.index', $user->id??'') }}">
                <i class="fa-solid fa-tag"></i> Product Category
            </a>
        </li>

        <li class="nav-item">
            <a  class="nav-link @yield('sendMoney','')"  href="{{ route('admin.user.seller.send.money.index', $user->id??'') }}">
                <i class="fa-solid fa-money-check-dollar"></i> Send Money
            </a>
        </li>

        <li class="nav-item">
            <a  class="nav-link @yield('receiveMoney','')"  href="{{ route('admin.user.seller.receive.money.index', $user->id??'') }}">
                <i class="fa-solid fa-money-check-dollar"></i> Top Up Money
            </a>
        </li>

        <li class="nav-item">
            <a  class="nav-link @yield('balanceHistory','')"  href="{{ route('admin.user.seller.balance.history', $user->id??'') }}">
                <i class="fa-solid fa-money-check-dollar"></i> Balance History
            </a>
        </li>
    </ul>
</div>
