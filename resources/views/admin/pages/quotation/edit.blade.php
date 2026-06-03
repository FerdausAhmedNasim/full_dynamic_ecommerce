@extends('admin.layouts.master')

@section('title', 'Edit Quotation')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Edit Quotation' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="post" class="form" action="{{ route('admin.quotation.update', $order->id) }}" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{$error}}</div>
                    @endforeach
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Order Table *</h5>
                                <div class="table-responsive mt-3">
                                <table id="purchaseTable" class="table table-hover order-list">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th class="text-center">Stock Availability</th>
                                                <th class="">Quantity</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">SubTotal</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $qty =0; $subtotal = 0; @endphp

                                            @foreach ($orderDetails as $key => $order_detail)
                                            @if($order_detail->quantity>0)

                                            @php
                                                $qty = $qty + $order_detail->quantity;
                                                $subtotal = $order_detail->quantity*$order_detail->sale_price;
                                            @endphp
                                            <tr class="parent-row">
                                                <td>
                                                    <span class="product-name"> {{ $order_detail->product->title }} </span>
                                                    <input type="hidden" class="form-control product_id"
                                                        name="product_id[]" value="{{ $order_detail->product->id }}">
                                                </td>

                                                <td class="text-center">
                                                    {{ $order_detail?->stock?->quantity }}
                                                </td>

                                                <td>
                                                    <input class="form-control product-qty" type="number"
                                                        name="quantity[]" min="0" max="{{ $order_detail?->stock?->quantity }}" value="{{ $order_detail->quantity }}">
                                                </td>

                                                <td class="text-center">
                                                    {{ getFormattedAmount($order_detail->sale_price) }}
                                                    <input type="hidden" class="form-control sale_price"
                                                    name="sale_price[]" value="{{ $order_detail->sale_price }}" step="any" required>
                                                </td>

                                                <td class="sub-total-td text-center">
                                                    <span>
                                                        {{ formatPrice($subtotal) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="ibtnDel btn btn-md btn-danger">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </td>
                                                <input type="hidden" class="form-control sub_total" name="sub_total[]"
                                                    value="{{$subtotal}}" step="any" required>
                                            </tr>
                                            @endif
                                            @endforeach

                                        </tbody>
                                        <tfoot class="tfoot active">
                                            <tr>
                                                <th> Quantity</th>
                                                <th></th>
                                                <th id="total-qty" class=""> {{$qty}} </th>
                                                <th class="text-center"> Total Amount </th>
                                                <th id="total" class="text-center">
                                                    {{formatPrice($order->total_amount)}}
                                                </th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        <strong>Packaging Charge</strong>
                                    </label>
                                    <input type="number" name="packaging_cost" id="packaging_cost" class="form-control" value="{{ $order->packaging_cost }}"
                                        step="any">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        <strong>Delivery Charge</strong>
                                    </label>
                                    <input type="number" name="delivery_cost" id="delivery_cost" class="form-control" value="{{ $order->shipping_cost }}"
                                        step="any">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        <strong>Discount</strong>
                                    </label>
                                    <input type="number" name="discount_amount" id="discount_amount" class="form-control" value="{{ $order->discount_amount }}" step="any">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea rows="5" class="form-control" name="note"> {{ $order->note }} </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-none">
                            <select class="form-control " name="deleted_product[]" id="deleted_product" multiple>
                                @foreach($products as $key => $product)
                                <option value="{{ $product->id }}"
                                    {{(old("deleted_product") == $product->id) ? "selected" : ""}}>
                                    {{ $product->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" class="form-control total_amount" id="total_amount" name="total_amount" value="{{ $order->total_amount }}" step="any">
                        <div class="form-group">
                            {!! \App\Library\Html::btnSubmit() !!}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@stop
@include('admin.assets.select2')
@include('admin.assets.datetimepicker')

@push('scripts')
@vite('resources/admin_assets/js/pages/quotation/edit.js')
@endpush

