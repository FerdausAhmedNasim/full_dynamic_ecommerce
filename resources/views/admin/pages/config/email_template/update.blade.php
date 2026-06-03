@extends('admin.pages.config.general_settings.layout.master')
@section('title', 'Edit Email Templates')
@section('email_template', 'active')

@section('settingsContent')
<div class="section-title mb-4 bar-before-title fw-bold">Edit Email Template</div>

<form method="post" action="{{ route('admin.config.more_settings.email_template.update', $data->id) }}"
    enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="p-sm-3">

                <div class="form-group row @error('subject') error @enderror">
                    <label class="col-sm-2 col-form-label required">{{ __('Email Subject') }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="subject"
                            value="{{ old('subject', $data->subject) }}" placeholder="{{ __('Email Address') }}"
                            required>
                        @error('subject')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('message') error @enderror">
                    <label class="col-sm-2 col-form-label required" for="name">{{ __('Email Message') }}</label>
                    <div class="col-sm-10">
                        <div id="editor">
                            <textarea name="message" placeholder="Textarea" id="summernote"
                                class="form-control quill-editor">
                                                {{ $data->message }}
                                        </textarea>
                            @error('message')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-sm-10">
                            @foreach($shortcodes as $key => $shortcode)
                            <span class="badge btn2-light-secondary pointer mb-sm-2 m-1"
                                onclick="copyShortCode('{{ $shortcode }}')">{{ $shortcode }}</span>
                            @endforeach
                            @foreach($systemShortCodes as $shortcode => $systemShortCode)
                            <span class="badge btn2-light-secondary pointer mb-sm-2 m-1"
                                onclick="copyShortCode('{{ $shortcode }}')">{{ $shortcode }}</span>
                            @endforeach
                            <div id="copied-success" class="copied">
                                <span>Copied!</span>
                            </div>
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