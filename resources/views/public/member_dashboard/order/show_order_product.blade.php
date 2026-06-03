@extends('public.member_dashboard.dashboard_master')

@section('title', 'Order Products')

@section('order', 'active')

@section('member_content')
@php
use \App\Library\Enum;
@endphp
<div class="dashboard-order">
    <div class="title">
        <h2>Order Products</h2>
        <span class="title-leaf title-leaf-gray">
            <svg class="icon-width bg-gray">
                <use xlink:href="{{ asset('frontend/svg/leaf.svg') }}#leaf"></use>
            </svg>
        </span>
    </div>

    @if($order->order_status == \App\Library\Enum::ORDER_STATUS_TYPE_PENDING)
        <div class="d-flex justify-content-end ">
            <a href="{{ route('dashboard.order.cancel', $order->id) }}" class="btn btn-animation btn-sm">Cancel Order</a>
        </div>
    @endif

    <div class="cart-table order-table order-table-2">
    <div class="accordion accordion-box ">
        @php
            $order_product_qty = 0;
        @endphp
        @foreach($order->sellerOrders as $key => $sellerOrder)

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button">
                        {{ $sellerOrder?->store?->getTranslation('store_name') }}
                        <span class="text-capitalize">Status : {{ str_replace('_', ' ', $sellerOrder->order_status) }}</span>
                    </button>
                </h2>
                <div class="accordion-collapse collapse show"
                    aria-labelledby="panelsStayOpen-heading{{$key}}">
                    <div class="accordion-body">
                        <div class="cart-table order-table">

                            <div class="table-responsive">
                                <table class="table mb-0 order-table-{{$sellerOrder->id}}">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sub_qty = $unit_price = $sub_total = $total = 0;
                                        @endphp

                                        @foreach ($sellerOrder->sellerOrderDetails->load('product', 'sellerOrder.seller') as $orderDetails)
                                        @php
                                           // dd($orderDetails);
                                            $sub_qty = $orderDetails->quantity;
                                            $order_product_qty +=$sub_qty;
                                            //$unit_price = $orderDetails->product->unit_price;
                                            $unit_price = $orderDetails->sale_price;
                                            $sub_total = $sub_qty*$unit_price;
                                            $total += $sub_total;
                                        @endphp
                                        <tr  class="parent-row">
                                            <td class="product-detail">
                                                <div class="product border-0">
                                                    <div class="product-image">
                                                        <img src="{{$orderDetails->product->getThumbnailImage()}}"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </div>
                                                    <div class="product-detail">
                                                        <ul>
                                                            <li class="text-start">
                                                                {{$orderDetails->product->getTranslation("short_title")}}

                                                                @if ($orderDetails?->load('productStock')?->productStock?->variant_ids)
                                                                    <br> <small>{{ getProductVariantValue($orderDetails?->productStock?->variant_ids) }}</small>
                                                                @endif
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="">
                                                <h4 class="text-title">{{$sub_qty}}</h4>
                                            </td>

                                            <td class="price">
                                                <h6 class="theme-color">{{getFormattedAmount($unit_price)}}</h6>
                                            </td>

                                            <td class="subtotal">
                                                <h5>{{ getFormattedAmount($sub_total) }}</h5>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th class="text-end">
                                                <h3>Total Quantity</h3>
                                            </th>
                                            <th class="text-center">
                                                <h3 class="total-quantity">{{ $sellerOrder->sellerOrderDetails->sum('quantity') }}</h3>
                                            </th>
                                            <th class="text-center">
                                                <h3>Total </h3>
                                            </th>
                                            <th class="text-center">
                                                <h3 class="total-price">{{ getFormattedAmount($total) }}</h3>
                                            </th>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    </div>

    </div>
    <div class="row g-4">
        <div class="col-lg-12 col-sm-6">
            <div class="summery-box">
                <div class="summery-header">
                    <h3>Price Details</h3>
                    <h5 class="ms-auto theme-color">({{$order_product_qty}} Items)</h5>
                </div>

                <ul class="summery-contain">
                    <li>
                        <h4>SubTotal</h4>
                        <h4 class="price">{{ getFormattedAmount($order->sub_total_amount) }}</h4>
                    </li>

                    <li>
                        <h4>Shipping Cost</h4>
                        <h4 class="price text-danger">{{ getFormattedAmount($order->shipping_cost) }}</h4>
                    </li>

                    <li>
                        <h4>Discount</h4>
                        <h4 class="price theme-color">{{ getFormattedAmount($order->discount_amount) }}</h4>
                    </li>
                </ul>

                <ul class="summery-total">
                    <li class="list-total">
                        <h4>Total</h4>
                        <h4 class="price">{{ getFormattedAmount($order->total_amount) }}</h4>
                    </li>
                </ul>

                @if($order->collected_amount > 0)
                <ul class="summery-contain">
                    <li>
                        <h4>Paid Amount</h4>
                        <h4 class="price theme-color">{{ getFormattedAmount($order->collected_amount) }}</h4>
                    </li>

                    <li>
                        <h4>Due</h4>
                        <h4 class="price text-danger">{{ getFormattedAmount($order->amount_to_be_collect) }}</h4>
                    </li>
                </ul>
                @endif
                
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        .order-table .accordion-box .accordion-item .accordion-header .accordion-button::after{
            content: '';
        }
    </style>
@endpush
