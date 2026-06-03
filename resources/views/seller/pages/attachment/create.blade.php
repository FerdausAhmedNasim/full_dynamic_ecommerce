@extends('seller.layouts.master')

@section('title', __('New Attachment'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.profile.index') . '#tab-attachment') !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Attachment')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm col-lg-6 col-md-10">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('seller.attachment.store') }}" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{$error}}</div>
                    @endforeach
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name') }}" placeholder="{{ __('Name') }}"
                                        required>
                                    @error('name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('Image') error @enderror">
                                <label class="col-sm-3 col-form-label required" for="description">{{ __('Attachment') }}</label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="attachment" type="file" class="form-control hidden_file"
                                            allowed="png,gif,jpeg,jpg,pdf" required>
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('image') error @enderror"
                                                disabled="" readonly placeholder="The attachment type: png, gif, jpeg, jpg, pdf">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary" type="button">
                                                    <i class="fas fa-upload"></i> Browse
                                                </button>
                                            </span>

                                        </div>
                                        <div class="display-input-image d-none">
                                            <img src="{{ asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                                alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
                                        </div>
                                        @error('attachment')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                        @enderror

                                        {{-- <span class="tooltiptext">The attachment must be a file of type: png,gif,jpeg,jpg,pdf</span> --}}

                                    </div>
                                </div>
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
@stop


@push('styles')
    <style>


    </style>
@endpush
