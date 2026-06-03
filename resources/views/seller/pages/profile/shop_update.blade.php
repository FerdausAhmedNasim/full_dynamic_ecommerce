@extends('seller.layouts.master')

@section('title', __('Update profile'))

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.profile.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ __('Update Profile') }}</h4>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="{{ route('seller.profile.shop.update') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row @error('store_lan.store_name') error @enderror">
                                    <label class="col-sm-12 required">{{ __('Store Name') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="store_lan[store_name]"
                                            value="{{ old('store_lan.store_name', $seller->store?->getTranslation('store_name') }}"
                                            placeholder="{{ __('Store Name') }}" required>
                                        @error('store_lan.store_name')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row @error('store.license_no') error @enderror">
                                    <label class="col-sm-12">{{ __('License Number') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="store[license_no]"
                                            value="{{ old('store.license_no', $seller->store?->license_no) }}"
                                            placeholder="{{ __('LNC-1133') }}">
                                        @error('store.license_no')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row @error('store_lan.store_tagline') error @enderror">
                            <label class="col-sm-12 required">{{ __('Store Tagline') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="store_lan[store_tagline]"
                                    value="{{ old('store_lan.store_tagline', $seller->store?->getTranslation('store_tagline') ) }}"
                                    placeholder="{{ __('Store Tagline') }}" required>
                                @error('store_lan.store_tagline')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store_lan.address') error @enderror">
                            <label class="col-sm-12">{{ __('Address') }}</label>
                            <div class="col-sm-12">
                                <textarea type="text" class="form-control" name="store_lan[address]"
                                    placeholder="{{ __('Address') }}">{{ old('store_lan.address', $seller->store?->getTranslation('address') ) }}</textarea>
                                @error('store_lan.address')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store.logo') error @enderror">
                            <label class="col-sm-12 required">Logo (72*72)</label>
                            <div class="col-sm-12">
                                <div class="file-upload-section">
                                    <input name="store[logo]" type="file" class="form-control hidden-file"
                                        allowed="png,gif,jpeg,jpg">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled="" readonly
                                            placeholder="Size: 200x200 and max 500kB">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-outline-secondary"
                                                type="button"><i class="fas fa-upload"></i>
                                                Browse</button>
                                        </span>
                                    </div>
                                    @error('store_lan.logo')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror

                                    <div class="display-input-image">
                                        <img src="{{ $seller->store->getThumbnailImage() }}" alt="Preview Image" />
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                            title="Remove">x</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row @error('store.banner') error @enderror">
                            <label class="col-sm-12">Store Page Banner(850*480)</label>
                            <div class="col-sm-12">
                                <div class="file-upload-section">
                                    <input name="store[banner]" type="file" class="form-control d-none"
                                        allowed="png,gif,jpeg,jpg">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled="" readonly
                                            placeholder="Size: 200x200 and max 500kB">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-outline-secondary"
                                                type="button"><i class="fas fa-upload"></i>
                                                Browse</button>
                                        </span>
                                    </div>
                                    @error('store.banner')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                    <div class="display-input-image">
                                        <img src="{{ $seller?->store?->getBannerImage() }}" alt="Preview Image" />
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                            title="Remove">x</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row @error('store.facebook') error @enderror">
                            <label class="col-sm-12">{{ __('Facebook') }}</label>
                            <div class="col-sm-12">
                                <input type="url" class="form-control" name="store[facebook]"
                                    value="{{ old('facebook', $seller->store?->facebook ) }}"
                                    placeholder="{{ __('Last Name') }}">
                                @error('facebook')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store.google') error @enderror">
                            <label class="col-sm-12">{{ __('Google') }}</label>
                            <div class="col-sm-12">
                                <input type="url" class="form-control" name="store[google]"
                                    value="{{ old('google', $seller->store?->google ) }}"
                                    placeholder="{{ __('Last Name') }}">
                                @error('google')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store.twitter') error @enderror">
                            <label class="col-sm-12">{{ __('Twitter') }}</label>
                            <div class="col-sm-12">
                                <input type="url" class="form-control" name="store[twitter]"
                                    value="{{ old('twitter', $seller->store?->twitter ) }}"
                                    placeholder="{{ __('Last Name') }}">
                                @error('twitter')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store.instagram') error @enderror">
                            <label class="col-sm-12">{{ __('Instagram') }}</label>
                            <div class="col-sm-12">
                                <input type="url" class="form-control" name="store[instagram]"
                                    value="{{ old('instagram', $seller->store->instagram ) }}"
                                    placeholder="{{ __('Last Name') }}">
                                @error('instagram')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store.youtube') error @enderror">
                            <label class="col-sm-12">{{ __('Youtube') }}</label>
                            <div class="col-sm-12">
                                <input type="url" class="form-control" name="store[youtube]"
                                    value="{{ old('youtube', $seller->store?->youtube ) }}"
                                    placeholder="{{ __('Last Name') }}">
                                @error('youtube')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store_lan.meta_title') error @enderror">
                            <label class="col-sm-12">{{ __('Meta Title') }}</label>
                            <div class="col-sm-12">
                                <input type="test" class="form-control" name="store_lan[meta_title]"
                                    value="{{ old('store_lan.meta_title', $seller->store?->getTranslation('meta_title') ) }}"
                                    placeholder="{{ __('Last Name') }}">
                                @error('store_lan.meta_title')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store_lan.meta_description') error @enderror">
                            <label class="col-sm-12">{{ __('Meta Description') }}</label>
                            <div class="col-sm-12">
                                <textarea type="text" class="form-control" name="store_lan[meta_description]"
                                    placeholder="{{ __('Address') }}">{{ old('store_lan.meta_description', $seller->store?->getTranslation('meta_description') ) }}</textarea>

                                @error('store_lan.meta_description')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="modal-footer justify-content-center col-md-12">
                                {!! \App\Library\Html::btnSubmit() !!}
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@stop

@include('admin.assets.datetimepicker')

@push('scripts')
<script>
    $(document).ready(function () {
        $("#sameAddress").on("change", function () {
            if (this.checked) {
                $("#postalStreetAddress").val($("#homeStreetAddress").val());
                $("#postalSubRoad").val($("#homeSubRoad").val());
                $("#postalCity").val($("#homeCity").val());
                $("#postalPostCode").val($("#homePostCode").val());
                $("#postalLatitude").val($("#homeLatitude").val());
                $("#postalLoggitude").val($("#homeLoggitude").val());
            } else {
                $("#postalStreetAddress").val('');
                $("#postalSubRoad").val('');
                $("#postalCity").val('');
                $("#postalPostCode").val('');
                $("#postalLatitude").val('');
                $("#postalLoggitude").val('');
            }
        });
    });
</script>
@endpush