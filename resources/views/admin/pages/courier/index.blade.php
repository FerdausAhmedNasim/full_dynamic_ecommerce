@extends('admin.layouts.master')

@section('title', 'Courier Pricing Plan')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Courier Pricing Plan' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="dataTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Pickup Location</th>
                        <th>Delivery Location</th>
                        <th>Weight</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Delivery Time</th>
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
    @vite('resources/admin_assets/js/pages/courier/index.js')
@endpush


@push('styles')
    <style>
        .custom-switch, .custom-control-label {
            cursor: pointer;
        }
        .switch .tooltiptext {
            visibility: hidden;
        }

        /* tooltip */
        .custom-switch .tooltiptext {
            visibility: hidden;
            width: auto;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 7px 10px;
            position: absolute;
            z-index: 1;
            bottom: 30px;
            left: calc(6% - 25px);
        }

        .custom-switch .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: black transparent transparent transparent;
        }

        .custom-switch:hover .tooltiptext {
            visibility: visible;
        }

        .custom-switch .custom-control-input:disabled:checked~.custom-control-label::before {
            background-color: #838d9480;
        }
        .custom-control-input:checked~.custom-control-label::before {
            border-color: #6b777f80;
        }
        .custom-control-input[disabled]~.custom-control-label, .custom-control-input:disabled~.custom-control-label {
            cursor: not-allowed;
        }
    </style>
@endpush
