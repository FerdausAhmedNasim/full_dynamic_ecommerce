@extends('admin.pages.config.general_settings.layout.master')

@section('title', 'System Details')

@section('settingsContent')

    <form method="post" action="{{ route('admin.config.general_settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="p-sm-3">

                    <input type="hidden" name="system_details" value="system_details">

                    <div class="form-group row @error('app_title') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('App Title') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="app_title"
                                value="{{ old('app_title') ?? settings('app_title') }}" placeholder="{{ __('App Title') }}" required>
                            @error('app_title')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('website') error @enderror">
                        <label class="col-sm-3 col-form-label"
                            for="name">{{ __('Company Website') }}</label>
                        <div class="col-sm-9">
                            <input type="url" name="website" class="form-control"
                                placeholder="{{ __('www.example.com') }}"
                                value="{{ old('website') ?? settings('website') }}">
                            @error('website')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('version') error @enderror">
                        <label class="col-sm-3 col-form-label">{{ __('Version') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="version"
                                value="{{ old('version') ?? settings('version') }}" placeholder="{{ __('V-1.0.1') }}">
                            @error('version')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('copyright') error @enderror">
                        <label class="col-sm-3 col-form-label"
                            for="name">{{ __('Copyright Text') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="copyright" class="form-control"
                                placeholder="{{ __(' Example Company ') }}"
                                value="{{ old('copyright') ?? settings('copyright') }}">
                            @error('copyright')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="form-group row @error('copyright_url') error @enderror">
                        <label class="col-sm-3 col-form-label"
                            for="name">{{ __('Copyright Url') }}</label>
                        <div class="col-sm-9">
                            <input type="url" name="copyright_url" class="form-control"
                                placeholder="{{ __('www.example.com') }}"
                                value="{{ old('copyright_url') ?? settings('copyright_url') }}">
                            @error('copyright_url')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>

        @if(\App\Library\Helper::hasAuthRolePermission('general_settings_update'))
        <div class="row mt-2">
            <div class="modal-footer justify-content-center col-md-12">
                {!! \App\Library\Html::btnReset() !!}
                {!! \App\Library\Html::btnSubmit() !!}
            </div>
        </div>
        @endif

    </form>

@endsection
