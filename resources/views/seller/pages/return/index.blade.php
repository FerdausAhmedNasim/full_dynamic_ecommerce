@extends('seller.layouts.master')
@section('title', ' Return')
@section('content')

@php
use App\Library\Helper;
use App\Library\Enum;
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Return List' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
        <div id="filterArea" class="d-inline-flex justify-content-start">
                <ul class="nav nav-pills nav-pills-success"  role="tablist" >
                    @php $active_status = Enum::RETURN_STATUS_PENDING; @endphp
                    @foreach(Enum::getReturnStatusType() as $key => $value)
                        <li class="nav-item">
                            <a class="nav-link tab-menu {{ $active_status == $key ? 'active' : '' }}" href="#" onclick="filterStatus('{{ $key }}')">{{ $value }}</a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link tab-menu" href="#" onclick="filterStatus()">All</a>
                    </li>
                </ul>
            </div>

            <input type="hidden" id="status" value="{{ $active_status }}">

            <table id="dataTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#SL</th>
                        <th>Invoice</th>
                        <th>Seller Name</th>
                        <th>SubTotal</th>
                        <th>Shipping Cost</th>
                        <th>Total</th>
                        <th>Payment Amount</th>
                        <th>Status</th>
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
@include('admin.assets.select2')
@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/seller_assets/js/pages/return/index.js')
@endpush