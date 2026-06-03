@extends('admin.layouts.master')
@section('title', 'Orders')
@section('orders', 'active')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.seller.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Orders' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        @include('admin.pages.user.seller.partials.topbar', ['user', $user??''])
    </div>

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">

            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Invoice</th>
                        <th>Date Time</th>
                        <th>Customer Name</th>
                        <th>Sub Total Amount</th>
                        <th>Total Amount</th>
                        <th>Discount Amount</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Payment Type</th>
                        <th>Operator</th>
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
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/user/seller/order/index.js')
@endpush
