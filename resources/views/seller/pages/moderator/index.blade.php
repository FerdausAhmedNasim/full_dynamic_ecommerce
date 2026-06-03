@extends('seller.layouts.master')
@section('title', 'Moderators')
@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Moderators' )) }}</h4>
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
                </ul>
            </div>

            <input type="hidden" id="employeeStatus" value="{{ $active_status }}">
            <input type="hidden" id="isDeleted" value="0">

            <table id="dataTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>DOB</th>
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
@vite('resources/seller_assets/js/pages/moderator/index.js')
@endpush
