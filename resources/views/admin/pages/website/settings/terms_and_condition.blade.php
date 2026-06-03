@extends('admin.layouts.master')
@section('title', 'Terms & Conditions')
@section('terms_and_conditions', 'active')

@section('content')

@php
use App\Library\Helper;
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Terms & Conditions Agreements' )) }}
            </h4>
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
                <div class="col-md-8">
                    <div class="card shadow-sm mt-3">
                        <div class="card-body py-sm-4">
                            <form method="post" action="{{ route('admin.website.setting.update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="p-sm-3">
                                    <div class="section-title mb-4 bar-before-title bold">Terms &amp; Conditions</div>
                                    <div class="form-group row @error('customer_agreement') error @enderror">
                                        <label class="col-sm-3">
                                            {{ __('Customer Registration') }}
                                        </label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" multiple name="customer_agreement[]"
                                                id="customer_agreement">
                                                <option value="" class="selected highlighted">Select One</option>
                                                @foreach($pages as $page)
                                                    @if (! in_array($page->slug, ['terms_and_conditions', 'privacy_policy']))
                                                        @continue
                                                    @endif
                                                    <option value="{{ $page->slug }}"
                                                        @if (! empty(settings('customer_agreement')))
                                                            {{ (in_array($page->slug, json_decode(settings('customer_agreement'), true))) ? 'selected' : '' }}
                                                            @endif
                                                            >{{ $page?->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('customer_agreement')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    @if (false)
                                    <div class="form-group row @error('seller_agreement') error @enderror">
                                        <label class="col-sm-3">
                                            {{ __('Seller Registration') }}
                                        </label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" multiple name="seller_agreement[]"
                                                id="seller_agreement">
                                                <option value="" class="selected highlighted">Select One</option>
                                                @foreach($pages as $page)
                                                    @if (! in_array($page->slug, ['terms_and_conditions', 'privacy_policy', 'seller_policy']))
                                                        @continue
                                                    @endif
                                                    <option value="{{ $page->slug }}"
                                                        @if (! empty(settings('seller_agreement')))
                                                            {{ (in_array($page->slug, json_decode(settings('seller_agreement'), true))) ? 'selected' : '' }}
                                                        @endif>
                                                        {{ $page?->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('seller_agreement')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif

                                    {{-- <div class="section-title mb-4 bar-before-title bold">Privacy Policy</div>
                                    <div class="form-group row @error('privacy_agreement') error @enderror">
                                        <label class="col-sm-3">
                                            {{ __('Privacy') }}
                                        </label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="privacy_agreement"
                                                id="privacy_agreement">
                                                <option value="" class="selected highlighted">Select One</option>
                                                @foreach($pages as $page)
                                                <option value="{{ $page->slug }}"
                                                    {{ (old("privacy_agreement", settings('privacy_agreement')) == $page->slug) ? "selected" : "" }}>
                                                    {{ $page?->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('privacy_agreement')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row @error('payment_agreement') error @enderror">
                                        <label class="col-sm-3">
                                            {{ __('Payment') }}
                                        </label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="payment_agreement"
                                                id="payment_agreement">
                                                <option value="" class="selected highlighted">Select One</option>
                                                @foreach($pages as $page)
                                                <option value="{{ $page->slug }}"
                                                    {{ (old("payment_agreement", settings('payment_agreement')) == $page->slug) ? "selected" : "" }}>
                                                    {{ $page?->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('payment_agreement')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div> --}}

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
@include('admin.assets.select2')

@push('scripts')
<script>
    window.changeCookieStatus = function (e, route) {
        e.preventDefault();
        confirmFormModal(route, 'Confirmation', 'Are you sure Update Status.');
        table.ajax.reload();
    }
</script>
@endpush
