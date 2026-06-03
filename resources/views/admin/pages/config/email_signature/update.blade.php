@extends('admin.pages.config.general_settings.layout.master')
@section('title', 'Edit Email Signature')
@section('email_signature', 'active')

@section('settingsContent')
<div class="section-title mb-4 bar-before-title fw-bold">Edit Email Signature</div>

<form method="post" action="{{ route('admin.config.more_settings.email_signature.update', $emailSignature->id) }}"
    enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="p-sm-3">

                <div class="form-group row @error('subject') error @enderror">
                    <label class="col-sm-2 col-form-label required">{{ __('Signature Name') }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name"
                            value="{{ old('name', $emailSignature->name) }}" placeholder="{{ __('Signature Name') }}"
                            required>
                        @error('name')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('signature') error @enderror">
                    <label class="col-sm-2 col-form-label required" for="name">{{ __('Email Signature') }}</label>
                    <div class="col-sm-10">
                        <div id="editor">
                            <textarea name="signature" placeholder="Textarea" id="summernote" class="form-control">
                                                {{ $emailSignature->signature }}
                                        </textarea>
                            @error('signature')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="modal-footer justify-content-center col-md-12">
            <button type="submit" class="btn btn2-secondary"><i class="fas fa-save"></i> {{ __('Update') }} </button>
        </div>
    </div>
</form>

@stop

@include('admin.assets.summernote-text-editor')
@push('scripts')
@vite('resources/admin_assets/js/pages/config/email_template/update.js')
@endpush