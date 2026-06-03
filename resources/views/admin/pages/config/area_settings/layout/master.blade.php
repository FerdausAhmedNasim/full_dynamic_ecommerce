@extends('admin.layouts.master')

@section('title', __('Area Settings'))

@section('content')

@php
$user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {{-- {!! \App\Library\Html::linkBack(route('admin.user.customer.index')) !!} --}}
        <div class="d-block">
            <h4 class="content-title">
            {{ strtoupper('Area Settings') }}
            </h4>
        </div>
    </div>

    <div class="tab-content mt-4">

        <div class="row">

            @include('admin.pages.config.area_settings.partials.sidebar')

            <!-- Sidebar Content Start -->
            <div class="col-xxl-9 col-xl-9 col-lg-8 col-md-7">
                <div class="card shadow-sm">
                    <div class="card-body py-4">
                        <div class="tab-content tab-content-vertical">

                            <div class="tab-pane fade show active">
                                @yield('areaSettingsContent')
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Sidebar Content -->
        </div>

    </div>
</div>

@stop


@push('scripts')
@endpush


@push('styles')
    <style>
        .form-group {
            margin-bottom: 0.3rem;
        }
    </style>
@endpush
