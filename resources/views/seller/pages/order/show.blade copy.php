@extends('seller.layouts.master')

@section('title', 'Order Details')

@section('content')

@php
use App\Library\Helper;
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('seller.order.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Order Details')) }}</h4>
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
                    <h3>{{ $order?->customer->full_name }}</h3>
                </div>
                <h4 class="mx-auto mb-2">
                    <i class="fa-solid fa-receipt"></i> Invoice Number: {{ $order->invoice_id }}
                </h4>
            </div>

            <div class="text-center mt-4 nav-tab">
                {{-- @if(Helper::hasAuthRolePermission('order_update')) --}}
                <button
                    class="btn btn-sm mb-2 mr-2 change-status btn2-secondary"
                    onclick="clickUpdateStatus()">
                    <i class="fas fa-power-off"></i>
                     Change Status
                </button>
                {{-- @endif --}}

                {{-- @if(Helper::hasAuthRolePermission('order_update') && count($paymentDetails) < 1) --}}
                {{-- <a href="{{ route('seller.order.update',$order->id)}}"
                    class="btn btn-sm btn-warning mb-2 mr-2">
                    <i class="fas fa-edit"></i>
                     Edit
                </a> --}}
                {{-- @endif --}}

                {{-- @if(Helper::hasAuthRolePermission('order_show')) --}}
                {{-- <button
                    class="btn btn-sm mb-2 mr-2 btn-primary"
                    onclick="clickPay({{$order->total_amount}}, {{ $order->due_amount - $return_amount < 1 ? 0 : $order->due_amount - $return_amount }}, {{$order->id}})">
                    <i class="fas fa-plus"></i>
                     Pay
                </button> --}}
                {{-- @endif --}}

                {{-- @if(Helper::hasAuthRolePermission('order_show')) --}}
                {{-- <a href="{{ route('seller.return.sale.create',$order->id)}}" target="_blank"
                    class="btn btn-sm btn-danger mb-2 mr-2">
                    <i class="fa-solid fa-rotate-left"></i>
                    Return
                </a> --}}
                {{-- @endif --}}

                {{-- @if(Helper::hasAuthRolePermission('order_invoice')) --}}
                <a href="{{ route('seller.order.invoice.view',$order->id)}}" target="_blank"
                    class="btn btn-sm btn-info mb-2 mr-2">
                    <i class="fa-solid fa-eye"></i>
                     View Invoice
                </a>
                {{-- @endif --}}

                {{-- @if(Helper::hasAuthRolePermission('order_invoice')) --}}
                <a href="{{ route('seller.order.invoice.download',$order->id)}}"
                    class="btn btn-sm btn-secondary mb-2 mr-2">
                    <i class="fa-solid fa-download"></i>
                    Download Invoice
                </a>
                {{-- @endif --}}
            </div>
        </div>
    </div><!-- End Client Info -->

            <div class="card shadow-sm mt-4">
                <div class="card-body py-sm-4">
                    <table class="table org-data-table table-bordered">
                        <tbody>
                            {{-- <tr>
                                <td>Order Status</td>
                                <td>
                                    <div class="badge badge-secondary"> {{ \App\Library\Enum::getOrderStatusType($order?->order_status) }} </div>
                                </td>
                            </tr> --}}

                            <tr>
                                <td>Sub Total Amount</td>
                                <td>{{ getFormattedAmount($order->sub_total_amount) }}</td>
                            </tr>

                            <tr>
                                <td>Discount Amount</td>
                                <td>{{ getFormattedAmount($order->discount_amount) }}</td>
                            </tr>

                            <tr>
                                <td>Shipping Cost</td>
                                <td>{{ getFormattedAmount($order->shipping_cost) }}</td>
                            </tr>

                            {{-- <tr>
                                <td>Return Amount </td>
                                <td>{{ getFormattedAmount($return_amount) }}</td>
                            </tr> --}}

                            <tr>
                                <td>Total Amount</td>
                                <td>{{ getFormattedAmount($order->total_amount) }}</td>
                            </tr>

                            {{-- <tr>
                                <td>Operator</td>
                                <td>{{ $order?->operator->full_name }}</td>
                            </tr> --}}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7 mb-4">
            <div class="row">

                {{-- <div class="col-md-12">
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
                                            <th class="text-left">Paid Amount</th>
                                            <th class="text-center">Transaction ID</th>
                                            <th>Current Due</th>
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
                                            <td>{{ getFormattedAmount($paymentDetail?->current_due)??'N/A' }}</td>
                                        </tr>
                                        @endforeach

                                        <tr>
                                            <th>Total</th>
                                            <th class="text-left" colspan="2"> {{formatPrice($total_pay)}}</th>
                                        </tr>

                                    </tbody>
                                    <tfoot class="tfoot active">
                                        <tr>
                                            <th>Total Paid :  </th>
                                            <th class="text-left" colspan="2"> {{formatPrice($total_pay)}}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}

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
                                            <th>Name</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Unit</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-center">SubTotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $qty =0; $subtotal = 0; @endphp

                                        @foreach ($order->sellerOrders as $key => $sellerOrder)
                                        <tr class="parent-row">
                                            <td colspan="5">
                                                <h5>{{ $sellerOrder?->store?->getTranslation('store_name') }}</h5>
                                                @foreach ($sellerOrder->sellerOrderDetails as $key => $sellerOrderDetail)

                                                @php
                                                    $qty = $qty + $sellerOrderDetail->quantity;
                                                    $subtotal = $sellerOrderDetail->quantity*$sellerOrderDetail->sale_price;
                                                @endphp

                                                    <tr class="parent-row">
                                                        <td>
                                                            <span class="product-name"> {{ $sellerOrderDetail?->product->getTranslation('title') }} </span>
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $sellerOrderDetail->quantity }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $sellerOrderDetail->product->unit }}
                                                        </td>
                                                        <td class="text-center">
                                                            <span>
                                                                {{ getFormattedAmount($sellerOrderDetail->sale_price) }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span>
                                                                {{ getFormattedAmount($subtotal) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </td>
                                        </tr>

                                        {{-- @php
                                            $qty = $qty + $orderDetail->quantity;
                                            $subtotal = $orderDetail->quantity*$orderDetail->sale_price;
                                        @endphp
                                        <tr class="parent-row">
                                            <td>
                                                <span class="product-name"> {{ $orderDetail->product->title }} </span>
                                            </td>
                                            <td class="text-center">
                                                {{ $orderDetail->quantity }}
                                            </td>
                                            <td class="text-center">
                                                {{ $orderDetail->product->unit }}
                                            </td>
                                            <td class="text-center">
                                                <span>
                                                    {{ getFormattedAmount($orderDetail->sale_price) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span>
                                                    {{ getFormattedAmount($subtotal) }}
                                                </span>
                                            </td>

                                        </tr> --}}
                                        @endforeach

                                        <tr>
                                            <th>Total</th>
                                            <th id="total-qty" class="text-center"> {{ $qty }} </th>
                                            <th></th>
                                            <th class="text-center"> {{formatPrice($order->total_amount)}}</th>
                                            <th></th>
                                        </tr>
                                    </tbody>
                                    {{-- <tfoot class="tfoot active">
                                        <tr>
                                            <th>Total</th>
                                            <th id="total-qty" class="text-center"> {{ $qty }} </th>
                                            <th></th>
                                            <th class="text-center"> {{formatPrice($order->total_amount)}}</th>
                                            <th></th>
                                        </tr>
                                    </tfoot> --}}
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-12 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>Return Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                @php
                                    $total_qty = 0; $sub_total = 0; $total_amount = 0;
                                @endphp

                                @if(count($returns) > 0)
                                <table id="purchaseTable" class="table table-hover order-list">
                                    @foreach ($returns as $key => $return)
                                    <thead class="bg-light2-secondary text-white">
                                        <tr><th class="text-center" colspan="4">Invoice Number: {{ $return->invoice_id }}</th></tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class="text-center">Return Quantity</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-center">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($return->returnDetails->load('product', 'orderDetails') as $key =>$val)
                                        @php
                                            $total_qty = $total_qty + $val->quantity;
                                            $sub_total = $val->orderDetails->sale_price * $val->quantity;
                                            $total_amount = $total_amount + $sub_total;
                                        @endphp
                                        <tr class="parent-row">
                                            <td>
                                                <span class="product-name">{{ $val->product->title }}</span>
                                            </td>
                                            <td class="text-center">
                                                {{ $val->quantity }}
                                            </td>

                                            <td class="text-center">
                                                {{ getFormattedAmount($val->orderDetails->sale_price) }}
                                            </td>
                                            <td class="text-center">
                                                {{ getFormattedAmount($sub_total) }}
                                            </td>

                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th>Total : </th>
                                            <th class="text-center">{{ $total_qty }}</th>
                                            <th class="text-center"></th>
                                            <th id="total-qty" class="text-center"> {{ getFormattedAmount($return_amount) }} </th>
                                        </tr>

                                    </tbody>
                                    @endforeach
                                    <tfoot class="tfoot">
                                        <tr>
                                            <th>Total : </th>
                                            <th class="text-center">{{ $total_qty }}</th>
                                            <th class="text-center"></th>
                                            <th id="total-qty" class="text-center"> {{ getFormattedAmount($return_amount) }} </th>
                                        </tr>
                                    </tfoot>
                                </table>
                                @else
                                <p class="text-center">No Data Found</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

@include('seller.pages.order.partials.modal_change_status')
@include('seller.pages.order.partials.modal_pay')
@stop
@push('scripts')
<script>

</script>
@endpush
