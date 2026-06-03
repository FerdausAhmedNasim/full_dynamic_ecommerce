@extends('admin.pages.config.general_settings.layout.master')

@section('title', 'Address')

@section('settingsContent')

    <form method="post" action="{{ route('admin.config.general_settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="p-sm-3">

                    <div class="form-group row @error('state') error @enderror">
                        <label class="col-sm-3 col-form-label">{{ __('State') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="state" value="{{ old('state') ?? settings('state') }}"
                                placeholder="{{ __('State') }}">
                            @error('state')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('city') error @enderror">
                        <label class="col-sm-3 col-form-label">{{ __('City') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="city" value="{{ old('city') ?? settings('city') }}"
                                placeholder="{{ __('City') }}">
                            @error('city')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('country') error @enderror">
                        <label class="col-sm-3 col-form-label">{{ __('Country') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="country" value="{{ old('country') ?? settings('country') }}"
                                placeholder="{{ __('Country') }}">
                            @error('country')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('zip_code') error @enderror">
                        <label class="col-sm-3 col-form-label">{{ __('Zip Code') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="zip_code"
                                value="{{ old('zip_code') ?? settings('zip_code')}}" placeholder="{{ __('Zip Code') }}">
                            @error('zip_code')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('address') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Address') }}</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="address" class="form-control"
                                placeholder="{{ __('Type Address') }}" rows="4">{{ old('address') ?? settings('address') }}</textarea>
                            @error('address')
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

@endsection
