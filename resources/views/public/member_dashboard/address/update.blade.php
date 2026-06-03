@extends('public.member_dashboard.dashboard_master')

@section('title', 'Update Address')

@section('address', 'active')

@section('member_content')
@php
use \App\Library\Enum;
@endphp
<div class="dashboard-address">
    <div class="title title-flex">
        <div>
            <h2>Update Address</h2>
            <span class="title-leaf">
                <svg class="icon-width bg-gray">
                    <use xlink:href="{{ asset('frontend/svg/leaf.svg') }}#leaf"></use>
                </svg>
            </span>
        </div>
    </div>
    <div>
       @include('public.member_dashboard.address.partials.update_form')
    </div>
</div>

@endsection
