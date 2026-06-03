@extends('admin.layouts.master')

@section('title', 'Discount')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.config.more_settings.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Discount' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="dataTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Operator Name</th>
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
@vite('resources/admin_assets/js/pages/config/discount/index.js')
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
            left: calc(15% - 25px);
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
    </style>
@endpush
