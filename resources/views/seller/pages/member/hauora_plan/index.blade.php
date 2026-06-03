
@extends('seller.pages.member.layout.master')

@section('title', __('Client Hauora Plans'))
@section('content')


@php
$user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.referral.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Client Hauora Plans')) }}</h4>
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
                <div class="col-md-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body py-sm-4">
                            <div class="text-center pb-2">
                                <div class="mb-3">
                                    <table class="table table-bordered" id="hauoraPlandataTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Client Name</th>
                                                <th>Plan Type</th>
                                                <th>Services</th>
                                                <th>Employee</th>
                                                <th>Follow Up Date</th>
                                                <th>Status</th>
                                                <th>Operator</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
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


@push('scripts')
@vite('resources/admin_assets/js/pages/member/hauora_plan/index.js')
@endpush