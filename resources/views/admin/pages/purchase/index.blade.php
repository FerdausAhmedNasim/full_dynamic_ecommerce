@extends('admin.layouts.master')

@section('title', 'Purchase')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Purchase' )) }}</h4>
        </div>
    </div>


    <div class="card shadow-sm">
        <div class="card-body">

            @include('admin.components.product_topbar')

            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>#SL</th>
                        <th>Invoice</th>
                        <th>Supplier Name</th>
                        <th>Supplier Mobile</th>
                        <th>Sub Total Amount</th>
                        {{-- <th>Vat Amount</th> --}}
                        <th>Packaging Cost</th>
                        <th>Shipping Cost</th>
                        <th>Discount Amount</th>
                        <th>Return Amount</th>
                        <th>Due Amount</th>
                        <th>Total Amount</th>
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
@vite('resources/admin_assets/js/pages/purchase/index.js')
@endpush
