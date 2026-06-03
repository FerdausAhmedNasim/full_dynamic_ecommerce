@extends('public.member_dashboard.dashboard_master')

@section('title', 'Create Address')

@section('address', 'active')

@section('member_content')
@php
use \App\Library\Enum;
@endphp
<div class="dashboard-address">
    <div class="title title-flex">
        <div>
            <h2>Create Address</h2>
            <span class="title-leaf">
                <svg class="icon-width bg-gray">
                    <use xlink:href="{{ asset('frontend/svg/leaf.svg') }}#leaf"></use>
                </svg>
            </span>
        </div>
    </div>
    <div class="d-flex flex-column align-items-center justify-content-center shadow-lg p-4 rounded-4">
        @include('public.member_dashboard.address.partials.create_form')
    </div>
</div>

@endsection
