@extends('seller.layouts.master')

@section('title', 'Posts')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Posts' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div id="filterArea" class="d-inline-flex justify-content-start">
                <ul class="nav nav-pills nav-pills-success" role="tablist">
                    @php $active_status = \App\Library\Enum::POST_TYPE_POLICY; @endphp

                    <li class="nav-item">
                        <a class="nav-link tab-menu {{ $active_status == 'policy' ? 'active' : '' }}" href="#"
                            onclick="filterPostStatus('policy')">Policy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab-menu {{ $active_status != 'policy' ? 'active' : '' }}" href="#"
                            onclick="filterPostStatus('others')">Others</a>
                    </li>

                </ul>
            </div>
            <input type="hidden" id="postStatus" value="{{ $active_status }}">

            <table id="postDataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Sending Date</th>
                        <th>Is Passed</th>
                        <th>Is Seen</th>
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
@vite('resources/employee_assets/js/post/index.js')
@endpush
