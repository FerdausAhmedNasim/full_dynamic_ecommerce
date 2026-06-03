@extends('admin.layouts.master')
@section('title', 'Subscribers')

@section('content')
@php
use App\Library\Helper;
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Subscribers' )) }}</h4>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body">

                    <table id="dataTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Email</th>
                                <th>Subscribe At</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@stop
@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/subscriber/index.js')
@endpush