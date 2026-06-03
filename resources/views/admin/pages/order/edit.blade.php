@extends('admin.layouts.master')

@section('title', 'Edit Order')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Edit Order' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="post" class="form" action="{{ route('admin.order.update', $order->id) }}" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{$error}}</div>
                    @endforeach
                @endif

                <div class="row">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-12 border-bottom">
                                <div class="form-group text-center">
                                    <label>Invoice Number</label>
                                    <p><strong>{{ $order->order->invoice_id }}</strong> </p>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <h5>Order Table *</h5>
                                <div class="table-responsive mt-3">
                                <table id="purchaseTable" class="table table-hover order-list">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th class="">Quantity</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">SubTotal</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $qty =0; @endphp

                                            @foreach ($order->sellerOrderDetails as $key => $order_detail)
                                            <tr class="parent-row">
                                                <td>
                                                    <img width="50" src="{{ $order_detail->product?->getThumbnailImage() }}">
                                                    <span class="product-name">
                                                        {{ $order_detail?->product->getTranslation('short_title') }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <input class="form-control product-qty" type="number"
                                                        name="quantity[]" min="0" max="{{ $order_detail?->stock?->quantity+$order_detail->quantity }}" value="{{ $order_detail->quantity }}">
                                                </td>

                                                <td class="text-center">
                                                    {{ getFormattedAmount($order_detail->sale_price) }}
                                                    <input type="hidden" class="form-control sale_price"
                                                    name="sale_price" value="{{ $order_detail->sale_price }}" step="any" required>
                                                </td>

                                                <td class="sub-total-td text-center">
                                                    <span>
                                                        {{ formatPrice($order_detail->sale_price * $order_detail->quantity) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if (count($order->sellerOrderDetails) > 1)
                                                        <button type="button" class="ibtnDel btn btn-md btn-danger">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                                {{-- <input type="hidden" class="form-control sub_total" name="sub_total"
                                                    value="{{$order_detail->sale_price * $order_detail->quantity}}" step="any" required> --}}
                                                <input type="hidden" class="detail_id" name="detail_id" value="{{ $order_detail->id }}">
                                                <input type="hidden" class="product_id" name="product_id[]" value="{{ $order_detail?->product->id }}">
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="modal-footer justify-content-center col-md-12">
                        {!! \App\Library\Html::btnSubmit() !!}
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
@vite('resources/admin_assets/js/pages/order/edit.js')
@endpush

