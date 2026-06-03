@extends('admin.layouts.master')
@section('title', 'Team Member')
@section('team_member', 'active')
@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.team.index')) !!}
        <div class="d-block">
            <h4 class="content-title">
                {{ strtoupper('Team Member') }}
            </h4>
        </div>
    </div>

    <!-- TabMenu Start -->
    <div class="card shadow-sm">
        @include('admin.pages.config.team.partials.topbar')
    </div>
    <!-- TabMenu End -->

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <input type="hidden" name="team_id" id="team_id" value="{{ $team->id }}">
            <table id="teamMemberDataTable" class="table table-bordered role-data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Operator</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/team/member.js')
@endpush
