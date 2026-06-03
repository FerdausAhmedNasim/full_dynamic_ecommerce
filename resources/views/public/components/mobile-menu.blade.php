<div class="mobile-menu d-md-none d-block mobile-cart">
        <ul>
            <li class="active">
                <a href="{{ url('/') }}">
                    <i class="iconly-Home icli"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="mobile-category">
                <a href="javascript:void(0)">
                    <i class="iconly-Category icli js-link"></i>
                    <span>Category</span>
                </a>
            </li>
            @auth
            <li>
                <a href="{{ route('public.wishlist.index') }}" class="notifi-wishlist">
                    <i class="iconly-Heart icli"></i>
                    <span>My Wish</span>
                </a>
            </li>
            @endguest

            <li>
                <a href="{{ route('checkout') }}">
                    <i class="iconly-Bag-2 icli fly-cate"></i>
                    <span>Cart</span>
                </a>
            </li>
        </ul>
    </div>