@extends('public.member_dashboard.dashboard_master')

@section('title', 'My Return Details')

@section('order_return', 'active')

@section('member_content')

@php
use \App\Library\Enum;
@endphp

<div class="dashboard-order">
    <div class="title">
        <h2>My Return Details</h2>
        <span class="title-leaf title-leaf-gray">
            <svg class="icon-width bg-gray">
                <use xlink:href="{{ asset('frontend/svg/leaf.svg') }}#leaf"></use>
            </svg>
        </span>
    </div>

    <h4 class="mb-3">Invoice Number : <span class="fs-6">{{ $orderReturn->invoice_id }}</span></h4>
    <div class="order-tab dashboard-bg-box">
        <div class="table-responsive" style="min-height: 300px;">
            <table class="table order-table">
                <tbody>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Price</th>
                    </tr>
                    
                    @foreach ($orderReturn->returnDetails as $details)
                        <tr>
                            <td class="text-start">
                                <img width="50" src="{{ $details->product->getThumbnailImage() }}">
                            </td>
                            <td class="text-start">
                                {{ $details->product->getTranslation('short_title') }}
                                @if ($details?->load('sellerOrderDetails.productStock')?->sellerOrderDetails?->productStock?->variant_ids)
                                    <span>{{ getProductVariantValue($details?->productStock?->variant_ids) }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $details->quantity }}
                            </td>

                            <td class="text-center">
                                {{ getFormattedAmount($details->sale_price) }}
                            </td>
                        </tr>
                    @endforeach

                    @if ($orderReturn->coupon_discount > 0)
                        <tr>
                            <td class="text-end" colspan="3"><strong>Sub Total</strong></td>
                            <td class="text-center"><strong>{{ getFormattedAmount($orderReturn->sub_total_amount) }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-end" colspan="3"><strong>Coupon Discount</strong></td>
                            <td class="text-center"><strong>{{ getFormattedAmount($orderReturn->coupon_discount) }}</strong></td>
                        </tr>
                    @endif

                    <tr>
                        <td class="text-end" colspan="3"><strong>Total</strong></td>
                        <td class="text-center"><strong>{{ getFormattedAmount($orderReturn->total_amount) }}</strong></td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="card mt-5">
                <div class="card-header">Order return Note </div>
                <div class="card-body">
                    <p>{!! $orderReturn->note !!}</p>
                </div>
            </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush
