@extends('admin.layouts.master')
@section('title', __('Create Page'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.website.page.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Create Page')) }}</h4>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mt-3">
                <div class="card-body py-sm-4">
                    <form method="post" action="{{ route('admin.website.page.create') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="p-sm-3">

                            <div class="form-group row @error('Title') error @enderror">
                                <label class="col-sm-2 required">{{ __('Title') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                                        placeholder="{{ __('Title') }}" required>
                                    @error('title')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('link') error @enderror">
                                <label class="col-sm-2 required">{{ __('Link/Slug') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="link" value="{{ old('link') }}"
                                        placeholder="{{ __('Ex: blog,product,brand, privacy-policy ') }}"
                                        required>
                                    @error('link')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('content') error @enderror">
                                <label class="col-sm-2 col-form-label required">{{ __('Content') }}
                                </label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control" name="content" id="content5"
                                        placeholder="{{ __('Write page Content .........') }}">{{ old('content') }}</textarea>
                                    @error('content')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('meta_title') error @enderror">
                                <label class="col-sm-2">{{ __('Meta Title') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="meta_title"
                                        value="{{ old('meta_title') }}" placeholder="{{ __('Meta title') }}">
                                    @error('meta_title')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('meta_description') error @enderror">
                                <label class="col-sm-2 col-form-label">{{ __('Meta Description') }}
                                </label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control" name="meta_description"
                                        placeholder="{{ __('Ex: 1') }}">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('meta_keyword') error @enderror">
                                <label class="col-sm-2">{{ __('Meta Keywords') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="meta_keyword"
                                        value="{{ old('meta_keyword') }}" placeholder="{{ __('Subtitle') }}">
                                    @error('meta_keyword')
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
@include('admin.assets.summernote-text-editor')
@stop
@push('scripts')
<script>
    $(document).ready(function () {
        $('#content5').summernote({
            height: 320
        });
    });
</script>
@endpush