@extends('public.layout.master')
@section('title', 'Cart')
@section('content')

<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="index.html">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>

                            <li class="breadcrumb-item active">Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->


<!-- Cart Section Start -->
<section class="cart-section section-b-space">
    <div class="container-fluid-lg itemNotFound">

        @if(count($carts) > 0)
        <div class="row g-sm-5 g-3 cartItemSection">
            <div class="col-xxl-9">
                <div class="cart-table shadow-lg rounded-3" style="border: 1px solid #d4d4d4;">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                @foreach ($carts as $cartItem)
                                <tr class="product-box-contain cartItems">
                                    <td class="product-detail">
                                        <div class="product border-0">
                                            <a href="#" class="product-image">
                                                <img src="{{ $cartItem->product->getThumbnailImage() }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>
                                            <div class="product-detail">
                                                <ul>
                                                    <li class="name m-0">
                                                        <a class="d-none d-md-block" href="{{ route('public.product.show', $cartItem->product->slug) }}"
                                                            title="{{ $cartItem->product->getTranslation('title') }}">{{
                                                            $cartItem->product->getTranslation('short_title') }}</a>
                                                        <a class="d-md-none" href="{{ route('public.product.show', $cartItem->product->slug) }}"
                                                            title="{{ $cartItem->product->getTranslation('title') }}">{{
                                                            $cartItem->product->getTranslation('mobile_short_title') }}</a>
                                                    </li>

                                                    @if ($cartItem->variant)
                                                        <li class="text-content">
                                                            <small>{{ getProductVariantValue($cartItem->variant) }}</small>
                                                        </li>
                                                    @endif

                                                    <input type="hidden" name="cart_id" class="cart_id"
                                                        value="{{ $cartItem->id }}">
                                                    <input type="hidden" name="product_id" class="product_id"
                                                        value="{{ $cartItem->product_id }}">
                                                    <input type="hidden" name="user_id" class="user_id" value="{{ authUser()?->id }}">
                                                </ul>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="price">
                                        <h4 class="table-title text-content">Price</h4>
                                        <h5>{{
                                            getFormattedAmount($cartItem->product->calculatePriceAfterDiscount($cartItem->price)
                                            - $cartItem->ezzico_discount) }}</h5>
                                        @if ($cartItem->product->has_discount)
                                        <del class="text-content">{{ getFormattedAmount($cartItem->price) }}</del>
                                        @endif

                                        <input type="hidden" class="cart-price" value="{{ $cartItem->price }}">

                                        @if ($cartItem->product->has_discount)
                                        <h6 class="theme-color">Save :
                                            {{ getFormattedAmount($cartItem->price -
                                            $cartItem->product->calculatePriceAfterDiscount($cartItem->price) +
                                            $cartItem->ezzico_discount) }}
                                        </h6>
                                        @endif
                                    </td>

                                    <td class="quantity">
                                        <h4 class="table-title text-content">Qty</h4>
                                        <div class="quantity-price">
                                            <div class="cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus ms-0"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="{{ $cartItem->quantity }}">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus ms-0"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="price" class="unitPrice"
                                            value="{{ $cartItem->product->calculatePriceAfterDiscount($cartItem->price) - $cartItem->ezzico_discount }}">
                                        <input type="hidden" name="current_stock" class="current_stock"
                                            value="{{ $cartItem->product->current_stock }}">
                                    </td>

                                    @php
                                    $itemSubTotal = $cartItem->product->calculatePriceAfterDiscount($cartItem->price) *
                                    $cartItem->quantity - $cartItem->quantity * $cartItem->ezzico_discount;
                                    @endphp

                                    <td class="subtotal">
                                        <h4 class="table-title text-content mb-1">Total</h4>
                                        <h5 class="item-total">
                                            {{ getFormattedAmount($itemSubTotal) }}
                                        </h5>
                                        <div>
                                            @if ($cartItem->quantity <= $cartItem->product->current_stock)
                                                <h6 class="text-success mt-2">In Stock</h6>
                                                <input type="hidden" name="isStockOut" class="isStockOut" value="0">
                                                @else
                                                <h6 class="text-danger mt-2">Stock Out</h6>
                                                <input type="hidden" name="isStockOut" class="isStockOut" value="1">
                                                @endif
                                        </div>
                                    </td>

                                    <td class="save-remove">
                                        <h4 class="table-title text-content">Action</h4>
                                        <div>
                                            @php
                                                $wishlist = authUser()?->wishlist()->where('product_id', $cartItem->product_id)->first();
                                            @endphp
                                            <button class="btn p-0 text-sm wishlist btn-wishlist {{$wishlist ? 'text-danger delete-wishlist' : ''}}">
                                                <i class="iconly-Heart icli"></i>
                                            </button>
                                        </div>
                                        <button class="remove btn p-0 text-sm text-danger mt-2"
                                            data-cart-item-id="{{ $cartItem->id }}"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3">
                <div class="summery-box p-sticky">
                    <div class="summery-header">
                        <h3>Cart Total</h3>
                    </div>

                    <div class="summery-contain">
                        <ul>
                            <li class="subtotal">
                                <h4>Subtotal</h4>
                                <h4 class="price">৳0.00</h4>
                            </li>
                            <li class="align-items-start shipping">
                                <h4>Shipping</h4>
                                <h4 class="price text-end">৳0.00</h4>
                            </li>
                        </ul>
                    </div>

                    <ul class="summery-total">
                        <li class="list-total border-top-0 cartTotal">
                            <h4>Total</h4>
                            <h4 class="price theme-color">৳0.00</h4>
                        </li>
                    </ul>

                    <div class="button-group cart-button">
                        <ul>
                            <li>
                                <button id="checkoutButton"
                                    class="btn btn-animation proceed-btn theme-bg-color fw-bold {{ count($carts) > 0 && $cartItem->quantity <= $cartItem->product->current_stock ? '' : 'disabled' }}">Process
                                    To Checkout</button>
                            </li>

                            <li>
                                <button onclick="location.href = '/';" class="btn btn-light shopping-button text-dark">
                                    <i class="fa-solid fa-arrow-left-long"></i>Return To Shopping
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row g-sm-5 g-3">
            <div class="col-xxl-12">
                <div class="text-center">
                    <p>There are no items in this cart</p>

                    <a class="shopping-button" href="{{ route('public.home') }}">
                        <button class="btn btn-light text-dark ">
                            Continue Shopping
                        </button>
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>
</section>
<!-- Cart Section End -->

@endsection

@push('scripts')
@vite('resources/frontend_assets/js/pages/cart/cart.js')
@endpush


@push('styles')
<style>
    .shopping-button {
        display: inline-block;
    }

    .shopping-button .btn {
        /* width: 100%; */
        color: #000;
        font: inherit;
        cursor: pointer;
        letter-spacing: 0.04em;
        background-color: #ececec;
        font-size: calc(13px + (14 - 13) * ((100vw - 320px) / (1920 - 320)));
        padding: calc(8px +(12 - 8)*((100vw - 320px) /(1920 - 320))) calc(14px +(20 - 14)*((100vw - 320px) /(1920 - 320)));
    }
</style>
@endpush
