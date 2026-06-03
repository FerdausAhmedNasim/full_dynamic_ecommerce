@extends('seller.layouts.master')

@section('title', 'Stock Assign')

@section('content')

@php
    $countAssignStocks = App\Models\StockAssign::whereUserId(auth()->id())->whereAcknowledgementStatus(0)->count('id');
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Stock Assign' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Unique ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Assign Date</th>
                        <th>Status</th>
                        <th>Acknowledgement Status</th>
                        <th>Acknowledgement</th>
                        <th>Operator</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('seller.pages.ams.stock_assign.partials.modal_change_status')
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/employee_assets/js/ams/stock_assign/index.js')

<script>
    $( document ).ready(function() {
        $('#acceptAll').addClass('d-none');

        let countStock = {{ $countAssignStocks }};

        if (countStock > 0) {
            $('#acceptAll').removeClass('d-none');
        }
    });
</script>

@endpush
