@extends('admin.layouts.master')

@section('title', 'Order Details')

@section('content')

    @php
        use App\Library\Helper;
        use App\Library\Enum;
    @endphp

    <div class="content-wrapper">
        <div class="content-header d-flex justify-content-start">
            {!! \App\Library\Html::linkBack(route('admin.order.index')) !!}
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
                                <h5>Customer Details</h5>
                                <h3 class="mt-1">{{ $order?->order->customer ? $order?->order->customer?->full_name : $order?->order->order_person_name }}</h3>
                            </div>
                            <h4 class="mx-auto mb-2">
                                <i class="fa-solid fa-receipt"></i> Invoice Number: {{ $order->order->invoice_id }}
                            </h4>
                        </div>

                        <div class="text-center mt-4 nav-tab">

                            @if (Helper::hasAuthRolePermission('order_change_status'))
                                <button class="btn btn-sm mb-2 mr-2 change-status btn2-secondary" onclick="clickUpdateStatus()"
                                {{
                                    $order->order_status == Enum::ORDER_STATUS_TYPE_RETURNED ||
                                    $order->order_status == Enum::ORDER_STATUS_TYPE_PARTIAL_RETURNED ||
                                    $order->order_status == Enum::ORDER_STATUS_TYPE_DELIVERED ||
                                    $order->order_status == Enum::ORDER_STATUS_TYPE_NOT_RECEIVED ? 'disabled' : ''
                                }}>
                                <i class="fas fa-power-off"></i> Change Status
                                </button>
                            @endif

                            @if (Helper::hasAuthRolePermission('order_change_payment_status'))
                                <button class="btn btn-sm mb-2 mr-2 change-status bg-warning" onclick="clickUpdatePaymentStatus()">
                                <i class="fas fa-power-off"></i> Change Payment Status
                                </button>
                            @endif

                            {{-- @if (Helper::hasAuthRolePermission('order_update') && count($paymentDetails) < 1) --}}
                            {{-- <a href="{{ route('admin.order.update',$order->id)}}"
                    class="btn btn-sm btn-warning mb-2 mr-2">
                    <i class="fas fa-edit"></i>
                     Edit
                </a> --}}
                            {{-- @endif --}}

                            {{-- @if (Helper::hasAuthRolePermission('order_show')) --}}
                            {{-- <button
                    class="btn btn-sm mb-2 mr-2 btn-primary"
                    onclick="clickPay({{$order->total_amount}}, {{ $order->due_amount - $return_amount < 1 ? 0 : $order->due_amount - $return_amount }}, {{$order->id}})">
                    <i class="fas fa-plus"></i>
                     Pay
                </button> --}}
                            {{-- @endif --}}

                            {{-- @if (Helper::hasAuthRolePermission('order_show')) --}}
                            {{-- <a href="{{ route('admin.return.sale.create',$order->id)}}" target="_blank"
                    class="btn btn-sm btn-danger mb-2 mr-2">
                    <i class="fa-solid fa-rotate-left"></i>
                    Return
                </a> --}}
                            {{-- @endif --}}

                            @if (Helper::hasAuthRolePermission('order_invoice'))
                            <a href="{{ route('admin.order.invoice.view', $order->id) }}" target="_blank"
                                class="btn btn-sm btn-info mb-2 mr-2">
                                <i class="fa-solid fa-eye"></i>
                                View Invoice
                            </a>
                            @endif

                            @if (Helper::hasAuthRolePermission('order_invoice'))
                            <a href="{{ route('admin.order.invoice.download', $order->id) }}"
                                class="btn btn-sm btn-secondary mb-2 mr-2">
                                <i class="fa-solid fa-download"></i>
                                Download Invoice
                            </a>
                            @endif
                        </div>
                    </div>
                </div><!-- End Client Info -->

                <div class="card shadow-sm mt-4">
                    <div class="card-body py-sm-4">
                        <table class="table org-data-table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Order Status</td>
                                    <td>
                                        {!! getOrderStatus($order?->order->order_status) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sub Total Amount</td>
                                    <td>{{ getFormattedAmount($order->order->sub_total_amount) }}</td>
                                </tr>
                                <tr>
                                    <td>Shipping Cost</td>
                                    <td>{{ getFormattedAmount($order->order->shipping_cost) }}</td>
                                </tr>
                                <tr>
                                    <td>Discount Amount</td>
                                    <td>{{ getFormattedAmount($order->order->discount_amount) }}</td>
                                </tr>
                                <tr>
                                    <td>Total Amount</td>
                                    <td>{{ getFormattedAmount($order->order->total_amount) }}</td>
                                </tr>

                                @if($order->order->collected_amount > 0)
                                <tr>
                                    <td>Paid Amount</td>
                                    <td class="text-success">{{ getFormattedAmount($order->order->collected_amount) }}</td>
                                </tr>
                                <tr>
                                    <td>Due Amount</td>
                                    <td class="text-danger">{{ getFormattedAmount($order->order->amount_to_be_collect) }}</td>
                                </tr>
                                @endif

                                <tr>
                                    <td>Payment Status</td>
                                    <td>{!! getOrderPaymentStatus($order?->order->payment_status) !!}</td>
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
                                <h5>Order Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive mt-3">
                                    <table id="purchaseTable" class="table table-hover order-list">
                                        <thead>
                                            <tr>
                                                <th width="5%">Image</th>
                                                <th>Name</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Unit</th>
                                                <th class="text-right">Unit Price</th>
                                                <th class="text-right">SubTotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $qty = 0;
                                                $subtotal = 0;
                                            @endphp 
                                            <tr class="parent-row">
                                                @foreach ($order->sellerOrderDetails as $key => $orderDetail)
                                                    @php
                                                        $qty = $qty + $orderDetail->quantity;
                                                        $subtotal += $orderDetail->quantity * $orderDetail->sale_price;
                                                    @endphp
                                            <tr class="parent-row">
                                                <td>
                                                    <img width="50" src="{{ $orderDetail->product?->getThumbnailImage() }}">
                                                </td>
                                                <td>
                                                    <span class="product-name">
                                                        {{ $orderDetail?->product->getTranslation('short_title') }}
                                                        @if ($orderDetail?->load('productStock')?->productStock?->variant_ids)
                                                            <br> <small>{{ getProductVariantValue($orderDetail?->load('productStock')?->productStock?->variant_ids) }}</small>
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    {{ $orderDetail->quantity }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $orderDetail->product->unit?? "N/A" }}
                                                </td>
                                                <td class="text-right">
                                                    <span>
                                                        {{ getFormattedAmount($orderDetail->sale_price) }}
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    <span>
                                                        {{ getFormattedAmount($orderDetail->quantity * $orderDetail->sale_price) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach

                                            <tr>
                                                <td colspan="5"><strong>Subtotal</strong></td>
                                                <td style="text-align: right">
                                                    <strong>
                                                        {{ getFormattedAmount($order->sub_total_amount) }}
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"><strong>Shipping Cost</strong></td>
                                                <td style="text-align: right">
                                                    <strong>
                                                        {{ getFormattedAmount($order->shipping_cost) }}
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"><strong>Discount</strong></td>
                                                <td style="text-align: right">
                                                    <strong>
                                                        {{ getFormattedAmount($order->discount_amount) }}
                                                    </strong>
                                                </td>
                                            </tr>
                                            </tr>

                                            <tr>
                                                <th class="">Total Amount</th>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th class="text-right"> {{ getFormattedAmount($order->total_amount) }}</th>
                                            </tr>

                                            @if($order->order->collected_amount > 0)
                                            <tr>
                                                <td colspan="5"><strong>Paid Amount</strong></td>
                                                <td style="text-align: right">
                                                    <strong>
                                                        {{ getFormattedAmount($order->order->collected_amount) }}
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"><strong>Due Amount</strong></td>
                                                <td style="text-align: right">
                                                    <strong>
                                                        {{ getFormattedAmount($order->order->amount_to_be_collect) }}
                                                    </strong>
                                                </td>
                                            </tr>
                                            @endif

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
                                    @php
                                        $total_qty = 0;
                                        $sub_total = 0;
                                        $total_amount = 0;
                                    @endphp

                                    @if (count($order?->order?->returns) > 0)
                                        <table id="purchaseTable" class="table table-hover order-list">
                                            @foreach ($order?->order?->returns as $key => $return)
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
                                                    @php
                                                        $quantity = 0;
                                                    @endphp
                                                    @foreach ($return->load('returnDetails')->returnDetails->load('product.productLanguages', 'sellerOrderDetails') as $key => $val)
                                                        @php
                                                            $quantity = $quantity + $val->quantity;
                                                            $total_qty = $total_qty + $val->quantity;
                                                            $sub_total = $val->sale_price * $val->quantity;
                                                            $total_amount = $total_amount + $sub_total;
                                                        @endphp
                                                        <tr class="parent-row">
                                                            <td>
                                                                <span
                                                                    class="product-name">{{ $val->product->getTranslation('short_title') }}</span>
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $val->quantity }}
                                                            </td>

                                                            <td class="text-center">
                                                                {{ getFormattedAmount($val->sellerOrderDetails->sale_price) }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ getFormattedAmount($sub_total) }}
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <th>Sub Total : </th>
                                                        <th class="text-center"></th>
                                                        <th class="text-center"></th>
                                                        <th id="subtotals" class="text-center">
                                                            {{ getFormattedAmount($return->sub_total_amount) }} </th>
                                                    </tr>

                                                    @if ($return->coupon_discount > 0)
                                                    <tr>
                                                        <th>Coupon Discount : </th>
                                                        <th class="text-center"></th>
                                                        <th class="text-center"></th>
                                                        <th id="coupon_discounts" class="text-center">
                                                            {{ getFormattedAmount($return->coupon_discount) }} </th>
                                                    </tr>
                                                    @endif
                                                    
                                                    <tr>
                                                        <th>Total : </th>
                                                        <th class="text-center"></th>
                                                        <th class="text-center"></th>
                                                        <th id="total-qty" class="text-center">
                                                            {{ getFormattedAmount($return->total_amount) }} </th>
                                                    </tr>

                                                </tbody>
                                            @endforeach
                                        </table>
                                    @else
                                        <p class="text-center">No Data Found</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.pages.order.partials.modal_change_status')
    @include('admin.pages.order.partials.modal_payment_status')
@stop

@push('scripts')
    <script>
        const clickUpdatePaymentStatus = () => {
            $('#showPaymentModal').modal('show');
        }
    </script>
@endpush
