@extends('admin.layouts.master')

@section('title', 'Quotation Details')

@section('content')

@php
use App\Library\Helper;

@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.quotation.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Quotation Details')) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <!-- Client Info -->
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">

                    <div class="text-center">
                        <div class="mb-3">
                            <span>Customer</span>
                            <h3>{{ $order?->customer ? $order?->customer?->full_name : $order?->order_person_name }}</h3>
                        </div>
                        <h4 class="mx-auto mb-2">
                            <i class="fa-solid fa-receipt"></i> Quotation Number: {{ $order->id }}
                        </h4>
                    </div>

                    <div class="text-center mt-4 nav-tab">
                        @if(Helper::hasAuthRolePermission('order_update'))
                        <button class="btn btn-sm mb-2 mr-2 change-status btn2-secondary" onclick="clickUpdateStatus()">
                            <i class="fas fa-power-off"></i>
                            Change Status
                        </button>
                        @endif

                        @if(Helper::hasAuthRolePermission('order_update') && count($paymentDetails) < 1) <a
                            href="{{ route('admin.quotation.update',$order->id)}}"
                            class="btn btn-sm btn-warning mb-2 mr-2">
                            <i class="fas fa-edit"></i>
                            Edit
                            </a>
                            @endif

                            @if(Helper::hasAuthRolePermission('order_show'))
                            <button class="btn btn-sm mb-2 mr-2 btn-primary"
                                onclick="clickPay({{$order->total_amount}}, {{$order->due_amount}}, {{$order->id}})">
                                <i class="fas fa-plus"></i>
                                Make Order
                            </button>
                            @endif

                            @if(Helper::hasAuthRolePermission('order_show'))
                            <a href="{{ route('admin.quotation.invoice.view',$order->id)}}" target="_blank"
                                class="btn btn-sm btn-info mb-2 mr-2">
                                <i class="fa-solid fa-eye"></i>
                                View Quotation
                            </a>
                            @endif

                            @if(Helper::hasAuthRolePermission('order_show'))
                            <a href="{{ route('admin.quotation.invoice.download',$order->id)}}"
                                class="btn btn-sm btn-secondary mb-2 mr-2">
                                <i class="fa-solid fa-download"></i>
                                Download Quotation
                            </a>
                            @endif
                    </div>
                </div>
            </div><!-- End Client Info -->

            <div class="card shadow-sm mt-4">
                <div class="card-body py-sm-4">
                    <table class="table org-data-table table-bordered">
                        <tbody>

                            {{-- <tr>
                                <td>Quotation Status</td>
                                <td>
                                    <div class="badge badge-secondary">
                                        {{ \App\Library\Enum::getOrderStatusType($order?->order_status) }} </div>
                                </td>
                            </tr> --}}

                            <tr>
                                <td>Sub Total Amount</td>
                                <td>{{ getFormattedAmount($order->sub_total_amount) }}</td>
                            </tr>

                            <tr>
                                <td>Total Amount</td>
                                <td>{{ getFormattedAmount($order->total_amount) }}</td>
                            </tr>

                            <tr>
                                <td>Due Amount</td>
                                <td>{{ getFormattedAmount($order->due_amount) }}</td>
                            </tr>

                            {{-- <tr>
                                <td>Vat Amount</td>
                                <td>{{ getFormattedAmount($order->vat_amount) }}</td>
                            </tr> --}}

                            <tr>
                                <td>Discount Amount</td>
                                <td>{{ getFormattedAmount($order->discount_amount) }}</td>
                            </tr>


                            <tr>
                                <td>Packaging Cost</td>
                                <td>{{ getFormattedAmount($order->packaging_cost) }}</td>
                            </tr>

                            <tr>
                                <td>Shipping Cost</td>
                                <td>{{ getFormattedAmount($order->shipping_cost) }}</td>
                            </tr>

                            <tr>
                                <td>Operator</td>
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
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Payment Method</th>
                                            <th class="text-center">Payment Amount</th>
                                            <th class="text-center">Transaction ID</th>
                                            {{-- <th>Current Due</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paymentDetails as $key => $paymentDetail)
                                        <tr class="parent-row">
                                            <td>{{ $paymentDetail->payment_method ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                {{ getFormattedAmount($paymentDetail->amount)??'N/A' }}</td>
                                            <td class="text-center">{{ $paymentDetail?->transaction_id ?? 'N/A' }}</td>
                                            {{-- <td>{{ getFormattedAmount($paymentDetail?->current_due)??'N/A' }}</td>
                                            --}}
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
                            <h5>Quotation Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table id="purchaseTable" class="table table-hover order-list">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class="text-center">Stock</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">SubTotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $qty =0; $subtotal = 0; @endphp

                                        @foreach ($orderDetails as $key => $orderDetail)

                                        @php
                                        $qty = $qty + $orderDetail->quantity;
                                        $subtotal = $orderDetail->quantity*$orderDetail->sale_price;
                                        @endphp
                                        <tr class="parent-row">
                                            <td>
                                                <span class="product-name"> {{ $orderDetail->product->title }} </span>
                                            </td>
                                            <td class="text-center">
                                                {{ $orderDetail?->stock?->quantity }}
                                            </td>
                                            <td class="text-center">
                                                {{ $orderDetail->quantity }}
                                            </td>
                                            <td class="text-center">
                                                <span>
                                                    {{ formatPrice($subtotal) }}
                                                </span>
                                            </td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot class="tfoot active">
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th id="total-qty" class="text-center"> {{ $qty }} </th>
                                            <th class="text-center"> {{formatPrice($order->sub_total_amount)}}</th>

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

@include('admin.pages.quotation.partials.modal_change_status')
@include('admin.pages.quotation.partials.modal_pay')
@stop
@push('scripts')
<script>

</script>
@endpush
