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
        @include('admin.pages.member.partials.topbar', ['user', $user])
    </div>
    <!-- TabMenu End -->

    <div class="row mt-3">
        <div class="col-md-5 mb-4">
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
                                <th>Packaging Cost</th>
                                <td>{{ getFormattedAmount($order->packaging_cost) }}</td>
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
        <div class="col-md-7 mb-4">
            <div class="row">

                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>Payment Details</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Payment Method</th>
                                        <th class="text-left">Paid Amount</th>
                                        <th class="text-center">Transaction ID</th>
                                        {{-- <th>Current Due</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total_pay = 0; @endphp
                                    @foreach ($paymentDetails as $key => $paymentDetail)
                                    @php
                                        $total_pay = $total_pay + $paymentDetail->amount;
                                    @endphp
                                    <tr class="parent-row">
                                        <td>{{ $paymentDetail->payment_method ?? 'N/A' }}</td>
                                        <td class="text-left">{{ getFormattedAmount($paymentDetail->amount)??'N/A' }}</td>
                                        <td class="text-center">{{ $paymentDetail?->transaction_id ?? 'N/A' }}</td>
                                        {{-- <td>{{ getFormattedAmount($paymentDetail?->current_due)??'N/A' }}</td> --}}
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <th>Total </th>
                                        <th class="text-left" colspan="2"> {{formatPrice($total_pay)}}</th>
                                    </tr>

                                </tbody>
                                {{-- <tfoot class="tfoot active">
                                    <tr>
                                        <th>Total Paid :  </th>
                                        <th class="text-left" colspan="2"> {{formatPrice($total_pay)}}</th>
                                    </tr>
                                </tfoot> --}}
                            </table>
                            {{-- <table class="table org-data-table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Payment Method</th>
                                        <td>{{ $paymentDetails->payment_method ?? 'N/A' }}</td>

                                        <th> Payment Amount</th>
                                        <td>{{ getFormattedAmount($paymentDetails?->amount)??'N/A' }}</td>

                                        <th>Current Due</th>
                                        <td>{{ getFormattedAmount($paymentDetails?->current_due)??'N/A' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Transaction ID</th>
                                        <td>{{ $paymentDetails?->transaction_id ?? 'N/A' }}</td>
                                        <th>Note</th>
                                        <td>{{ $paymentDetails?->note ?? 'N/A' }}</td>
                                    </tr>

                                </tbody>
                            </table> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>Purchase Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table id="purchaseTable" class="table table-hover order-list">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-center">SubTotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_qty = 0;
                                        @endphp

                                        @foreach ($orderDetails as $key => $order_detail)
                                        @php $total_qty = $total_qty + $order_detail->quantity; @endphp
                                        <tr class="parent-row">
                                            <td>
                                                <span class="product-name"> {{ $order_detail->product->getTranslation('title') }} </span>
                                            </td>
                                            <td class="text-center">
                                                {{ $order_detail->quantity }}
                                            </td>
                                            <td class="text-center">
                                                {{ getFormattedAmount($order_detail->sale_price) }}
                                            </td>
                                            <td class="sub-total-td text-center">
                                                <span> {{ getFormattedAmount($order_detail->quantity * $order_detail->sale_price) }} </span>
                                            </td>

                                        </tr>
                                        @endforeach

                                        <tr>
                                            <th>Total</th>
                                            <th id="total-qty" class="text-center"> {{ $total_qty }} </th>
                                            <th colspan=""></th>
                                            <th id="total" class="text-center">{{ getFormattedAmount($order->total_amount) }} </th>
                                        </tr>

                                    </tbody>
                                    <tfoot class="tfoot active">
                                        {{-- <tr>
                                            <th>Total</th>
                                            <th id="total-qty" class="text-center"> {{ $total_qty }} </th>
                                            <th colspan=""></th>
                                            <th id="total" class="text-center">{{ getFormattedAmount($order->total_amount) }} </th>
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

@stop


@push('scripts')
@endpush
