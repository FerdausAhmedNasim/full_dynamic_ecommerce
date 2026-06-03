
@extends('admin.pages.ticket.partial.layout')

@section('title', __('All Tickets'))
@section('ticketContent')

@php
    use App\Library\Helper;

    $hasPermission = Helper::hasAuthRolePermission('ticket_create');
@endphp


    <div class="card-body ">

        <div id="filterArea" class="d-inline-flex justify-content-start">
            <ul class="nav nav-pills nav-pills-success" id="pills-tab" role="tablist">
                @php
                    $active_status = \App\Library\Enum::TICKET_STATUS_NEW;
                    $ticket = \App\Models\Ticket::where('assign_to_id', auth()->id())->count();
                @endphp

                <li class="nav-item">
                    <a class="nav-link tab-menu active"
                        href="#" onclick="filterStatus('{{$active_status}}')">New
                        <b>({{ $count_total[$active_status] }})</b></a>
                </li>

                @foreach(\App\Library\Enum::getTicketStatus() as $key => $value)
                    @if ($key == \App\Library\Enum::TICKET_STATUS_NEW)
                        @continue
                    @endif
                    <li class="nav-item">
                        <a class="nav-link tab-menu {{ $key == \App\Library\Enum::TICKET_STATUS_NEW ? 'active' : '' }}"
                            href="#" onclick="filterStatus('{{$key}}')">{{$value}}
                            <b>({{ $count_total[$key] }})</b></a>
                    </li>
                @endforeach
            </ul>

            <input type="hidden" id="ticketStatus" value="{{ $active_status }}">
        </div>

        <table id="ticketDataTable" class="table table-bordered ticket-data-table">
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


@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/ticket/all.js')
@endpush
