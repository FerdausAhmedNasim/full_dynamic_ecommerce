@extends('admin.layouts.master')

@section('title', 'Expenses')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Expenses' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Time & Date</th>
                        <th>Note</th>
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
@vite('resources/admin_assets/js/pages/expense/index.js')
@endpush

