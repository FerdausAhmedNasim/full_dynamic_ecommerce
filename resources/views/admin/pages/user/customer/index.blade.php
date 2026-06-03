@extends('admin.layouts.master')

@section('title', 'Customer')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Customer' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div id="filterArea" class="d-inline-flex justify-content-start">
                <ul class="nav nav-pills nav-pills-success"  role="tablist" >
                    @php $active_status = \App\Library\Enum::USER_STATUS_ACTIVE; @endphp
                    @foreach(\App\Library\Enum::getUserStatus() as $key => $value)
                        <li class="nav-item">
                            <a class="nav-link tab-menu {{ $active_status == $key ? 'active' : '' }}" href="#" onclick="filterStatus({{ $key }})">{{ $value }}</a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link tab-menu" href="#" onclick="filterStatus(1, 'is_deleted')">Deleted</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link tab-menu" href="#" onclick="filterStatus('-1')">All</a>
                    </li>
                </ul>
            </div>

            <input type="hidden" id="memberStatus" value="{{ $active_status }}">
            <input type="hidden" id="isDeleted" value="0">

            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>#SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Customer Type</th>
                        <th>Operator</th>
                        <th>Status</th>
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
@vite('resources/admin_assets/js/pages/user/customer/index.js')
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
