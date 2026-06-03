
@extends('seller.pages.member.layout.master')
@section('title', __('Client Notes'))

@section('content')

@php
$user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.referral.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Client Notes')) }}</h4>
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
                <div class="col-xl-5 col-md-12 col-sm-6 col-12 mb-4">
                    @include('seller.pages.member.prescription.create')
                </div>

                <div class="col-xl-7 col-md-12 col-sm-6 col-12 mb-4">
                    @include('seller.pages.member.prescription.show')
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

<script src="{{ asset('assets/js/vendor.bundle.base.js') }}"></script>
