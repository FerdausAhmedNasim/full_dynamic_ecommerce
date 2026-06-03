@extends('admin.layouts.master')

@section('title', __('Support Tickets'))

@section('content')

<div class="content-wrapper">

    @php
        use App\Library\Helper;
        $user_role = App\Models\User::getAuthUser()->roles()->first();
        $hasPermission = Helper::hasAuthRolePermission('ticket_create');
    @endphp

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ __('SUPPORT TICKETS' )}}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div id="filterArea" class="d-inline-flex justify-content-start">
                <ul class="nav nav-pills nav-pills-success" id="pills-tab" role="tablist">
                    @php
                         $active_status = \App\Library\Enum::TICKET_STATUS_OPEN;
                         $ticket = \App\Models\Ticket::where('assign_to_id', auth()->id())->count();
                    @endphp

                    <li class="nav-item">
                        <a class="nav-link tab-menu active"
                            href="#" onclick="filterStatus(1, 'to_me')">To Me
                            <b>({{ $ticket }})</b></a>
                    </li>

                    @foreach(\App\Library\Enum::getTicketStatus() as $key => $value)
                    <li class="nav-item">
                        <a class="nav-link tab-menu"
                            href="#" onclick="filterStatus('{{$key}}')">{{$value}}
                            <b>({{ $count_total[$key] }})</b></a>
                    </li>
                    @endforeach
                </ul>

                <input type="hidden" id="ticketStatus" value="{{ $active_status }}">
                <input type="hidden" id="toMe" value="0">
            </div>

            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th width="50px">No</th>
                        <th>Subject</th>
                        <th>Ticket For</th>
                        <th>Issue Type</th>
                        <th>Assign To</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Last Reply</th>
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
@vite('resources/admin_assets/js/pages/ticket/index.js')
@endpush
