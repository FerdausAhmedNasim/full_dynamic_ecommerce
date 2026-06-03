@extends('admin.layouts.master')
@section('title', 'Order Details')
@section('orders', 'active')

@section('content')

@php
use App\Library\Helper;
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.user.seller.index')) !!}
        <div class="d-block">
            <h4 class="content-title">
            {{ strtoupper('Seller Order Details') }}
            </h4>
        </div>
    </div>

    <!-- TabMenu Start -->
    <div class="card shadow-sm">
    @include('admin.pages.user.seller.partials.topbar', ['user', $user??''])
    </div>
    <!-- TabMenu End -->

    <div class="row mt-3">
        <div class="col-md-5 mb-4 mt-3">
            <div class="card shadow-sm">

                <div class="card-body py-sm-4">
                    <div class="text-center mt-4 nav-tab">
                        @if ($seller_order->order->payment_status == App\Library\Enum::ORDER_PAYMENT_STATUS_UNPAID)
                            <button class="btn btn-sm mb-2 mr-2 change-status btn2-secondary" disabled>
                                    <i class="fas fa-power-off"></i> Change Payment Status
                            </button>
                        @else
                            <button class="btn btn-sm mb-2 mr-2 change-status btn2-secondary" onclick="clickUpdateStatus()">
                                <i class="fas fa-power-off"></i> Change Payment Status
                            </button>
                        @endif
                    </div>
                    <table class="table org-data-table table-bordered">
                        <tbody>
                            <tr>
                                <th>Invoice Number</th>
                                <td>{{ $seller_order->order->invoice_id }}</td>
                            </tr>

                            <tr>
                                <th>Sub Total Amount</th>
                                <td>{{ getFormattedAmount($seller_order->sub_total_amount) }}</td>
                            </tr>

                            <tr>
                                <th>Total Amount</th>
                                <td>{{ getFormattedAmount($seller_order->total_amount) }}</td>
                            </tr>

                            <tr>
                                <th>Discount Amount</th>
                                <td>{{ getFormattedAmount($seller_order->discount_amount) }}</td>
                            </tr>

                            <tr>
                                <th>Shipping Cost</th>
                                <td>{{ getFormattedAmount($seller_order->shipping_cost) }}</td>
                            </tr>

                            <tr>
                                <th>Customer</th>
                                <td>{{ $seller_order?->order->customer->full_name }}</td>
                            </tr>

                            <tr>
                                <th>Payment Status</th>
                                <td>{!! getOrderPaymentStatus($seller_order?->payment_status) !!}</td>
                            </tr>

                            <tr>
                                <th>Payment Date</th>
                                <td>{{ getFormattedDate($seller_order?->payment_date) ?? 'N/A' }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7 mb-4">
            <div class="row">



                <div class="col-md-12 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>Order Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table id="purchaseTable" class="table table-hover order-list">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-right">SubTotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_qty = 0;
                                        @endphp

                                        @foreach ($orderDetails as $key => $seller_order_detail)
                                        @php $total_qty = $total_qty + $seller_order_detail->quantity; @endphp
                                        <tr class="parent-row">
                                            <td>
                                                <img width="50" src="{{ $seller_order_detail?->product?->getThumbnailImage() }}">
                                            </td>
                                            <td>
                                                <span class="product-name"> {{ $seller_order_detail?->product->getTranslation('short_title') }} </span>
                                                @if ($seller_order_detail?->load('productStock')?->productStock?->variant_ids)
                                                    <br> <small>{{ getProductVariantValue($seller_order_detail?->load('productStock')?->productStock?->variant_ids) }}</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $seller_order_detail->quantity }}
                                            </td>
                                            <td class="text-center">
                                                {{ getFormattedAmount($seller_order_detail->sale_price) }}
                                            </td>
                                            <td class="sub-total-td text-right">
                                                <span> {{ getFormattedAmount($seller_order_detail->quantity * $seller_order_detail->sale_price) }} </span>
                                            </td>

                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center"><strong>Subtotal</strong></td>
                                            <td class="text-right"><strong>{{ getFormattedAmount($seller_order->sub_total_amount) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center"><strong>Shipping Cost</strong></td>
                                            <td class="text-right"><strong>{{ getFormattedAmount($seller_order->shipping_cost) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center"><strong>Discount</strong></td>
                                            <td class="text-right"><strong>{{ getFormattedAmount($seller_order->discount_amount) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><strong>Total</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><strong>{{ getFormattedAmount($seller_order->total_amount) }}</strong></td>
                                        </tr>
                                        {{-- <tr>
                                            <th>Total</th>
                                            <th colspan=""></th>
                                            <th id="total-qty" class="text-center"> {{ $total_qty }} </th>
                                            <th colspan=""></th>
                                            <th id="total" class="text-center">{{ getFormattedAmount($seller_order->total_amount) }} </th>
                                        </tr> --}}

                                    </tbody>
                                    <tfoot class="tfoot active">
                                        {{-- <tr>
                                            <th>Total</th>
                                            <th id="total-qty" class="text-center"> {{ $total_qty }} </th>
                                            <th colspan=""></th>
                                            <th id="total" class="text-center">{{ getFormattedAmount($seller_order->total_amount) }} </th>
                                        </tr>
                                    </tfoot> --}}
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.pages.user.seller.order.modal_change_status')
@stop


@push('scripts')
@endpush
