@extends('admin.layouts.master')

@section('title', 'Alert Products')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Alert Products' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="stockReportDataTable" class="table table-bordered role-data-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Alert Quantity</th>
                        <th>Current Stock</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@push('styles')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            width: 99% !important;
        }
    </style>
@endpush

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/product/alert.js')
@endpush
