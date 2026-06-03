@extends('seller.layouts.master')

@section('title', 'Ad Request')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Ad Request' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Ad Location</th>
                        <th>Ad Image</th>
                        <th>Seller</th>
                        <th>Amount</th>
                        <th>Status</th>
                        {{-- <th>Payment Status</th> --}}
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Product</th>
                        <th>Link</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.assets.preview-image')
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/seller_assets/js/pages/advertise/index.js')
@endpush

