@extends('admin.layouts.master')

@section('title', 'Edit Purchase')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Edit Purchase' )) }}</h4>
        </div>
    </div>

    <form method="post" class="form" action="{{ route('admin.purchase.update', $order->id) }}"
        enctype="multipart/form-data">
        @csrf

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div>{{$error}}</div>
        @endforeach
        @endif
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-center">
                                    <label>Invoice Number</label>
                                    <p><strong>{{ $order->invoice_id }}</strong> </p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group @error('purchase_date') error @enderror">
                                    <label class="required">{{ __('Purchase Date') }}</label>
                                    <input type="text" name="purchase_date" id="purchase_date"
                                        class="form-control datepicker-max-today"
                                        value="{{ old('purchase_date', getFormattedDate($stocks[0]->purchase_date)) }}"
                                        placeholder="{{ settings('date_format') }}">

                                    @error('purchase_date')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group  @error('supplier_id') error @enderror">
                                    <label class="required">{{ __('Supplier') }}</label>
                                    <select class="select form-control" name="supplier_id" id="supplier_id">
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ old('supplier_id', $order->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <h5>Purchase Table *</h5>
                                <div class="table-responsive mt-3">
                                    <table id="purchaseTable" class="table table-hover order-list">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th class="text-center">Unit</th>
                                                <th class="">Quantity</th>
                                                <th class="">Purchase Price</th>
                                                <th class="">Sale Price</th>
                                                <th class="">Special Price</th>
                                                <th class="">Stock alert</th>
                                                <th class="">Warranty</th>
                                                <th class="text-center">SubTotal</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $total_qty = 0;
                                            @endphp
                                            @foreach ($stocks as $key => $stock)
                                            <tr class="parent-row">
                                                <td>
                                                    <span class="product-name"> {{ $stock->product->title }} </span>
                                                    <input type="hidden" class="form-control product_id"
                                                        name="product_id[]" value="{{ $stock->product->id }}">
                                                </td>

                                                <td class="text-center">
                                                    {{ $stock->product->unit }}
                                                </td>

                                                <td>
                                                    <input class="form-control product-qty" type="number"
                                                        name="quantity[]" min="1" value="{{ $stock->quantity }}">
                                                    @php $total_qty = $total_qty + $stock->quantity; @endphp
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control purchase_price"
                                                        name="purchase_price[]" value="{{ $stock->purchase_price }}"
                                                        step="any" required>
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control sale_price"
                                                        name="sale_price[]" value="{{ $stock->sale_price }}" step="any"
                                                        required>
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control special_price"
                                                        name="special_price[]" value="{{ $stock->special_price }}"
                                                        step="any">
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control stock_alert"
                                                        name="stock_alert[]" value="{{ $stock->stock_alert }}" min="1"
                                                        required>
                                                </td>
                                                <td class="text-center">
                                                    <div class="input-group with-icon">
                                                        <input type="date" name="warranty_date[]"
                                                            value="{{ $stock->warranty_date }}"
                                                            class="form-control warranty_date" placeholder="">

                                                    </div>
                                                </td>
                                                <td class="sub-total-td text-center">
                                                    <span> {{ formatPrice($stock->quantity * $stock->purchase_price) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="ibtnDel btn btn-md btn-danger">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </td>
                                                <input type="hidden" class="form-control sub_total" name="sub_total[]"
                                                    value="{{ $stock->quantity * $stock->purchase_price }}" step="any"
                                                    required>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot class="tfoot">
                                            <tr>
                                                <th>Quantity </th>
                                                <th></th>
                                                <th id="total-qty" class="">{{ $total_qty }}</th>
                                                <th colspan="4" class="text-right"> SubTotal </th>
                                                <th>
                                                    <input type="hidden" name="subtotal" id="subtotal"
                                                        class="form-control" value="0" step="any">
                                                </th>
                                                <th id="subtotal_section" class="text-center">
                                                    {{ formatPrice($order->sub_total_amount) }}</th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th colspan="7" class="text-right">
                                                    Packaging Charge
                                                    <i class="fa fa-edit amount_update ml-2"></i>
                                                </th>
                                                <th>
                                                    <div class="d-none amount_div">
                                                        <input type="number" name="packaging_cost" id="packaging_cost"
                                                            class="form-control" value="{{ $order->packaging_cost }}"
                                                            step="any">
                                                    </div>
                                                </th>
                                                <th class="text-center amount_th">
                                                    {{ formatPrice($order->packaging_cost) }}</th>
                                                <th></th>
                                            </tr>

                                            <tr>
                                                <th colspan="7" class="text-right">
                                                    Delivery Charge
                                                    <i class="fa fa-edit amount_update ml-2"></i>
                                                </th>
                                                <th>
                                                    <div class="d-none amount_div">
                                                        <input type="number" name="delivery_cost" id="delivery_cost"
                                                            class="form-control" value="{{ $order->shipping_cost }}"
                                                            step="any">
                                                    </div>
                                                </th>
                                                <th class="text-center amount_th">
                                                    {{ formatPrice($order->shipping_cost) }}</th>
                                                <th></th>
                                            </tr>

                                            <tr>
                                                <th colspan="7" class="text-right">
                                                    Discount
                                                    <i class="fa fa-edit amount_update ml-2"></i>
                                                </th>
                                                <th width="10%">
                                                    <div class="d-none amount_div">
                                                        <input type="number" name="discount_amount" id="discount_amount"
                                                            class="form-control" value="{{ $order->discount_amount }}"
                                                            step="any">
                                                    </div>
                                                </th>
                                                <th class="text-center amount_th">
                                                    {{ formatPrice($order->discount_amount) }}</th>
                                                <th></th>
                                            </tr>

                                            <tr>
                                                <th colspan="7" class="text-right">Total</th>
                                                <th>
                                                    <input type="hidden" class="form-control total_amount"
                                                        id="total_amount" name="total_amount"
                                                        value="{{ $order->total_amount }}" step="any">
                                                </th>
                                                <th id="total" class="text-center">
                                                    {{ formatPrice($order->total_amount) }}</th>
                                                <th></th>
                                            </tr>

                                            <tr>
                                                <th colspan="7" class="text-right">Pay</th>
                                                <th>
                                                    <div class="d-none amount_div">
                                                        <input type="number" name="total_pay_amount"
                                                            id="total_pay_amount" class="form-control"
                                                            value="{{ $order->total_amount - $order->due_amount }}"
                                                            step="any">
                                                    </div>
                                                </th>
                                                <th id="total_pay" class="text-center">
                                                    {{ formatPrice($order->total_amount - $order->due_amount) }}</th>
                                                <th></th>
                                            </tr>

                                            <tr>
                                                <th colspan="7" class="text-right">Due</th>
                                                <th>
                                                    <div class="d-none amount_div">
                                                        <input type="number" name="due_amount" id="due_amount"
                                                            class="form-control" value="{{ $order->due_amount }}"
                                                            step="any">
                                                    </div>
                                                </th>
                                                <th id="total_due" class="text-center">
                                                    {{ formatPrice($order->due_amount) }}</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header d-flex justify-content-between">
                <h6>Payment</h6>
                <button type="button" class="btn btn-outline-primary btn-sm" id="add_payment_row">
                    <i class="ti-plus"></i>
                </button>
            </div>

            <div class="card-body col-md-12">
                <div class="payments_div row">
                @foreach ($paymentDetails as $key => $paymentDetail)
                    <div class="col-md-6 mb-2">
                    <input type="hidden" name="payment_id[]" value="{{ $paymentDetail->id }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="">
                                            <label class="required">Amount</label>
                                            <input type="number" class="form-control text-right payment" name="amount[]"
                                                placeholder="" min="0" value="{{ $paymentDetail->amount }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="">
                                            <label>Transaction Id</label>
                                            <input type="number" class="form-control text-right trx_id" name="trx_id[]"
                                                placeholder="" value="{{ $paymentDetail->trx_id }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="">
                                            <label class="required">Payment Type</label>
                                            <select class="form-control" id="payment_type_1" name="payment_type[]"
                                                required>
                                                <option value="" selected disabled>Select One</option>
                                                @foreach ($paymentMethods as $key => $paymentMethod)
                                                <option value="{{ $paymentMethod }}"
                                                {{ old('payment_type', $paymentDetail->payment_method) == $paymentMethod ? 'selected' : '' }}>
                                                    {{ $paymentMethod }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            <div class="text-right border-top">
                {!! \App\Library\Html::btnSubmit() !!}
            </div>
        </div>
    </form>
</div>

<div class="d-none" id="add_item">
    <div class="col-md-6 delete_extra_item mb-2">
        <input type="hidden" name="payment_id[]" value="">
        <div class="card">
            <div class="card-body">
                <div class="row d-flex flex-row-reverse">
                    <button type="button" class="btn btn-outline-secondary btn-sm mt-n2 remove">
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                </div>
                <div class="row mt-n4">
                    <div class="col-md-4">
                        <div class="">
                            <label class="required">Amount</label>
                            <input type="number" class="form-control text-right payment" min="0" name="amount[]"
                                placeholder="" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="">
                            <label>Transaction Id</label>
                            <input type="number" class="form-control text-right trx_id" name="trx_id[]" placeholder="">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="">
                            <label class="required">Payment Type</label>
                            <select class="form-control" name="payment_type[]" required>
                                <option value="" selected disabled>Select One</option>
                                @foreach ($paymentMethods as $key => $paymentMethod)
                                <option value="{{ $paymentMethod }}">
                                    {{ $paymentMethod }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@include('admin.assets.select2')
@include('admin.assets.datetimepicker')

@push('scripts')
@vite('resources/admin_assets/js/pages/purchase/edit.js')
@endpush
