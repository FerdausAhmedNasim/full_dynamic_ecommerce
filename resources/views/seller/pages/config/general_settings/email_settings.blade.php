@extends('admin.pages.config.general_settings.layout.master')
@section('title', 'Email Settings')
@section('email_settings', 'active')

@section('settingsContent')
<div class="section-title mb-4 bar-before-title fw-bold">
Email Settings
    <button onclick="clickAddAction()" class="btn btn-sm btn2-secondary float-end">Test Mail</button>
</div>
<form method="post" action="{{ route('admin.config.general_settings.email.settings.update') }}"
    enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="p-sm-3">
                <div class="form-group member-select">
                    <label class="required">{{ __('Mail Driver') }}</label>
                    <div class="">
                        <select class="form-control @error('mail_mailer') is-invalid @enderror" name="mail_mailer">
                            <option value="smtp">SMTP</option>
                        </select>
                        @error('mail_mailer')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-sm-3">

                <div class="form-group @error('mail_host') error @enderror">
                    <label class="required">{{ __('Mail Host') }}</label>
                    <div class="">
                        <input type="text" class="form-control" name="mail_host"
                            value="{{ old('mail_host') ?? settings('mail_host') }}" placeholder="{{ __('Mail Host') }}"
                            required>
                        @error('mail_host')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-sm-3">
                <div class="form-group member-select">
                    <label class="required">{{ __('Mail Encryption') }}</label>
                    <div class="">
                        <select name="mail_encryption"
                            class="form-control @error('mail_encryption') is-invalid @enderror"
                            placeholder="mail_encryption"
                            value="{{ old('mail_encryption') ?? settings('mail_encryption') }}">
                            <option value="tls" {{ settings('mail_encryption') == 'tls' ? 'selected' : '' }}>TLS
                            </option>
                            <option value="ssl" {{ settings('mail_encryption') == 'ssl' ? 'selected' : '' }}>SSL
                            </option>
                        </select>
                        @error('mail_encryption')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-sm-3">

                <div class="form-group  @error('mail_port') error @enderror">
                    <label class="required">{{ __('Mail Port') }}</label>
                    <div class="">
                        <input type="text" class="form-control" name="mail_port"
                            value="{{ old('mail_port') ?? settings('mail_port') }}" placeholder="{{ __('Mail Port') }}"
                            required>
                        @error('mail_port')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-sm-3">

                <div class="form-group @error('mail_from_address') error @enderror">
                    <label class="required">{{ __('Mail From Address') }}</label>
                    <div class="">
                        <input type="text" class="form-control" name="mail_from_address"
                            value="{{ old('mail_from_address') ?? settings('mail_from_address') }}"
                            placeholder="{{ __('Mail From') }}" required>
                        @error('mail_from_address')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-sm-3">

                <div class="form-group @error('mail_from_name') error @enderror">
                    <label class="required">{{ __('Mail From Name') }}</label>
                    <div class="">
                        <input type="text" class="form-control" name="mail_from_name"
                            value="{{ old('mail_from_name') ?? settings('mail_from_name') }}"
                            placeholder="{{ __('Mail From Name') }}" required>
                        @error('mail_from_name')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-sm-3">

                <div class="form-group @error('mail_username') error @enderror">
                    <label class="required">{{ __('Mail User Name') }}</label>
                    <div class="">
                        <input type="text" class="form-control" name="mail_username"
                            value="{{ old('mail_username') ?? settings('mail_username') }}"
                            placeholder="{{ __('Mail User Name') }}" required>
                        @error('mail_username')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-sm-3">

                <div class="form-group @error('mail_password') error @enderror">
                    <label class="required">{{ __('Mail Password') }}</label>
                    <div class="">
                        <input type="text" class="form-control" name="mail_password"
                            value="{{ old('mail_password') ?? settings('mail_password') }}"
                            placeholder="{{ __('Mail Password') }}" required>
                        @error('mail_password')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row mt-2">
        <div class="modal-footer justify-content-center col-md-12">
            {!! \App\Library\Html::btnReset() !!}
            {!! \App\Library\Html::btnSubmit() !!}
        </div>
    </div>
</form>

@stop

@push('scripts')
@vite('resources/admin_assets/js/pages/config/email/index.js')
@endpush
