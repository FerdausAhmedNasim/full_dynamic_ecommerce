@extends('public.member_dashboard.dashboard_master')

@section('title', 'Order Return')

@section('order', 'active')

@section('member_content')
@php
use \App\Library\Enum;
@endphp
<div class="dashboard-order">
    <div class="title">
        <h2>Order Return</h2>
        <span class="title-leaf title-leaf-gray">
            <svg class="icon-width bg-gray">
                <use xlink:href="{{ asset('frontend/svg/leaf.svg') }}#leaf"></use>
            </svg>
        </span>
    </div>

    <div class="accordion accordion-box">
        @foreach($order->sellerOrders as $key => $sellerOrder)
        <form method="POST" class="" action="{{ route('dashboard.order.return.store', $sellerOrder->id) }}">
            @csrf
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button">
                        {{ $sellerOrder?->store?->getTranslation('store_name') }}
                        <span class="text-capitalize">Status : {{$sellerOrder->order_status}}</span>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapse{{$key}}" class="accordion-collapse collapse show"
                    aria-labelledby="panelsStayOpen-heading{{$key}}">
                    <div class="accordion-body">
                        <div class="cart-table order-table">

                            <div class="table-responsive">
                                <table class="table mb-0 order-table-{{$sellerOrder->id}}">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Return Quantity</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Choice</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            $subTotals = $sellerOrder->sellerOrderDetails->sum('sale_price');
                                            echo $subTotals;
                                        @endphp

                                        @foreach ($sellerOrder->sellerOrderDetails->load('product', 'sellerOrder.seller') as $orderDetails)
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
                                            @php
                                                $ezzicoDiscount = $orderDetails->product->getEzzicoDiscount($orderDetails->product->getPriceAfterDiscount());
                                            @endphp
                                            <td class="price">
                                                {{-- @if ($orderDetails->product->has_discount)
                                                    <h6>{{ getFormattedAmount($orderDetails->product->getPriceAfterDiscount() - $ezzicoDiscount) }}</h6>
                                                @else
                                                    <h6>{{ getFormattedAmount($orderDetails->product->unit_price - $ezzicoDiscount) }}</h6>
                                                @endif --}}
                                                <h6>{{ getFormattedAmount($orderDetails->sale_price) }}</h6>
                                            </td>

                                            <td class="">
                                                <h4 class="text-title">{{$orderDetails->quantity}}</h4>
                                            </td>

                                            <td class="quantity">
                                                <div class="counter-number d-flex justify-content-center">
                                                    <div class="counter quantity">

                                                        @if ($couponDiscount <= 0)
                                                            <div class="qty-left-minus minus" data-type="minus"
                                                                data-field="">
                                                                <i class="fa-solid fa-minus"></i>
                                                            </div>
                                                        @endif

                                                        <input class="form-control input-number qty-input return-qty"
                                                            type="number" name="quantity[]"
                                                            step="any" min="0" value="{{ $couponDiscount > 0 ? $orderDetails->quantity : 0 }}"
                                                            max="{{$orderDetails->quantity}}" readonly >

                                                        @if ($couponDiscount <= 0)
                                                            <div class="qty-right-plus plus" data-type="plus" data-field="">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </td>

                                            <td class="price">
                                                <h6>{{ getFormattedAmount($orderDetails->quantity * $orderDetails->sale_price) }}</h6>
                                            </td>
                                            <td class="text-center">
                                                @if($sellerOrder->order_status == \App\Library\Enum::ORDER_STATUS_TYPE_DELIVERED)
                                                    @if ($couponDiscount > 0)
                                                        <input type="checkbox" class="is_return" checked disabled>
                                                        <input type="hidden" class="is_return" name="is_return[]" value="1">
                                                    @else 
                                                        <input type="checkbox" class="is_return" name="is_return[]" value="1">
                                                        <input type="hidden" class="is_return_demo" name="is_return[]" value="0">
                                                    @endif
                                                @else
                                                    <span class="text-danger">x</span>
                                                @endif
                                            </td>

                                            <input type="hidden" class="seller_order_details" name="seller_order_details[]" value="{{ $orderDetails->id }}">
                                            <input type="hidden" class="sale_price" name="sale_price[]" value="{{ $orderDetails->sale_price }}" step="any" required>
                                            <input type="hidden" class="product_id" name="product_id[]" value="{{ $orderDetails->product_id }}" step="any" required>
                                            <input type="hidden" class="seller_order_id" name="seller_order_id" value="{{$sellerOrder->id}}" step="any" required>

                                            <input type="text" name="coupon_discount" value="{{ $couponDiscount }}">

                                            @if ($couponDiscount <= 0)
                                                <input type="hidden" class="sub_total" name="sub_total[]" value="0" step="any" required>
                                            @else
                                                <input type="hidden" class="sub_total" name="sub_total" value="{{ $couponDiscount <= 0 ? 0 : $subTotals }}" step="any" required>
                                            @endif

                                            <input type="text" class="total_amount" name="total_amount" value="{{ $couponDiscount <= 0 ? 0 : $subTotals - $couponDiscount }}" step="any" required>

                                        </tr>
                                        @endforeach
                                    </tbody>

                                    @if($sellerOrder->order_status == \App\Library\Enum::ORDER_STATUS_TYPE_DELIVERED)
                                    <tfoot>
                                        <tr>
                                            <th  colspan="4" style="text-align: right;">
                                                <h5><strong>Return Quantity</strong></h5>
                                            </th>
                                            <th class="text-center" >
                                                <h5 class="total-quantity" id="total-qty-{{ $sellerOrder->id }}">
                                                    <strong>{{ $couponDiscount <= 0 ? 0 : $sellerOrder->quantity }}</strong>
                                                </h5>
                                            </th>
                                            <th></th>
                                        </tr>

                                        @if ($couponDiscount > 0)
                                            <tr>
                                                <th colspan="4" style="text-align: right;">
                                                    <h5><strong>Subtotal</strong></h5>
                                                </th>
                                                <th class="text-center" >
                                                    <h5 class="total-quantity" id="subTotal">
                                                        <strong>{{ getFormattedAmount($subTotals) }}</strong>
                                                    </h5>
                                                </th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" style="text-align: right;">
                                                    <h5><strong>Coupon Discount</strong></h5>
                                                </th>
                                                <th class="text-center" >
                                                    <h5 class="total-quantity" id="couponDiscount">
                                                        <strong>{{ getFormattedAmount($couponDiscount) }}</strong>
                                                    </h5>
                                                </th>
                                                <th></th>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th colspan="4" style="text-align: right;">
                                                <h5> <strong>Total</strong> </h5>
                                            </th>
                                            <th class="text-center">
                                                <h5 class="total-price" id="total-amount-{{$sellerOrder->id}}">
                                                    <strong>{{ $couponDiscount <= 0 ? '$ 0.0' : getFormattedAmount($subTotals - $couponDiscount) }}</strong>
                                                </h5>
                                            </th>
                                            <th></th>
                                        </tr>

                                    </tfoot>
                                    @endif
                                </table>
                            </div>

                            @if($sellerOrder->order_status == \App\Library\Enum::ORDER_STATUS_TYPE_DELIVERED)
                            <div class="p-4">
                                <div class="form-floating mb-4 theme-form-floating">
                                    <textarea type="text" class="form-control" name="note"
                                        placeholder="Leave a comment here" id="note" style="height: 100px"></textarea>
                                    <label for="address">Note About Return</label>
                                </div>

                                <div class="d-flex gap-3 justify-content-end">
                                    <button type="button" class="btn btn-animation btn-md fw-bold">Cancel</button>
                                    <button type="submit"
                                        class="btn theme-bg-color btn-md fw-bold text-light submit-btn" onclick="submitForm(event, {{$sellerOrder->id}})">Return</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endforeach
    </div>

</div>
@endsection

@push('styles')
<style>
    .total-amount-div {
        margin-bottom: 25px !important;
        margin-right: 20% !important;
    }
    .accordion.accordion-box .accordion-item .accordion-header .accordion-button::after{
            content: '';
        }
</style>
@endpush

@push('scripts')
@vite('resources/frontend_assets/js/pages/return/create.js')
@endpush