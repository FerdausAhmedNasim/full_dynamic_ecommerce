@extends('admin.layouts.master')

@section('title', __('Support Tickets'))

@section('content')

@php
    use App\Library\Helper;

    $hasPermission = Helper::hasAuthRolePermission('ticket_create');
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">
            {{ strtoupper('Support Tickets') }}
            </h4>
        </div>
    </div>

    <!-- TabMenu Start -->
    <div class="card shadow-sm">
        @include('admin.pages.ticket.partial.topbar')
    </div>
    <!-- TabMenu End -->

    <div class="tab-content mt-4">
        <div class="row">

            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body py-4">
                        <div class="tab-content tab-content-vertical">

                            <div class="tab-pane fade show active">
                                @yield('ticketContent')
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')
@include('admin.assets.summernote-text-editor')
@include('admin.assets.select2')

@push('styles')
    <style>
        .count {
            top: -3px !important;
        }
    </style>
@endpush
