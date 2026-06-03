@extends('admin.layouts.master')
@section('title', __('Update Slider'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.website.slider.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Slider')) }}</h4>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm mt-3">
                <div class="card-body py-sm-4">
                    <form method="post" action="{{ route('admin.website.slider.update', $slider->id) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="p-sm-3">


                            <div class="form-group row @error('order') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Order') }}
                                    <span class="fw-lighter text-smaller">(to show Menu sidebar)</span>
                                </label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="order"
                                        value="{{ old('order', $slider->order) }}" placeholder="{{ __('Ex: 1') }}">
                                    @error('order')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('link') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Link') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="link"
                                        value="{{ old('link', $slider->link) }}" placeholder="{{ __('Link') }}"
                                        required>
                                    @error('link')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('background') error @enderror">
                                <label class="col-sm-3 col-form-label" for="description">{{ __('Thumbnail') }}</label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="background" type="file" class="form-control hidden_file"
                                            allowed="png,gif,jpeg,jpg">
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('background') error @enderror"
                                                disabled="" readonly placeholder="Size:1920x800, Max:1024kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>

                                        </div>
                                        <div class="display-input-image">
                                            <img src="{{ $slider->getBackgroundImage() }}" alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
                                        </div>
                                        @error('background')
                                        <p class="error-message text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="modal-footer justify-content-center col-md-12">
                                {!! \App\Library\Html::btnReset() !!}
                                {!! \App\Library\Html::btnSubmit() !!}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@include('admin.assets.select2')

@push('scripts')
@vite('resources/admin_assets/js/select2.js')
@endpush