@extends('admin.layouts.master')

@section('title', 'Orders')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.customer.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Orders' )) }}</h4>
        </div>
    </div>

    <!-- TabMenu Start -->
    <div class="card shadow-sm">
        @include('admin.pages.user.customer.partials.topbar', ['user', $user])
    </div>
    <!-- TabMenu End -->

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">

            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Invoice</th>
                        <th>Sub Total Amount</th>
                        <th>Total Amount</th>
                        <th>Discount Amount</th>
                        <th>Shipping Cost</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Return Status</th>
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
@vite('resources/admin_assets/js/pages/user/customer/order/index.js')
@endpush
