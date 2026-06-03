@extends('seller.layouts.master')

@section('title', __('Client Details'))

@section('content')

@php
$user_role = App\Models\User::getAuthUser()->roles()->first();
$alerts = App\Models\Alert::all();
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('seller.referral.index')) !!}
        <div class="d-block">
            <h4 class="content-title">
            {{ strtoupper('Client Details') }}
            </h4>
        </div>
    </div>

    @php $user = $member->user; @endphp
    <input type="hidden" id="memberID" value="{{ $member->id}}">

    <input type="hidden" value="{{ $member->id }}" id="MemberId">
    <input type="hidden" value="{{ $member?->user?->id }}" id="UserId">

    <!-- TabMenu Start -->
    <div class="card shadow-sm">
        @include('seller.pages.member.partials.topbar')
    </div>
    <!-- TabMenu End -->

    <div class="tab-content mt-4">
        <!-- Home -->
        <div>
            <div class="row">

                @include('seller.pages.member.partials.sidebar')

                <!-- Sidebar Content Start -->
                <div class="col-xxl-9 col-xl-9 col-lg-7 col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body py-4">
                            <div class="tab-content tab-content-vertical">

                                <div class="tab-pane fade show active">
                                   @yield('clientContent')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Sidebar Content -->
            </div>
        </div>
    </div>
</div>

<common-update-password></common-update-password>

@include('admin.pages.user.common.update_user_status_modal', ['user', $member->user])
@include('seller.pages.member.client_alert.modal_edit_alert')
@include('seller.pages.member.client_alert.modal_add_new_alert')
@include('seller.pages.member.client_alert.modal_view_alert')

@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')
@include('admin.assets.summernote-text-editor')
@include('admin.assets.select2')



<script src="{{ asset('assets/js/vendor.bundle.base.js') }}"></script>

@push('styles')
    <style>
        .count {
            top: -3px !important;
        }
    </style>
@endpush
