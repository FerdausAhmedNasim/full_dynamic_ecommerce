@extends('admin.layouts.master')
@section('title', 'Website Popup')
@section('website_popup', 'active')

@section('content')

@php
use App\Library\Helper;
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Website Popup' )) }}</h4>
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
                                    <div class="section-title mb-4 bar-before-title bold">Website Popup</div>
                                    <div class="form-group row @error('site_popup_status') error @enderror">
                                        <label class="col-sm-3 required">{{ __('Popup Status') }}</label>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                    onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'site_popup_status') }}' )"
                                                    class="custom-control-input" id="cookieSwitch"
                                                    {{ settings('site_popup_status') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="cookieSwitch"></label>
                                            </div>

                                            @error('site_popup_status')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row @error('popup_title') error @enderror">
                                        <label class="col-sm-3 required">{{ __('Popup Title') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="popup_title"
                                                placeholder="Title" required
                                                value="{{ old('popup_title') ?? settings('popup_title') }}">
                                            @error('popup_title')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row @error('popup_image') error @enderror">
                                        <label class="col-sm-3" for="description">{{ __('Popup Image') }}
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="file-upload-section">
                                                <input name="popup_image" type="file" class="form-control hidden_file"
                                                    allowed="png,gif,jpeg,jpg,svg">
                                                <div class="input-group col-xs-12">
                                                    <input type="text"
                                                        class="form-control file-upload-info @error('popup_image') error @enderror"
                                                        disabled="" readonly
                                                        placeholder="Max:1024kB, Types: png,gif,jpeg,jpg,svg">
                                                    <span class="input-group-append">
                                                        <button class="file-upload-browse btn btn-outline-secondary"
                                                            type="button"><i class="fas fa-upload"></i> Browse</button>
                                                    </span>

                                                </div>
                                                <div class="display-input-image @if(settings('popup_image') == '') d-none @endif">
                                                    <img src="{{ settings('popup_image') != '' ? asset(settings('popup_image')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                                        alt="Preview Image" />
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger file-upload-remove"
                                                        title="Remove">x</button>
                                                </div>
                                                @error('popup_image')
                                                <p class="error-message">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row @error('popup_show_in') error @enderror">
                                        <label class="col-sm-3">
                                            {{ __('Popup Show In') }}
                                        </label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="popup_show_in"
                                                id="popup_show_in">
                                                <option value="" class="selected highlighted">Select One</option>
                                                <option value="home"
                                                    {{ (old("popup_show_in", settings('popup_show_in')) == 'home') ? "selected" : "" }}>
                                                    Home
                                                </option>
                                                <option value="all"
                                                    {{ (old("popup_show_in", settings('popup_show_in')) == 'all') ? "selected" : "" }}>
                                                    All Page
                                                </option>
                                            </select>
                                            @error('popup_show_in')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row @error('popup_description') error @enderror">
                                        <label class="col-sm-3">{{ __('Popup Description') }}</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" class="form-control" id="summernote"
                                                name="popup_description" placeholder="Cookies Agreement">
                                            {{ old('popup_description') ?? settings('popup_description') }}
                                        </textarea>
                                            @error('popup_description')
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