@extends('public.layout.master')
@section('title', 'Checkout')
@section('content')

    <!-- Breadcrumb Section Start -->
    {!! \App\Library\Html::breadcrumbsSection('Order Confirmation') !!}
    <!-- Breadcrumb Section End -->

    <!-- Cart Section Start -->
    <section class="cart-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-sm-4 g-3">
                <div class="col-xxl-9 col-lg-8">
                    <div class="cart-table order-table order-table-2">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>

                                    @php
                                        $subTotal = 0;
                                        $couponDiscount = $order->sellerOrders->sum('discount_amount');
                                        $totalItem = 0;
                                    @endphp

                                    @foreach ($order->sellerOrders as $sellerOrder)

                                    @php
                                        $countItem = $sellerOrder->sellerOrderDetails->count();
                                        $totalItem += $countItem;
                                    @endphp

                                        @foreach ($sellerOrder->sellerOrderDetails as $detail)
                                            <tr>
                                                <td class="product-detail">
                                                    <div class="product border-0">
                                                        <a href="product.left-sidebar.html" class="product-image">
                                                            <img src="{{ $detail->product->getThumbnailImage() }}"
                                                                class="img-fluid blur-up lazyload" alt="">
                                                        </a>
                                                        <div class="product-detail">
                                                            <ul>
                                                                <li class="name">
                                                                    <a href="{{ route('public.product.show', $detail->product->slug) }}">{{ $detail->product->getTranslation('short_title') }}</a>
                                                                    @if ($detail?->load('productStock')?->productStock?->variant_ids)
                                                                        <br> <small>{{ getProductVariantValue($detail?->load('productStock')?->productStock?->variant_ids) }}</small>
                                                                    @endif
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="price">
                                                    <h4 class="table-title text-content">Price</h4>
                                                    <h6 class="theme-color">{{ getFormattedAmount($detail->sale_price) }}</h6>
                                                </td>

                                                <td class="quantity">
                                                    <h4 class="table-title text-content">Qty</h4>
                                                    <h4 class="text-title">{{ $detail->quantity }}</h4>
                                                </td>

                                                <td class="subtotal">
                                                    <h4 class="table-title text-content">Total</h4>
                                                    <h5>{{ getFormattedAmount($detail->sale_price * $detail->quantity) }}</h5>
                                                </td>
                                            </tr>

                                            @php
                                                $subTotal += $detail->sale_price * $detail->quantity;
                                            @endphp

                                        @endforeach

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-lg-4">
                    <div class="row g-4">
                        <div class="col-lg-12 col-sm-6">
                            <div class="summery-box">
                                <div class="summery-header">
                                    <h3>Price Details</h3>
                                    <h5 class="ms-auto theme-color">({{ $totalItem }} Items)</h5>
                                </div>

                                <ul class="summery-contain">
                                    <li>
                                        <h4>Subtotal</h4>
                                        <h4 class="price">{{ getFormattedAmount($subTotal) }}</h4>
                                    </li>

                                    <li>
                                        <h4>Shipping Cost</h4>
                                        <h4 class="price text-danger">{{ getFormattedAmount($order->shipping_cost) }}</h4>
                                    </li>

                                    @if ($order->penalty_amount > 0)
                                        <li>
                                            <h4>Penalty Amount</h4>
                                            <h4 class="price text-danger">{{ getFormattedAmount($order->penalty_amount) }}</h4>
                                        </li>
                                    @endif

                                    <li>
                                        <h4>Coupon Discount</h4>
                                        <h4 class="price theme-color">{{ getFormattedAmount($couponDiscount) }}</h4>
                                    </li>
                                </ul>

                                <ul class="summery-total">
                                    <li class="list-total">
                                        <h4>Total</h4>
                                        <h4 class="price">{{ getFormattedAmount($subTotal + $order->shipping_cost + $order->penalty_amount - $couponDiscount) }}</h4>
                                    </li>
                                </ul>

                                @if($order->collected_amount > 0)
                                <ul class="summery-total">
                                    <li class="list-total">
                                        <h5>Paid Amount</h5>
                                        <h5 class="ms-auto price theme-color">{{ getFormattedAmount($order->collected_amount) }}</h5>
                                    </li>
                                </ul>

                                <ul class="summery-total">
                                    <li class="list-total">
                                        <h5>Due Amount</h5>
                                        <h5 class="ms-auto price text-danger">{{ getFormattedAmount($order->amount_to_be_collect) }}</h5>
                                    </li>
                                </ul>
                                @endif
                                
                            </div>
                        </div>

                        <div class="col-lg-12 col-sm-6">
                            <div class="summery-box">
                                <div class="summery-header d-block">
                                    <h3>Shipping Address</h3>
                                </div>

                                <ul class="summery-contain pb-2 border-bottom-0">
                                    <li class="d-block">
                                        <h4>{{ $order?->order_person_address }}</h4>
                                    </li>

                                    {{-- <li class="pb-0">
                                        <h4>Expected Date Of Delivery</h4>
                                    </li> --}}
                                </ul>

                                {{-- <ul class="summery-total">
                                    <li class="list-total border-top-0 pt-2">
                                        <h4 class="fw-bold">Oct 21, 2021</h4>
                                    </li>
                                </ul> --}}
                            </div>
                        </div>

                        {{-- <div class="col-12">
                            <div class="summery-box">
                                <div class="summery-header d-block">
                                    <h3>Payment Method</h3>
                                </div>

                                <ul class="summery-contain pb-0 border-bottom-0">
                                    <li class="d-block pt-0">
                                        <p class="text-content">Pay on Delivery (Cash/Card). Cash on delivery (COD)
                                            available. Card/Net banking acceptance subject to device availability.</p>
                                    </li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Cart Section End -->


@endsection

@push('scripts')

@endpush

@push('styles')

    <style>
        .product-detail {
            text-align: left;
        }
    </style>

@endpush
