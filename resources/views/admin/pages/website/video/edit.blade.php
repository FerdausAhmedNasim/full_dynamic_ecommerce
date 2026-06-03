@extends('admin.layouts.master')
@section('title', __('Update Video'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.website.video.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Video')) }}</h4>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm mt-3">
                <div class="card-body py-sm-4">
                    <form method="post" action="{{ route('admin.website.video.update', $slider->id) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="p-sm-3">

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