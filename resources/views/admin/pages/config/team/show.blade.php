@extends('admin.layouts.master')

@section('title', __('Team Details'))
@section('team', 'active')

@section('content')

@php
use App\Library\Helper;
$user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.team.index')) !!}
        <div class="d-block">
            <h4 class="content-title">
                {{ strtoupper('Team Details') }}
            </h4>
        </div>
    </div>

    <!-- TabMenu Start -->
    <div class="card shadow-sm">
        @include('admin.pages.config.team.partials.topbar')
    </div>
    <!-- TabMenu End -->

    <div class="tab-content mt-4">
        <!-- Home -->
        <div>
            <div class="row">

                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-5 pb-4">
                    <div class="card shadow-sm">
                        <div class="card-body py-sm-4">
                            <div class="text-center pb-2">
                                <div class="mb-3 border-bottom">
                                    <img src="{{ $team?->teamLeader?->getAvatar() ?? Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}" alt="team avatar"
                                        class="img-lg rounded-circle mb-3" style="border: 1px solid #e4e4e4;">
                                </div>

                                <div class="mb-3">
                                    <h3 class="text-primary">{{ $team?->teamLeader?->full_name }}</h3>
                                    <h4 class="text-primary">{{ $team->name }}</h4>
                                </div>
                            </div>


                            <table class="table org-data-table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            @php
                                            if ($team->is_active){
                                            $class = 'badge-primary';
                                            $title = "Active";
                                            }
                                            else{
                                            $class = 'badge-danger';
                                            $title = "InActive";
                                            }
                                            @endphp

                                            <div class="badge {{ $class }}">
                                                {{ $title }}
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Parent Team</td>
                                        <td>{{ $team->parent->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Operator</td>
                                        <td>{{ $team->operator->full_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Created At</td>
                                        <td>{{ $team->created_at }}</td>
                                    </tr>

                                </tbody>
                            </table>

                            <div class="text-center mt-4 pb-2">
                                @if(Helper::hasAuthRolePermission('team_update'))
                                <a href="{{ route('admin.team.edit', $team->id) }}"
                                    class="btn btn-sm btn-warning mb-2 mr-2 tooltip-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                @endif

                                @if(Helper::hasAuthRolePermission('team_delete') && $team->id != 1)
                                <button class="btn btn-sm mb-2 mr-2 btn-danger tooltip-delete"
                                    onclick="confirmFormModal('{{ route('admin.team.delete', $team->id) }}', 'Confirmation', 'Are you sure to delete operation?')">
                                    <i class="fas fa-trash-alt"></i>
                                    Delete
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="card shadow-sm mt-3">
                        <div class="card-body py-sm-4">
                            {!! $team->description !!}
                        </div>
                    </div>

                </div>

                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-7">
                    @include('admin.pages.config.team.sub_team')
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
    @vite('resources/admin_assets/js/pages/team/show.js')
@endpush


@push('styles')
<style>

</style>
@endpush
