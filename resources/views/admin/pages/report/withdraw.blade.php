@extends('admin.layouts.master')

@section('title', 'Withdraw Report')

@section('content')

@php
    use App\Library\Helper;
    $user_role = App\Models\User::getAuthUser()->roles()->first();
    $hasPermission = Helper::hasAuthRolePermission('customer_create');
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Withdraw Report' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 mb-2">
                            <input type="hidden" id="fromDate" value="">
                            <input type="hidden" id="toDate" value="">
                            <div class="input-group with-icon">
                                <input type="text" name="date_range" class="form-control" id="daterangepicker-for-report" value="" style="border-radius: 4px; background: #fff; color: #000;"
                                placeholder="{{ inputDateFormat() }} - {{ inputDateFormat() }}" />
                                <i class="date-icon fa-solid fa-calendar-days"></i>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 mb-2 d-flex justify-content-end">
                            <button style="background: #4ace8b; color: #fff" class="btn mr-1" onclick="filterUsers()">Filter</button>
                            <button class="btn btn2-light-secondary" onclick="filterClear()">Clear Filter</button>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <table id="withdrawReportDataTable" class="table table-bordered role-data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Note</th>
                        <th>Created At</th>
                        <th>Operator</th>
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
@include('admin.assets.select2')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')
@include('admin.assets.datetimepicker')

@push('scripts')
@vite('resources/admin_assets/js/pages/report/withdraw.js')
@endpush
