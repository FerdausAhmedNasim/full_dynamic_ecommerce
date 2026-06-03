@extends('seller.layouts.master')

@section('title', 'Settlements')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Settlements' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
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

            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>Settlement No</th>
                        <th>Settlement Date</th>
                        <th>Total Sale</th>
                        <th>Commission</th>
                        <th>AD Cost</th>
                        <th>Amount</th>
                        <th>Start Date</th>
                        <th>End Date</th>
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
@vite('resources/seller_assets/js/pages/report/settlement.js')
@endpush
