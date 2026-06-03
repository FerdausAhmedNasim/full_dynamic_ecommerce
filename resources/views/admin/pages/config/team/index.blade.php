@extends('admin.layouts.master')

@section('title', 'Team')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.config.more_settings.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Team')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table id="teamDataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Team Name</th>
                        <th>Parent Team</th>
                        <th>Team Leader / Manager</th>
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

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/team/index.js')
@endpush
