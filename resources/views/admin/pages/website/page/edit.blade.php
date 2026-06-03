@extends('admin.layouts.master')
@section('title', __('Edit Page'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.website.page.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Edit Page')) }}</h4>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mt-3">
                <div class="card-body py-sm-4">
                    <form method="post" action="{{ route('admin.website.page.update', $page->id) }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" value="{{$page->id}}">
                        <div class="p-sm-3">

                            <div class="form-group row @error('Title') error @enderror">
                                <label class="col-sm-2 required">{{ __('Title') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" value="{{ old('title', $page->getTranslation('title')) }}"
                                        placeholder="{{ __('Title') }}" required>
                                    @error('title')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('content') error @enderror">
                                <label class="col-sm-2 col-form-label required">{{ __('Content') }}
                                </label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control" name="content" id="content5"
                                        placeholder="{{ __('Write page Content .........') }}">{{ old('content', $page->getTranslation('content') ) }}</textarea>
                                    @error('content')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('meta_title') error @enderror">
                                <label class="col-sm-2">{{ __('Meta Title') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="meta_title"
                                        value="{{ old('meta_title', $page->getTranslation('meta_title') ) }}" placeholder="{{ __('Meta title') }}">
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
                                        placeholder="{{ __('Ex: 1') }}">{{ old('meta_description', $page->getTranslation('meta_description')) }}</textarea>
                                    @error('meta_description')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('meta_keyword') error @enderror">
                                <label class="col-sm-2">{{ __('Meta Keywords') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="meta_keyword"
                                        value="{{ old('meta_keyword', $page->getTranslation('meta_keyword')) }}" placeholder="{{ __('Subtitle') }}">
                                    @error('meta_keyword')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            @if ($page->link == 'about-us')
                                <div class="form-group row @error('image') error @enderror">
                                    <label class="col-sm-2 col-form-label">{{ __('Thumbnail (770X450)') }}</label>
                                    <div class="col-sm-10">
                                        <div class="file-upload-section">
                                            <input name="image" type="file" class="form-control d-none" allowed="png,gif,jpeg,jpg.webp">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info" disabled="" readonly
                                                    placeholder="Size: 770x450 and max 500kB">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-outline-secondary" type="button">
                                                        <i class="fas fa-upload"></i> Browse
                                                    </button>
                                                </span>
                                            </div>
                                            @error('image')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                            <div class="display-input-image" style="display: {{ $page->image ? '' : 'd-none' }}">
                                                <img src="{{ $page->getImage() }}" alt="Preview Image" />
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                                    title="Remove">x</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

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