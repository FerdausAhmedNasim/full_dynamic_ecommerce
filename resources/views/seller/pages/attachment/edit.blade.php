@extends('seller.layouts.master')

@section('title', __('Update Attachment'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.profile.index') . '#tab-attachment') !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Attachment')) }}</h4>
        </div>
        
    </div>

    <div class="card shadow-sm col-lg-6 col-md-10">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('seller.attachment.update', $attachment->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Name') }} drfd</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $attachment->name) }}" placeholder="{{ __('Name') }}"
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
                                            allowed="png,gif,jpeg,jpg,pdf">
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('image') error @enderror"
                                                disabled="" readonly placeholder="Upload Your File">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>

                                        </div>
                                        <div class="display-input-image @if($attachment->attachment == null) d-none @endif">
                                            <img src="{{ $attachment->getAttachment() }}" alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
                                        </div>
                                        @error('attachment')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                        @enderror
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