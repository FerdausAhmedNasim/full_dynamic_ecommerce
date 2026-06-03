@extends('seller.layouts.master')

@section('title', 'Balance History')

@section('content')

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Balance History' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="dataTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="50px">No</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Debit/Credit</th>
                        <th>Date</th>
                        <th>Sent By</th>
                        <th>Received By</th>
                        <th>Payment Method</th>
                        <th>Transaction Id</th>
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
@vite('resources/seller_assets/js/pages/balance_history/index.js')
@endpush
