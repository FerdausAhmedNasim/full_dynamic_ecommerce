@extends('admin.layouts.master')

@section('title', 'Create Purchase')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Create Purchase' )) }}</h4>
        </div>
    </div>

    <form method="post" class="form" action="{{ route('admin.purchase.create') }}" enctype="multipart/form-data">
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

                            <div class="col-md-4">
                                <div class="form-group @error('purchase_date') error @enderror">
                                    <label class="required">{{ __('Purchase Date') }}</label>
                                    <input type="text" name="purchase_date" id="purchase_date"
                                        class="form-control datepicker-max-today" value="{{ old('purchase_date') }}"
                                        placeholder="{{ settings('date_format') }}">

                                    @error('purchase_date')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group  @error('supplier_id') error @enderror">
                                    <label class="required">{{ __('Supplier') }}</label>
                                    <select class="form-control" name="supplier_id" id="supplier_id">
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">
                                            {{ $supplier->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror

                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label class="required">{{ __('Select Product') }}</label>
                                <div class="search-box d-flex">
                                    <button type="button" class="btn btn-barcode"><i class="fa fa-barcode"></i>
                                    </button>
                                    <select class="form-control" name="product" id="product">
                                        <option value="" class="selected highlighted">Please type product code and
                                            select...</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-name="{{ $product->title }}"
                                            data-unit="{{ $product->unit }}">
                                            {{ $product->title }}
                                        </option>
                                        @endforeach
                                    </select>
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
                                                <th class="">Unit</th>
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

                                        </tbody>
                                        <tfoot class="tfoot">
                                            <tr>
                                                <th>Quantity </th>
                                                <th></th>
                                                <th id="total-qty" class="">0</th>
                                                <th colspan="4" class="text-right"> SubTotal </th>
                                                <th>
                                                    <input type="hidden" name="subtotal" id="subtotal"
                                                        class="form-control" value="0" step="any">
                                                </th>
                                                <th id="subtotal_section" class="text-center">00.00</th>
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
                                                            class="form-control" value="0" step="any">
                                                    </div>
                                                </th>
                                                <th class="text-center amount_th">00.00</th>
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
                                                            class="form-control" value="0" step="any">
                                                    </div>
                                                </th>
                                                <th class="text-center amount_th">00.00</th>
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
                                                            class="form-control" value="0" step="any">
                                                    </div>
                                                </th>
                                                <th class="text-center amount_th">00.00</th>
                                                <th></th>
                                            </tr>

                                            <tr>
                                                <th colspan="7" class="text-right">Total</th>
                                                <th>
                                                    <input type="hidden" class="form-control total_amount"
                                                        id="total_amount" name="total_amount" value="0" step="any">
                                                </th>
                                                <th id="total" class="text-center">00.00</th>
                                                <th></th>
                                            </tr>

                                            <tr>
                                                <th colspan="7" class="text-right">Pay</th>
                                                <th>
                                                    <div class="d-none amount_div">
                                                        <input type="number" name="total_pay_amount"
                                                            id="total_pay_amount" class="form-control" value="0"
                                                            step="any">
                                                    </div>
                                                </th>
                                                <th id="total_pay" class="text-center">00.00</th>
                                                <th></th>
                                            </tr>

                                            <tr>
                                                <th colspan="7" class="text-right">Due</th>
                                                <th>
                                                    <div class="d-none amount_div">
                                                        <input type="number" name="due_amount" id="due_amount"
                                                            class="form-control" value="0" step="any">
                                                    </div>
                                                </th>
                                                <th id="total_due" class="text-center">00.00</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
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
                                    <textarea rows="3" class="form-control" name="note"></textarea>
                                </div>
                            </div>
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
                    <div class="col-md-6 mb-2">
                        <div class="card pt-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="">
                                            <label class="">Amount</label>
                                            <input type="number" class="form-control text-right payment" name="amount[]"
                                                placeholder="" min="0">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="">
                                            <label>Transaction Id</label>
                                            <input type="number" class="form-control text-right trx_id" name="trx_id[]"
                                                placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="">
                                            <label class="">Payment Type</label>
                                            <select class="form-control" id="payment_type_1" name="payment_type[]">
                                                <option value="" selected disabled>
                                                    Select One
                                                </option>
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
            </div>
            <div class="text-right border-top">
                {!! \App\Library\Html::btnSubmit() !!}
            </div>
        </div>
    </form>
</div>


<div class="d-none" id="add_item">
    <div class="col-md-6 delete_extra_item mb-2">
        <div class="card">
            <div class="card-body">
                <div class="row d-flex flex-row-reverse mt-n3">
                    <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm remove">
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                </div>
                <div class="row">
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
@include('admin.assets.quantity-change-input')

@push('scripts')
@vite('resources/admin_assets/js/pages/purchase/create.js')
@endpush
