@extends('admin.layouts.master')
@section('title', 'Payments')

@section('content')
@php
    use App\Library\Enum;
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Payments' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div id="filterArea" class="d-inline-flex justify-content-start">
                <ul class="nav nav-pills nav-pills-success"  role="tablist" >
                    @php $active_payment = Enum::PAYMENT_TYPE_TOURNAMENT; @endphp
                    @foreach(Enum::getPaymentType() as $key => $value)
                        <li class="nav-item">
                            <a class="nav-link tab-menu {{ $active_payment == $key ? 'active' : '' }}" href="#" onclick="filterPayments('{{ $key }}')">{{ $value }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <input type="hidden" id="paymentStatus" value="{{ $active_payment }}">

            <table class="table table-bordered no-footer dtr-inline" id="paymentDataTable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Amout</th>
                        <th>Payment Status</th>
                        <th>Payment Method</th>
                        <th>Payment By</th>
                        <th>Taken By</th>
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
    @vite('resources/admin_assets/js/pages/payment/index.js')
@endpush
