@extends('admin.layouts.master')

@section('title', 'Create Sale Return')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Create Sale Return' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="post" class="form" action="{{ route('admin.return.sale.create', $order->id) }}"
                enctype="multipart/form-data">
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
                                <div class="form-group text-center">
                                    <label>Order Invoice Number</label>
                                    <p><strong>{{ $order->invoice_id }}</strong> </p>
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-12">
                                <h5>Sale Return Table *</h5>
                                <div class="table-responsive mt-3">
                                    <table id="purchaseTable" class="table table-hover order-list">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th class="">Available Quantity</th>
                                                <th class="">Return Quantity</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">SubTotal</th>
                                                <th class="text-center">Choice</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($orderDetails as $key => $order_detail)
                                            @if($order_detail->quantity>0)
                                            <tr class="parent-row">
                                                <td>
                                                    <span class="product-name"> {{ $order_detail->product->title }}
                                                    </span>
                                                    <input type="hidden" class="form-control product_id"
                                                        name="product_id[]" value="{{ $order_detail->product->id }}">
                                                </td>
                                                <td>
                                                    {{ $order_detail->quantity - $order_detail->return_quantity }}
                                                    <input class="form-control product-qty" type="hidden"
                                                        name="quantity[]" min="0"
                                                        max="{{ $order_detail->quantity - $order_detail->return_quantity }}"
                                                        value="{{ $order_detail->quantity - $order_detail->return_quantity }}"
                                                        readonly>
                                                </td>
                                                <td>
                                                    <input class="form-control return-qty" type="number"
                                                        name="return_quantity[]" min="0"
                                                        max="{{ $order_detail->quantity - $order_detail->return_quantity }}"
                                                        value="0" readonly>
                                                </td>
                                                <td class="text-center">
                                                    {{ getFormattedAmount($order_detail->sale_price) }}
                                                    <input type="hidden" class="form-control sale_price"
                                                        name="sale_price[]" value="{{ $order_detail->sale_price }}"
                                                        step="any" required>
                                                </td>

                                                <td class="sub-total-td text-center">
                                                    <span> {{ formatPrice(0) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="is_return" name="is_return[]"
                                                        value="1">
                                                    <input type="hidden" class="is_return_demo" name="is_return[]"
                                                        value="0">
                                                </td>
                                                <input type="hidden" class="form-control sub_total" name="sub_total[]"
                                                    value="0" step="any" required>
                                            </tr>
                                            @endif
                                            @endforeach

                                        </tbody>
                                        <tfoot class="tfoot active">
                                            <tr>
                                                <th colspan="2">Return Quantity</th>
                                                <th id="total-qty" class=""> 0 </th>
                                                <th class="text-center"> Total Return Amount </th>
                                                <th id="total" class="text-center">
                                                    {{ formatPrice(0) }} </th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <strong>Packaging Charge</strong>
                                    </label>
                                    <input type="number" name="refund_packaging_amount" id="packaging_cost"
                                        class="form-control" value="0" step="any">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <strong>Delivery Charge</strong>
                                    </label>
                                    <input type="number" name="refund_delivery_amount" id="delivery_cost"
                                        class="form-control" value="0" step="any">
                                </div>
                            </div>
                            <div class="col-md-4 d-none">
                                <div class="form-group">
                                    <label>
                                        <strong>Discount on subtotal</strong>
                                    </label>
                                    <input type="number" name="refund_discount_amount" id="discount_amount"
                                        class="form-control" value="0" step="any">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div id="dynamic_field" class="col-md-12">
                                <label>
                                    <strong>Attachments</strong>
                                </label>
                                <div class="row">
                                    <div class="col-xl-4 col-sm-4 col-12">
                                        <div class="form-group @error('name') error @enderror">
                                            <input type="text" name="name[]" id="name1" onkeyup="attachmentRequired(1)"
                                                class="form-control" value="{{ old('name[]') }}"
                                                placeholder="File Name">
                                            @error('name')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-xl-6 col-sm-6 col-12">
                                        <div class="form-group @error('attachment') error @enderror">
                                            <div class="file-upload-section d-flex d-inline-flex w-100">
                                                <div class="input-group">
                                                    <input type="text" class="form-control file-upload-info" disabled=""
                                                        readonly placeholder="Size: 200x200 and 500kB">
                                                    <span>
                                                        <button
                                                            class="file-upload-browse btn btn-outline-secondary pb-3"
                                                            type="button"><i class="fas fa-upload"></i></button>
                                                    </span>
                                                </div>
                                                <input name="attachment[]" id="attachment1"
                                                    onchange="attachmentRequired(1)" type="file"
                                                    class="form-control hidden-file" allowed="*">
                                                @error('attachment')
                                                <p class="error-message">{{ $message }}</p>
                                                @enderror
                                                <div class="display-input-image display-input-image2 d-none">
                                                    <img src="" alt="Preview Image" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex align-items-center">
                                        <div class="form-group @error('user.avatar') error @enderror ">
                                            <button type="button" class="btn btn2-secondary btn-sm" id="add">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
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


                        <input type="hidden" class="form-control total_amount" id="total_amount" name="total_amount"
                            value="{{ $order->total_amount }}" step="any">
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
@vite('resources/admin_assets/js/pages/return/sale/create.js')
@endpush