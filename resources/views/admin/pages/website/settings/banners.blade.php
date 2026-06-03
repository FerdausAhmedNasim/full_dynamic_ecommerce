@extends('admin.layouts.master')
@section('title', 'Banners')
@section('banner', 'active')

@section('content')

@php
use App\Library\Helper;
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Banners' )) }}</h4>
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
                                    <div class="section-title mb-4 bar-before-title bold">Banners</div>

                                    <div class="form-group row @error('login_banner') error @enderror">
                                        <label class="col-sm-3" for="description">{{ __('Login Banner (550x470)') }} </label>
                                        <div class="col-sm-9">
                                            <div class="file-upload-section">
                                                <input name="login_banner" type="file" class="form-control hidden_file"
                                                    allowed="png,gif,jpeg,jpg,svg,webp">
                                                <div class="input-group col-xs-12">
                                                    <input type="text"
                                                        class="form-control file-upload-info @error('login_banner') error @enderror"
                                                        disabled="" readonly
                                                        placeholder="Max:1024kB, Types: png,gif,jpeg,jpg,svg,webp">
                                                    <span class="input-group-append">
                                                        <button class="file-upload-browse btn btn-outline-secondary"
                                                            type="button"><i class="fas fa-upload"></i> Browse</button>
                                                    </span>

                                                </div>
                                                <div class="display-input-image @if(settings('login_banner') == '') d-none @endif">
                                                    <img src="{{ settings('login_banner') != '' ? asset(settings('login_banner')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                                        alt="Preview Image" />
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger file-upload-remove"
                                                        title="Remove">x</button>
                                                </div>
                                                @error('login_banner')
                                                <p class="error-message">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row @error('signup_banner') error @enderror">
                                        <label class="col-sm-3" for="description">{{ __('Register Banner (550x540)') }} </label>
                                        <div class="col-sm-9">
                                            <div class="file-upload-section">
                                                <input name="signup_banner" type="file" class="form-control hidden_file"
                                                    allowed="png,gif,jpeg,jpg,svg,webp">
                                                <div class="input-group col-xs-12">
                                                    <input type="text"
                                                        class="form-control file-upload-info @error('signup_banner') error @enderror"
                                                        disabled="" readonly
                                                        placeholder="Max:1024kB, Types: png,gif,jpeg,jpg,svg,webp">
                                                    <span class="input-group-append">
                                                        <button class="file-upload-browse btn btn-outline-secondary"
                                                            type="button"><i class="fas fa-upload"></i> Browse</button>
                                                    </span>

                                                </div>
                                                <div class="display-input-image @if(settings('signup_banner') == '') d-none @endif">
                                                    <img src="{{ settings('signup_banner') != '' ? asset(settings('signup_banner')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                                        alt="Preview Image" />
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger file-upload-remove"
                                                        title="Remove">x</button>
                                                </div>
                                                @error('signup_banner')
                                                <p class="error-message">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row @error('forgot_password_banner') error @enderror">
                                        <label class="col-sm-3" for="description">{{ __('Forgot Password Banner (550x410)') }} </label>
                                        <div class="col-sm-9">
                                            <div class="file-upload-section">
                                                <input name="forgot_password_banner" type="file" class="form-control hidden_file"
                                                    allowed="png,gif,jpeg,jpg,svg,webp">
                                                <div class="input-group col-xs-12">
                                                    <input type="text"
                                                        class="form-control file-upload-info @error('forgot_password_banner') error @enderror"
                                                        disabled="" readonly
                                                        placeholder="Max:1024kB, Types: png,gif,jpeg,jpg,svg,webp">
                                                    <span class="input-group-append">
                                                        <button class="file-upload-browse btn btn-outline-secondary"
                                                            type="button"><i class="fas fa-upload"></i> Browse</button>
                                                    </span>

                                                </div>
                                                <div class="display-input-image @if(settings('forgot_password_banner') == '') d-none @endif">
                                                    <img src="{{ settings('forgot_password_banner') != '' ? asset(settings('forgot_password_banner')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                                        alt="Preview Image" />
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger file-upload-remove"
                                                        title="Remove">x</button>
                                                </div>
                                                @error('forgot_password_banner')
                                                <p class="error-message">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row @error('landing_banner') error @enderror">
                                        <label class="col-sm-3" for="description">{{ __('Landing Banner (1590x420)') }} </label>
                                        <div class="col-sm-9">
                                            <div class="file-upload-section">
                                                <input name="landing_banner" type="file" class="form-control hidden_file"
                                                    allowed="png,gif,jpeg,jpg,svg,webp">
                                                <div class="input-group col-xs-12">
                                                    <input type="text"
                                                        class="form-control file-upload-info @error('landing_banner') error @enderror"
                                                        disabled="" readonly
                                                        placeholder="Max:1024kB, Types: png,gif,jpeg,jpg,svg,webp">
                                                    <span class="input-group-append">
                                                        <button class="file-upload-browse btn btn-outline-secondary"
                                                            type="button"><i class="fas fa-upload"></i> Browse</button>
                                                    </span>

                                                </div>
                                                <div class="display-input-image @if(settings('landing_banner') == '') d-none @endif">
                                                    <img src="{{ settings('landing_banner') != '' ? asset(settings('landing_banner')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                                        alt="Preview Image" />
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger file-upload-remove"
                                                        title="Remove">x</button>
                                                </div>
                                                @error('landing_banner')
                                                <p class="error-message">{{ $message }}</p>
                                                @enderror
                                            </div>
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
@include('admin.assets.select2')

@push('scripts')
<script>
    $(document).ready(function () {
        $('#summernote').summernote({
            height: 300
        });
    });

    window.changeStatus = function (e, route) {
        e.preventDefault();
        confirmFormModal(route, 'Confirmation', 'Are you sure Update Status.');
        table.ajax.reload();
    }
</script>
@endpush
