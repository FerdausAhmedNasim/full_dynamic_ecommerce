@extends('admin.layouts.master')

@section('title', __('Seller Details'))

@section('content')

@php
$user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.seller.index')) !!}
        <div class="d-block">
            <h4 class="content-title">
            {{ strtoupper('Seller Details') }}
            </h4>
        </div>
    </div>

    <input type="hidden" id="memberID" value="{{ $user->id}}">

    <input type="hidden" value="{{ $user->id }}" id="MemberId">
    <input type="hidden" value="{{ $user?->id }}" id="UserId">

    <!-- TabMenu Start -->
    <div class="card shadow-sm">
        @include('admin.pages.user.seller.partials.topbar', ['user', $user])
    </div>
    <!-- TabMenu End -->

    <div class="tab-content mt-4">
        <!-- Home -->
        <div>
            <div class="row">

                @include('admin.pages.user.seller.partials.sidebar')

                <!-- Sidebar Content Start -->
                <div class="col-xxl-9 col-xl-9 col-lg-8 col-md-7">
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

@include('admin.pages.user.common.update_user_status_modal', ['user', $user])

@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')
@include('admin.assets.summernote-text-editor')
@include('admin.assets.select2')

@push('scripts')
@vite('resources/admin_assets/js/pages/user/seller/show.js')
@endpush

<script src="{{ asset('assets/js/vendor.bundle.base.js') }}"></script>

@push('styles')
    <style>
        .count {
            top: -3px !important;
        }
    </style>
@endpush
