@extends('admin.layouts.master')

@section('title', 'Services')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.config.more_settings.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Services')) }}</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <table id="dataTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Service Manager</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Location</th>
                        <th>Reporting Frequency</th>
                        <th>Funder Name</th>
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
@vite('resources/admin_assets/js/pages/config/service/index.js')
@endpush
