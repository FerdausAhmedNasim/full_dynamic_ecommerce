@extends('admin.layouts.master')
@section('title', 'Cookies')
@section('cookies', 'active')

@section('content')

@php
use App\Library\Helper;
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Cookies' )) }}</h4>
        </div>
    </div>

    <div class="row mt-4">
        @if(Helper::hasAuthRolePermission('website_settings_cookies')||
            Helper::hasAuthRolePermission('website_settings_terms_and_conditions') ||
            Helper::hasAuthRolePermission('website_settings_website_popup') ||
            Helper::hasAuthRolePermission('website_settings_banner')
        )
        <div class="col-md-3">
            @include('admin.pages.website.settings.partials.sidebar')
        </div>
        @endif

        <div class="col-md-9">
            <div class="row justify-content-left">
                <div class="col-md-10">
                    <div class="card shadow-sm mt-3">
                        <div class="card-body py-sm-4">
                            <form method="post" action="{{ route('admin.website.setting.update') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="p-sm-3">
                                <div class="section-title mb-4 bar-before-title bold">Cookies Settings</div>
                                    <div class="form-group row @error('cookies_status') error @enderror">
                                        <label class="col-sm-3 required">{{ __('Cookies Agreement') }}</label>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                    onchange="changeCookieStatus(event, '{{ route('admin.website.setting.update.status', 'cookies_status') }}' )"
                                                    class="custom-control-input" id="cookieSwitch"
                                                    {{ settings('cookies_status') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="cookieSwitch"></label>
                                            </div>

                                            @error('title')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row @error('cookies_agreement') error @enderror">
                                        <label class="col-sm-3 required">{{ __('Cookies Agreement Text') }}</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" class="form-control" id="summernote"
                                                name="cookies_agreement" placeholder="Cookies Agreement">
                                            {{ old('cookies_agreement') ?? settings('cookies_agreement') }}
                                        </textarea>
                                            @error('cookies_agreement')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="modal-footer justify-content-center col-md-12">
                                        {!! \App\Library\Html::btnSubmit() !!}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@include('admin.assets.summernote-text-editor')

@push('scripts')
<script>
    $(document).ready(function () {
        $('#summernote').summernote({
            height: 300
        });
    });

    window.changeCookieStatus = function (e, route) {
        e.preventDefault();
        confirmFormModal(route, 'Confirmation', 'Are you sure Update Status.');
        table.ajax.reload();
    }
</script>
@endpush