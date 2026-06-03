@extends('public.member_dashboard.dashboard_master')

@section('title', 'Notifications')

@section('notification', 'active')

@section('member_content')
@php
use \App\Library\Enum;
@endphp
<div class="dashboard-profile">
    <div class="title">
        <h2>Notification</h2>
        <span class="title-leaf title-leaf-gray">
            <svg class="icon-width bg-gray">
                <use xlink:href="{{ asset('frontend/svg/leaf.svg') }}#leaf"></use>
            </svg>
        </span>
    </div>

    <div class="profile-about dashboard-bg-box">
        <div class="row">
            <div class="col-xxl-7">
                <div class="dashboard-title mb-3">
                    <h3>Notification Details</h3>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Subject :</td>
                                <td>{{ $notification_recipient->subject }}</td>
                            </tr>
                            <tr>
                                <td>Date :</td>
                                <td>{{ date('jS M Y', strtotime($notification_recipient->send_date)) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="dashboard-title mb-3">
                    <h3>Notification Message</h3>
                </div>

                <div class="table-responsive">
                    {!! $notification_recipient->message !!}
                </div>
            </div>

            <div class="col-xxl-5">
                <div class="profile-image">
                    <img src="{{ Vite::asset(Enum::PROFILE_IMAGE_DIR) }}" class="img-fluid blur-up lazyload"
                        alt="">
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
table tbody tr td label {
    padding: 3px 12px;
    font-size: 12px;
    border-radius: 50px
}

table tbody tr td label.success {
    background-color: rgba(var(--theme-color-rgb), 0.1);
    color: var(--theme-color)
}

table tbody tr td label.warning {
    background-color: #ffa53b;
    color: #fff;
}

table tbody tr td label.danger {
    background-color: rgba(255, 114, 114, 0.1);
    color: #ff7272
}
</style>
@endpush
@push('scripts')
@endpush
