@extends('admin.layouts.master')

@section('title', 'Purchase Details')

@section('content')

@php
use App\Library\Helper;
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.purchase.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Purchase Details')) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">

                    <div class="text-center">
                        <div class="mb-3">
                            <span>Supplier</span>
                            <h3>{{ $order?->supplier->name }}</h3>
                        </div>
                        <h4 class="mx-auto mb-2">
                            <i class="fa-solid fa-receipt"></i> Invoice Number: {{ $order->invoice_id }}
                        </h4>
                    </div>

                    <div class="text-center mt-4 nav-tab">

                        @if(Helper::hasAuthRolePermission('purchase_update'))
                        <a href="{{ route('admin.purchase.update',$order->id)}}"
                            class="btn btn-sm btn-warning mb-2 mr-2">
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>
                        @endif

                        @if(Helper::hasAuthRolePermission('purchase_update') && false)
                        <button class="btn btn-sm mb-2 mr-2 btn-primary"
                            onclick="clickPay({{$order->total_amount}}, {{$order->due_amount}}, {{$order->id}})">
                            <i class="fas fa-plus"></i>
                            Make Payment
                        </button>
                        @endif

                        @if(Helper::hasAuthRolePermission('purchase_show'))
                        <a href="{{ route('admin.return.purchase.create',$order->id)}}" target="_blank"
                            class="btn btn-sm btn2-secondary mb-2 mr-2">
                            <i class="fa-solid fa-rotate-left"></i>
                            Return
                        </a>
                        @endif

                        @if(Helper::hasAuthRolePermission('purchase_show'))
                        <a href="{{ route('admin.purchase.invoice.view',$order->id)}}" target="_blank"
                            class="btn btn-sm btn-info mb-2 mr-2">
                            <i class="fa-solid fa-eye"></i>
                            View Invoice
                        </a>
                        @endif

                        @if(Helper::hasAuthRolePermission('purchase_show'))
                        <a href="{{ route('admin.purchase.invoice.download',$order->id)}}"
                            class="btn btn-sm btn-secondary mb-2 mr-2">
                            <i class="fa-solid fa-download"></i>
                            Download Invoice
                        </a>
                        @endif
                    </div>
                </div>
            </div><!-- End Supplier Info -->

            <div class="card shadow-sm mt-4">
                <div class="card-body py-sm-4">
                    <table class="table org-data-table table-bordered">
                        <tbody>
                            <tr>
                                <th>Sub Total Amount</th>
                                <td>{{ getFormattedAmount($order->sub_total_amount) }}</td>
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
                                <th>Due Amount</th>
                                <td>{{ getFormattedAmount($order->due_amount) }}</td>
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
                                <th>Return Amount</th>
                                <td>{{ getFormattedAmount($return_amount) }}</td>
                            </tr>

                            <tr>
                                <th>Total Amount</th>
                                <td>{{ getFormattedAmount($order->total_amount) }}</td>
                            </tr>

                            {{-- <tr class="d-none">
                                <th>Order Status</th>
                                <td>
                                    <div class="badge badge-secondary"> {{ \App\Library\Enum::getOrderStatusType($order?->order_status) }} </div>
                                </td>
                            </tr> --}}

                            <tr>
                                <th>Payment Status</th>
                                <td>
                                    <div class="badge badge-primary"> {{ \App\Library\Enum::getPaymentStatusType($order?->payment_status) }} </div>
                                </td>
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

                                <img src="{{ $value->getAttachment() }}" alt="{{ $value->name }}" />

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
                                    <tfoot class="tfoot active">
                                        <tr>
                                            <th>Total</th>
                                            <th class="text-center">
                                                {{ getFormattedAmount($paymentDetails->sum('amount')) }}
                                            </th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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
                                            <th class="text-center">Unit</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="">Purchase Price</th>
                                            <th class="">Sale Price</th>
                                            <th class="">Special Price</th>
                                            <th class="">Stock alert</th>
                                            <th class="">Warranty</th>
                                            <th class="text-center">SubTotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $total_qty = 0; $total = 0; $sub_total=0;
                                        @endphp

                                        @foreach ($stocks as $key => $stock)
                                        @php
                                        $total_qty = $total_qty + $stock->quantity;
                                        $sub_total = $stock->quantity * $stock->purchase_price;
                                        $total = $total +$sub_total;
                                        @endphp

                                        <tr class="parent-row">
                                            <td>
                                                <span class="product-name"> {{ $stock->product->title }} </span>
                                            </td>
                                            <td class="text-center">
                                                {{ $stock->product->unit }}
                                            </td>
                                            <td class="text-center">
                                                {{ $stock->quantity }}
                                            </td>
                                            <td class="text-center">
                                                {{ getFormattedAmount($stock->purchase_price) }}
                                            </td>
                                            <td class="text-center">
                                                {{ getFormattedAmount($stock->sale_price) }}
                                            </td>
                                            <td class="text-center">
                                                {{ getFormattedAmount($stock->special_price) }}
                                            </td>
                                            <td class="text-center">
                                                {{ $stock->stock_alert ?? 'N/A' }}
                                            </td>
                                            <td class="text-center">
                                                {{ $stock->warranty_date ?? 'N/A' }}
                                            </td>
                                            <td class="sub-total-td text-center">
                                                <span>
                                                    {{ getFormattedAmount($sub_total) }}
                                                </span>
                                            </td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot class="tfoot active">
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th id="total-qty" class="text-center"> {{ $total_qty }} </th>
                                            <th colspan="5"></th>
                                            <th id="total" class="text-center">
                                                {{ getFormattedAmount($total) }} </th>
                                        </tr>
                                    </tfoot>
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
                                @php
                                    $total_qty = 0; $sub_total = 0; $total_amount = 0;
                                @endphp

                                @if(count($returns) > 0)
                                <table id="purchaseTable" class="table table-hover order-list">
                                    @foreach ($returns as $key => $return)
                                    <thead class="bg-light2-secondary text-white">
                                        <tr>
                                            <th class="text-center" colspan="4">Invoice Number:
                                                {{ $return->invoice_id }}</th>
                                        </tr>
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
                                        @foreach ($return->returnDetails->load('product', 'orderDetails') as $key=>$val)
                                        @php
                                            $total_qty = $total_qty + $val->quantity;
                                            $sub_total = $val->orderDetails->purchase_price * $val->quantity;
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
                                                {{ getFormattedAmount($val->orderDetails->purchase_price) }}
                                            </td>


                                            <td class="text-center">
                                                {{ getFormattedAmount($sub_total) }}
                                            </td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                    @endforeach
                                    <tfoot class="tfoot">
                                        <tr>
                                            <th>Total : </th>
                                            <th class="text-center">{{ $total_qty }}</th>
                                            <th class="text-center"></th>
                                            <th id="total-qty" class="text-center">
                                                {{ getFormattedAmount($total_amount) }} </th>
                                        </tr>
                                    </tfoot>
                                </table>
                                @else
                                <p class="text-center">No Data</p>
                                @endif
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
