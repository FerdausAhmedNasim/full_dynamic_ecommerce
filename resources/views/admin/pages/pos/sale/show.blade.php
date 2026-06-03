@extends('admin.layouts.master')

@section('title', 'Sale Return Details')

@section('content')

@php
use App\Library\Helper;
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.return.sale.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Sale Return Details')) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <table class="table org-data-table table-bordered">
                        <tbody>
                            <tr>
                                <th>Order Invoice Number</th>
                                <td>{{ $order->invoice_id }}</td>
                            </tr>

                            <tr>
                                <th>Return Invoice Number</th>
                                <td>{{ $order_return->invoice_id }}</td>
                            </tr>

                            <tr>
                                <th>Sub Total Amount</th>
                                <td>{{ getFormattedAmount($order_return->refund_sub_total_amount??0) }}</td>
                            </tr>

                            <tr>
                                <th>Total Amount</th>
                                <td>{{ getFormattedAmount($order_return->refund_total_amount) }}</td>
                            </tr>

                            <tr>
                                <th>Discount Amount</th>
                                <td>{{ getFormattedAmount($order_return->refund_discount_amount??0) }}</td>
                            </tr>

                            <tr>
                                <th>Packaging Cost</th>
                                <td>{{ getFormattedAmount($order_return->refund_packaging_amount??0) }}</td>
                            </tr>

                            <tr>
                                <th>Delivery Cost</th>
                                <td>{{ getFormattedAmount($order_return->refund_delivery_amount??0) }}</td>
                            </tr>

                            <tr>
                                <th>Operator</th>
                                <td>{{ $order?->operator->full_name }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 ">Attachments</div>
                    </div>
                    <hr>

                    <div class="row">
                        @foreach($attachments as $key => $value)
                            <div class="col-md-6 d-flex align-items-stretch">
                                <figure class="snip1">

                                    <img src="{{ $value->getAttachment() }}" alt="{{ $value->name }}"/>

                                    <div>
                                        <h2>{{ $value->name }}</h2>
                                        <div class="curl"></div>
                                        @if($value->isImage())
                                            <a onclick="clickImage('{{ $value->getAttachment() }}')">
                                                <i class="fas fa-eye text-success"></i>
                                            </a>
                                        @else
                                            <a href="{{ asset($value->attachment) }}" download="">
                                                <i class="fas fa-download text-success"></i>
                                            </a>
                                        @endif
                                    </div>
                                </figure>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7 mb-4">
            <div class="row">

                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>Return Payment Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Payment Method</th>
                                            <th>Payment Amount</th>
                                            <th>Transaction ID</th>
                                            <th>Current Due</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paymentDetails as $key => $paymentDetail)
                                        <tr class="parent-row">
                                            <td>{{ $paymentDetail->payment_method ?? 'N/A' }}</td>
                                            <td>{{ getFormattedAmount($paymentDetail->amount)??'N/A' }}</td>
                                            <td>{{ $paymentDetail?->transaction_id ?? 'N/A' }}</td>
                                            <td>{{ getFormattedAmount($paymentDetail?->current_due)??'N/A' }}</td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>Return Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table id="purchaseTable" class="table table-hover order-list">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Unit</th>
                                            <th class="text-center">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $total_qty = 0;
                                        @endphp

                                        @foreach ($returnDetails as $key => $return)
                                        @php $total_qty = $total_qty + $return->quantity; @endphp
                                        <tr class="parent-row">
                                            <td>
                                                <span class="product-name"> {{ $return->product->title }} </span>
                                            </td>
                                            <td>
                                                {{ $return->product->unit }}
                                            </td>
                                            <td class="text-center">
                                                {{ $return->quantity }}
                                            </td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot class="tfoot active">
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th id="total-qty" class="text-center"> {{ $total_qty }} </th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.assets.preview-image')
@stop


@push('scripts')
@endpush