@extends('admin.layouts.master')

@section('title', 'Order Details')

@section('content')

@php
use App\Library\Helper;
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.customer.order', $user->id)) !!}
        <div class="d-block">
            <h4 class="content-title">
            {{ strtoupper('Customer Order Details') }}
            </h4>
        </div>
    </div>

    <!-- TabMenu Start -->
    <div class="card shadow-sm">
        @include('admin.pages.user.customer.partials.topbar', ['user', $user])
    </div>
    <!-- TabMenu End -->

    <div class="row mt-3">
        <div class="col-md-3 col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <table class="table org-data-table table-bordered">
                        <tbody>
                            <tr>
                                <th>Invoice Number</th>
                                <td>{{ $order->invoice_id }}</td>
                            </tr>

                            <tr>
                                <th>Sub Total Amount</th>
                                <td>{{ getFormattedAmount($order->sub_total_amount) }}</td>
                            </tr>

                            <tr>
                                <th>Total Amount</th>
                                <td>{{ getFormattedAmount($order->total_amount) }}</td>
                            </tr>

                            {{-- <tr>
                                <th>Vat Amount</th>
                                <td>{{ getFormattedAmount($order->vat_amount) }}</td>
                            </tr> --}}

                            <tr>
                                <th>Discount Amount</th>
                                <td>{{ getFormattedAmount($order->discount_amount) }}</td>
                            </tr>

                            <tr>
                                <th>Shipping Cost</th>
                                <td>{{ getFormattedAmount($order->shipping_cost) }}</td>
                            </tr>

                            <tr>
                                <th>Operator</th>
                                <td>{{ $order?->operator->full_name }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-12 mb-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>Order Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table id="purchaseTable" class="table table-hover order-list table-less-padding">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Unit</th>
                                            <th class="text-right">Unit Price</th>
                                            <th class="text-right">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $qty = 0; $subtotal = 0; @endphp

                                        @foreach ($sellerOrders as $key => $sellerOrder)
                                            @foreach ($sellerOrder->sellerOrderDetails as $key => $sellerOrderDetail)
                                                <tr class="parent-row">
                                                    @php
                                                        $qty = $qty + $sellerOrderDetail->quantity;
                                                        $subtotal = $sellerOrderDetail->quantity*$sellerOrderDetail->sale_price;
                                                    @endphp
                                                 
                                                    <td>
                                                        <img width="50" src="{{ $sellerOrderDetail?->product?->getThumbnailImage() }}">
                                                    </td>
                                                    <td>
                                                        <span class="product-name"> {{ $sellerOrderDetail?->product->getTranslation('short_title') }} </span>
                                                        @if ($sellerOrderDetail?->load('productStock')?->productStock?->variant_ids)
                                                            <br> <small>{{ getProductVariantValue($sellerOrderDetail?->load('productStock')?->productStock?->variant_ids) }}</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $sellerOrderDetail->quantity }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $sellerOrderDetail?->product?->unit ?? 'N/A' }}
                                                    </td>
                                                    <td class="text-right">
                                                        <span>
                                                            {{ getFormattedAmount($sellerOrderDetail->sale_price) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-right">
                                                        <span>
                                                            {{ getFormattedAmount($subtotal) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                                
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><strong>Subtotal</strong></td>
                                            <td class="text-right"><strong>{{ getFormattedAmount($sellerOrder->sub_total_amount) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><strong>Shipping Cost</strong></td>
                                            <td class="text-right"><strong>{{ getFormattedAmount($sellerOrder->shipping_cost) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><strong>Discount</strong></td>
                                            <td class="text-right"><strong>{{ getFormattedAmount($sellerOrder->discount_amount) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><strong>Total</strong></td>
                                            <td class="text-right"><strong>{{ getFormattedAmount($sellerOrder->total_amount) }}</strong></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@stop


@push('scripts')
@endpush
