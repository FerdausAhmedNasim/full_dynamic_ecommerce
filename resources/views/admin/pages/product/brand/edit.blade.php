@extends('admin.layouts.master')
@section('title', __('Update Brand'))
@section('brand', 'active')

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.brand.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Brand')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.components.product_topbar')
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm mt-3">
                <div class="card-body py-sm-4">
                    <form method="post" action="{{ route('admin.brand.update', $brand->id) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $brand->getTranslation('title')) }}" placeholder="{{ __('Name') }}"
                                        required>
                                    @error('name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('thumbnail') error @enderror">
                                <label class="col-sm-3 col-form-label" for="description">{{ __('Thumbnail') }}</label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="thumbnail" type="file" class="form-control hidden_file"
                                            allowed="png,gif,jpeg,jpg">
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('thumbnail') error @enderror"
                                                disabled="" readonly placeholder="Size:145x120, Max:1024kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>

                                        </div>
                                        <div class="display-input-image">
                                            <img src="{{ $brand->getThumbnailImage() }}" alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
                                        </div>
                                        @error('thumbnail')
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
