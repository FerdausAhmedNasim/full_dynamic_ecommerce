@extends('admin.pages.config.general_settings.layout.master')

@section('title', 'Settlement')
@section('settlement', 'active')

@section('settingsContent')

    <form method="post" action="{{ route('admin.config.general_settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="p-sm-3">

                    <input type="hidden" name="settlement" value="settlement">

                    <div class="form-group row @error('first_settlement_date') error @enderror">
                        <label class="col-sm-3 required col-form-label ">{{ __('First settlement date') }}</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-4">
                                <input required type="number" min="1" max="15" name="first_settlement_date" value="{{old('first_settlement_date') ?? settings('first_settlement_date') }}" class="form-control"
                                    placeholder="{{ __('First settlement date') }}">
                            </div>
                            @error('first_settlement_date')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('second_settlement_date') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Second settlement date') }}</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-4">
                                <input required type="number" min="16" max="31" name="second_settlement_date" value="{{old('second_settlement_date') ?? settings('second_settlement_date') }}" class="form-control"
                                    placeholder="{{ __('Second settlement date') }}">
                            </div>
                            @error('second_settlement_date')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
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
