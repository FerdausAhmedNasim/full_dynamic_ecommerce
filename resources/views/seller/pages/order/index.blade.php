@extends('seller.layouts.master')

@section('title', 'Orders')

@section('content')

@push('styles')
    <style>
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            display: none !important;
        }

        .select2-container .select2-selection--single {
            height: 45.19px !important;
        }
    </style>
@endpush

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Orders' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">
                <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">
                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 mb-2">
                            <select class="form-control" required id="status" multiple>
                                @foreach(\App\Library\Enum::getOrderStatusType() as $index => $value)
                                    <option class="text-capitalize" value="{{ $index }}">
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 mb-2">
                            <select class="form-control" required id="range">
                                <option value="latest_on_top">Latest On Top</option>
                                <option value="oldest_on_top">Oldest On Top</option>
                                <option value="total_low_high">Order Amount(Low > High)</option>
                                <option value="total_high_low">Order Amount(High > Low)</option>
                                {{-- <option value="quantity_low_high">Quantity(Low > High)</option>
                                <option value="quantity_high_low">Quantity(High > Low)</option> --}}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">
                    <div class="row">
                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 mb-2">
                            <input type="hidden" id="fromDate" value="">
                            <input type="hidden" id="toDate" value="">
                            <div class="input-group with-icon">
                                <input type="text" name="date_range" class="form-control" id="daterangepicker-for-report" value="" style="border-radius: 4px; background: #fff; color: #000;"
                                placeholder="{{ inputDateFormat() }} - {{ inputDateFormat() }}" />
                                <i class="date-icon fa-solid fa-calendar-days"></i>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 mb-2 d-flex justify-content-end">
                            <button style="background: #4ace8b; color: #fff" class="btn mr-1" onclick="filterOrders()">Filter</button>
                            <button class="btn btn2-light-secondary" onclick="filterClear()">Clear Filter</button>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Invoice Number</th>
                        <th>Date Time</th>
                        <th>Customer Name</th>
                        <th>Customer Mobile</th>
                        <th>Sub Total Amount</th>
                        <th>Discount Amount</th>
                        <th>Total Amount</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Payment Type</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


@stop

@include('admin.assets.dt')
@include('admin.assets.select2')
@include('admin.assets.dt-buttons')
@include('admin.assets.datetimepicker')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/seller_assets/js/pages/order/index.js')
@endpush
