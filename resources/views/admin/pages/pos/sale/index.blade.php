@extends('admin.layouts.master')

@section('title', 'Sale Return')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Sale Return List' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>#SL</th>
                        <th>Return Invoice</th>
                        <th>Order Invoice</th>
                        <th>Return SubTotal</th>
                        <th>Packaging Cost</th>
                        <th>Delivery Cost</th>
                        <th>Discount</th>
                        <th>Total</th>
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

@include('admin.pages.return.partial.modal_order_get')
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/return/sale/index.js')
@endpush
