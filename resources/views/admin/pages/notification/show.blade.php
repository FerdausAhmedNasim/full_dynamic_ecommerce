@extends('admin.layouts.master')

@section('title', 'Notification Details')

@section('content')

@php
use App\Library\Helper;
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.notification.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Notification Details')) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <!-- Home Content -->
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <div class="border-bottom text-center pb-2">
                        <div class="mb-3">
                            <h3>{{$notification->subject}}</h3>
                        </div>

                        <p class="mx-auto mb-2">
                            {{ $notification->subject }}
                        </p>
                    </div>

                    <div class="text-center mt-4 nav-tab">

                        @if(Helper::hasAuthRolePermission('notification_delete'))
                        <button class="btn btn-sm btn-danger mb-2"
                            onclick="confirmFormModal('{{ route('admin.notification.delete.api', $notification->id) }}', 'Confirmation', 'Are you sure to delete operation?')"><i
                                class="fas fa-trash-alt"></i> Delete </button>
                        @endif

                    </div>
                </div>
            </div>
            <!-- End Home Content-->

            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title">Message</h4>
                </div>
                <div class="card-body table-responsive">
                    {!! $notification->message !!}
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body table-responsive">
                    <table class="table org-data-table table-bordered">
                        <tbody>
                            <tr>
                                <td>Created At</td>
                                <td>{{ getFormattedDateTime($notification->created_at) }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if(Helper::hasAuthRolePermission('notification_recipients'))
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="card-title">Notification Recipients</h4>
                </div>
                <div class="card-body py-sm-4">
                    <table id="dataTable" class="table table-bordered">
                        <input type="hidden" id="id" value="{{ $notification->id }}">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Status</th>
                                <th>Sending Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@stop
@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')
@push('scripts')
@vite('resources/admin_assets/js/pages/notification/show.js')
@endpush
