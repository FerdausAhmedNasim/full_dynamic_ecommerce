@extends('admin.layouts.master')

@section('title', 'Sale Return Details')

@section('content')

@php
    use App\Library\Helper;
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.return.index')) !!}
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
                                <th>Invoice Number</th>
                                <td>{{ $order_return->invoice_id }}</td>
                            </tr>
                            {{-- <tr>
                                <th>Sub Total Amount</th>
                                <td>{{ getFormattedAmount($order_return->sub_total_amount??0) }}</td>
                            </tr> --}}

                            <tr>
                                <th>Return Amount</th>
                                <td>{{ getFormattedAmount($order_return->total_amount ?? 0) }}</td>
                            </tr>

                            {{-- <tr>
                                <th>Shipping Cost</th>
                                <td>{{ getFormattedAmount($order_return->shipping_cost??0) }}</td>
                            </tr> --}}

                            <tr>
                                <th>Status</th>
                                <td class="d-flex justify-content-between">
                                    {!! $order_return?->statusHtml() !!}

                                    @if(Helper::hasAuthRolePermission('return_change_status'))
                                    <a class="text-secondary" onclick="ChangeStatus()" tooltip="Change Status">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    @endif

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <div class="card shadow-sm mt-3">
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
            </div> --}}
        </div>
        <div class="col-md-7 mb-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>Return Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table id="purchaseTable" class="table table-hover order-list">
                                    <thead>
                                        <tr>
                                            <th width="5%">Image</th>
                                            <th>Name</th>
                                            <th>Unit</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-right">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_qty = 0;
                                        @endphp

                                        @foreach ($return_details as $key => $return_detail)
                                        @php $total_qty = $total_qty + $return_detail->quantity; @endphp
                                        <tr class="parent-row">
                                            <td>
                                                <img width="50" src="{{ $return_detail?->product?->getThumbnailImage() }}">
                                            </td>
                                            <td>
                                                <span class="product-name"> {{ $return_detail?->product?->getTranslation('short_title') }} </span>
                                                @if ($return_detail?->load('sellerOrderDetails.productStock')?->sellerOrderDetails?->productStock?->variant_ids)
                                                    <br> <small>{{ getProductVariantValue($return_detail?->load('sellerOrderDetails.productStock')?->sellerOrderDetails?->productStock?->variant_ids) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $return_detail?->product?->unit ?? "N/A" }}
                                            </td>
                                            <td class="text-center">
                                                {{ $return_detail->quantity }}
                                            </td>
                                            <td class="text-right">
                                                {{ getFormattedAmount($return_detail->sale_price) }}
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot class="tfoot active">

                                        @if ($order_return->coupon_discount > 0)
                                            <tr>
                                                <th colspan="4" class="text-right">Sub Total</th>
                                                <th id="total-qty" class="text-right"> {{ getFormattedAmount($order_return->sub_total_amount) }} </th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" class="text-right">Coupon Discount</th>
                                                <th id="total-qty" class="text-right"> {{ getFormattedAmount($order_return->coupon_discount) }} </th>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th colspan="4" class="text-right">Total</th>
                                            <th id="total-qty" class="text-right"> {{ getFormattedAmount($order_return->total_amount) }} </th>
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
@include('admin.pages.return.partial.modal_change_status')
@stop


@push('scripts')
<script>
    $(document).ready(function () {
    const showChangeStatusModal5454545 = "#showChangeStatusModal5454545";

window.ChangeStatus = function () {
    // clearValidation(updateStatusForm);
    // alert(1);
    $(showChangeStatusModal5454545).modal('show');
}
});
</script>
@endpush
