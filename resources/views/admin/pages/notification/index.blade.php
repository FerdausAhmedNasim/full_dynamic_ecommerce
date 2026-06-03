@extends('admin.layouts.master')

@section('title', 'Notifications')

@section('content')

@php
    use App\Library\Helper;
    $user_role = App\Models\User::getAuthUser()->roles()->first();
    $hasPermission = Helper::hasAuthRolePermission('notification_create');
@endphp


<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Notifications' )) }}</h4>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">

            {{-- <div id="filterArea" class="d-inline-flex justify-content-start">
                <ul class="nav nav-pills nav-pills-success" role="tablist">
                    <li class="nav-item">
                        <div class="form-check form-check-secondary mr-5">
                            <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" id="is_for_emp" value="is_for_emp">
                                Employee
                            <i class="input-helper"></i></label>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="form-check form-check-secondary mr-5">
                            <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" id="is_for_member" value="is_for_member">
                                Client
                            <i class="input-helper"></i></label>
                        </div>
                    </li>
                </ul>
            </div> --}}

            <table id="dataTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Operator</th>
                        <th>Subject</th>
                        <th>Send Date</th>
                        <th>Created At</th>
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
@vite('resources/admin_assets/js/pages/notification/index.js')
@endpush
