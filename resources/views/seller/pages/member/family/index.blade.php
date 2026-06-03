
@extends('seller.pages.member.layout.master')

@section('title', __('Family Tree'))
@section('content')


@php
$user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.referral.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Family Tree')) }}</h4>
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
                                    <table class="table table-bordered" id="clientFamilyTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Family ID</th>
                                                <th>Family Member</th>
                                                <th>Operator</th>
                                                <th>Note</th>
                                                <th>Created Date</th>
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

@include('seller.pages.member.family.create_modal')
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/member/family/index.js')
@endpush